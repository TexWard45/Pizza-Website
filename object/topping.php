<?php
class Topping {
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

    public static function getAll() {
        global $connection;

        $sql = "SELECT * FROM topping ORDER BY id ASC";
		
		$result = $connection->query($sql);

		$arr = array();

        if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$obj = new Topping($row['id'], $row['display']);
                array_push($arr, $obj);
			}
		}
	
        return $arr;
    }

    public static function getById($id) {
        global $connection;

        $sql = "SELECT * FROM `topping` WHERE id = '$id'";
		
		$result = $connection->query($sql);

        if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				return new Topping($row['id'], $row['display']);
			}
		}
	
        return null;
    }

    public static function getBySearch($display) {
        global $connection;

        $sql = "SELECT * FROM `topping` WHERE display LIKE '%$display%'";
		
		$result = $connection->query($sql);

        $arr = array();

        if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$obj = new Topping($row['id'], $row['display']);
                array_push($arr, $obj);
			}
		}
	
        return $arr;
    }
}
?>