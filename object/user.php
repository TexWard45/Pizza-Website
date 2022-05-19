<?php
class User {
    private $username;
    private $groupId;
    private $fullname;
    private $birth;
    private $address;
    private $phone;
    private $email;

    public function __construct($username, $groupId, $fullname, $birth, $address, $phone, $email) {
        $this->username = $username;
        $this->groupId = $groupId;
        $this->fullname = $fullname;
        $this->birth = $birth;
        $this->address = $address;
        $this->phone = $phone;
        $this->email = $email;
    }

    public function getUsername() { return $this->username; }
    public function setUsername($username) { $this->username = $username; return $this; }
    public function getGroupId() { return $this->groupId; }
    public function setGroupId($groupId) { $this->groupId = $groupId; return $this; }
    public function getFullname() {return $this->fullname; }
    public function setFullname($fullname) {$this->fullname = $fullname; return $this; }
    public function getBirth() { return $this->birth; }
    public function setBirth($birth) { $this->birth = $birth; return $this; }
    public function getAddress() { return $this->address; }
    public function setAddress($address) { $this->address = $address; return $this; }
    public function getPhone() { return $this->phone; }  
    public function setPhone($phone) { $this->phone = $phone; return $this; }
    public function getEmail() { return $this->email; }
    public function setEmail($email) { $this->email = $email; return $this; }

    public static function add($user, $password) {
        global $connection;

        $username = $user->getUsername();
        $groupId = $user->getGroupId();
        $password = password_hash($password, PASSWORD_DEFAULT);
        $fullname = $user->getFullname();
        $birth = $user->getBirth();
        $address = $user->getAddress();
        $phone = $user->getPhone();
        $email = $user->getEmail();

        $sql = "INSERT INTO `user`(username, group_id, password, fullname, birth, address, phone, email) VALUES
                ('$username', $groupId, '$password', '$fullname', '$birth', '$address', '$phone', '$email')";

        if ($connection->query($sql)) {
            return $connection->insert_id;
        }
        return 0;
    }

    public static function isFullInformation($username) {
        $user = User::getByUsername($username);

        if (empty($user->getFullname()) || empty($user->getBirth()) || empty($user->getAddress()) || empty($user->getPhone()) || empty($user->getEmail())) {
            return false;
        }
        return true;
    }

    public static function update($user) {
        global $connection;

        $username = $user->getUsername();
        $groupId = $user->getGroupId();
        $fullname = $user->getFullname();
        $birth = $user->getBirth();
        $address = $user->getAddress();
        $phone = $user->getPhone();
        $email = $user->getEmail();

        $sql = "UPDATE user
                SET group_id = $groupId, fullname = '$fullname', birth = '$birth', address = '$address', phone = '$phone', email = '$email'
                WHERE username = '$username'";

        $connection->query($sql);
    }

    public static function updatePassword($username, $password) {
        global $connection;

        $password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "UPDATE user
                SET password = '$password'
                WHERE username = '$username'";

        $connection->query($sql);
    }

    public static function check($username, $password) {
        global $connection;

        $sql = "SELECT * FROM user WHERE username='$username'";
		
		$result = $connection->query($sql);

		$array = toArray($result);
		
		return count($array) > 0 ? password_verify($password, $array[0]['password']) : false;
    }

    public static function getBySearch($username) {
        global $connection;

        $sql = "SELECT * FROM user WHERE username LIKE '%$username%'";
		
		$result = $connection->query($sql);

        $arr = array();

        if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$obj = new User($row['username'], $row['group_id'], $row['fullname'], $row['birth'], $row['address'], $row['phone'], $row['email']);
                array_push($arr, $obj);
			}
		}
	
        return $arr;
    }

    public static function getAll() {
        global $connection;

        $sql = "SELECT * FROM user";
		
		$result = $connection->query($sql);

        $arr = array();

        if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$obj = new User($row['username'], $row['group_id'], $row['fullname'], $row['birth'], $row['address'], $row['phone'], $row['email']);
                array_push($arr, $obj);
			}
		}
	
        return $arr;
    }

    public static function getByUsername($username) {
        global $connection;

        $sql = "SELECT * FROM user WHERE username = '$username'";
		
		$result = $connection->query($sql);

        if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				return new User($row['username'], $row['group_id'], $row['fullname'], $row['birth'], $row['address'], $row['phone'], $row['email']);
			}
		}
	
        return null;
    }

    public static function hasUsername($username) {
        global $connection;
        
		$sql = "SELECT * FROM user WHERE username='$username'";
		
		$result = $connection->query($sql);

		$array = toArray($result);

		return count($array) > 0;
	}

    public static function hasPermission($username, $permission) {
        if (User::hasUsername($username)) {
            $user = User::getByUsername($username);

            $userPermission = UserPermission::getByUsername($username, $permission);
            
            if (!is_null($userPermission)) {
                return $userPermission->getValue();
            }
            
            $groupPermission = GroupPermission::getByGroup($user->getGroupId(), $permission);

            return is_null($groupPermission) ? false : $groupPermission->getValue();
        }else {
            $groupPermission = GroupPermission::getByGroup(1, $permission);

            return is_null($groupPermission) ? false : $groupPermission->getValue();
        }
        return false;
    }
}
class UserPermission {
    private $id;
    private $username;
    private $permission;
    private $value;

    public function __construct($id, $username, $permission, $value) {
        $this->id = $id;
        $this->username = $username;
        $this->permission = $permission;
        $this->value = $value;
    }

    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; return $this; }
    public function getUsername() { return $this->username; }
    public function setUsername($username) { $this->username = $username; return $this; }
    public function getPermission() { return $this->permission; }
    public function setPermission($permission) { $this->permission = $permission; return $this; }
    public function getValue() { return $this->value; }
    public function setValue($value) { $this->value = $value; return $this; }

    public static function isSet($username, $permission) {
        global $connection;

        $sql = "SELECT * FROM user_permission WHERE username='$username' AND permission='$permission'";

        $result = $connection->query($sql);

        return $result->num_rows > 0;
    }

    public static function has($username, $permission) {
        return UserPermission::getByUsername($username, $permission)->getValue();
    }

    public static function set($username, $permission, $value) {
        global $connection;

        if (intval($value) == -1) {
            $sql = "DELETE FROM user_permission WHERE username='$username' AND permission='$permission'";
            $connection->query($sql);
            return;
        }

        $sql = "SELECT * FROM user_permission WHERE username='$username' AND permission='$permission'";
        $result = $connection->query($sql);

        if ($result->num_rows > 0) {
            $sql = "UPDATE user_permission SET value = '$value' WHERE username = '$username' AND permission = '$permission'";
            $connection->query($sql);
        }else {
            $sql = "INSERT INTO user_permission(username, permission, value) VALUES ('$username', '$permission', '$value')";
            $connection->query($sql);
        }
    }

    public static function getByUsername($username, $permission) {
        global $connection;

		$sql = "SELECT * FROM user_permission WHERE username='$username' AND permission='$permission'";
		
        $result = $connection->query($sql);

        if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
                return new UserPermission($row['id'], $row['username'], $row['permission'], $row['value']);
			}
		}

		return null;
	}
}
?>