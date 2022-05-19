<?php
class Group {
    private $id;
    private $display;

    public function __construct($id, $display) {
        $this->id = $id;
        $this->display = $display;
    }

    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; return $this; }
    public function getDisplay() { return $this->display; }
    public function setDisplay($display) { $this->display = $display; return $this; }

    public static function getById($id) {
        global $connection;

        $sql = "SELECT * FROM `group` WHERE id = '$id'";
		
		$result = $connection->query($sql);

        if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				return new Group($row['id'], $row['display']);
			}
		}
	
        return null;
    }

    public static function getAll() {
        global $connection;

        $sql = "SELECT * FROM `group` ORDER BY id ASC";
		
		$result = $connection->query($sql);

        $arr = array();

        if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$obj = new Group($row['id'], $row['display']);
                array_push($arr, $obj);
			}
		}
	
        return $arr;
    }

    public static function getBySearch($display) {
        global $connection;

        $sql = "SELECT * FROM `group` WHERE display LIKE '%$display%'";
		
		$result = $connection->query($sql);

        $arr = array();

        if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$obj = new Group($row['id'], $row['display']);
                array_push($arr, $obj);
			}
		}
	
        return $arr;
    }
}
class GroupPermission {
    private $id;
    private $groupId;
    private $permission;
    private $value;

    public function __construct($id, $groupId, $permission, $value) {
        $this->id = $id;
        $this->groupId = $groupId;
        $this->permission = $permission;
        $this->value = $value;
    }

    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; return $this; }
    public function getGroupId() { return $this->groupId; }
    public function setGroupId($groupId) { $this->groupId = $groupId; return $this; }
    public function getPermission() { return $this->permission; }
    public function setPermission($permission) { $this->permission = $permission; return $this; }
    public function getValue() { return $this->value; }
    public function setValue($value) { $this->value = $value; return $this; }

    public static function getByGroup($groupId, $permission) {
        global $connection;

		$sql = "SELECT * FROM group_permission WHERE `group_id`='$groupId' AND permission='$permission'";
		
        $result = $connection->query($sql);

        if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
                return new GroupPermission($row['id'], $row['group_id'], $row['permission'], $row['value']);
			}
		}

		return null;
	}

    public static function isSet($id, $permission) {
        global $connection;

        $sql = "SELECT * FROM group_permission WHERE group_id='$id' AND permission='$permission'";

        $result = $connection->query($sql);

        return $result->num_rows > 0;
    }

    public static function has($id, $permission) {
        return GroupPermission::getByGroup($id, $permission)->getValue();
    }

    public static function set($groupId, $permission, $value) {
        global $connection;

        $sql = "SELECT * FROM group_permission WHERE group_id='$groupId' AND permission='$permission'";
        $result = $connection->query($sql);

        if ($result->num_rows > 0) {
            $sql = "UPDATE group_permission SET value = '$value' WHERE group_id = '$groupId' AND permission = '$permission'";
            $connection->query($sql);
        }else {
            $sql = "INSERT INTO group_permission(group_id, permission, value) VALUES ('$groupId', '$permission', '$value')";
            $connection->query($sql);
        }
    }

}
?>