<?php
class Base {
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

    public static function getAllByPizzaIdAndSizeId($pizza_id, $size_id) {
        global $connection;

        $sql = "SELECT DISTINCT base.id, base.display
                FROM base 
                    INNER JOIN pizza_detail on base.id = pizza_detail.base_id 
                    INNER JOIN pizza on pizza_detail.pizza_id = pizza.id
                WHERE pizza.id = $pizza_id AND pizza_detail.size_id = $size_id
                ORDER BY pizza_detail.price ASC";
		
		$result = $connection->query($sql);

        $arr = array();

        if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$obj = new Base($row['id'], $row['display']);
                array_push($arr, $obj);
			}
		}
	
        return $arr;
    }

    public static function getAll() {
        global $connection;

        $sql = "SELECT * FROM base ORDER BY id ASC";
		
		$result = $connection->query($sql);

		$arr = array();

        if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$obj = new Base($row['id'], $row['display']);
                array_push($arr, $obj);
			}
		}
	
        return $arr;
    }

    public static function getById($id) {
        global $connection;

        $sql = "SELECT * FROM base WHERE id = $id";
		
		$result = $connection->query($sql);

        if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				return new Base($row['id'], $row['display']);
			}
		}
	
        return null;
    }

    public static function getBySearch($display) {
        global $connection;

        $sql = "SELECT * FROM `base` WHERE display LIKE '%$display%'";
		
		$result = $connection->query($sql);

        $arr = array();

        if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$obj = new Base($row['id'], $row['display']);
                array_push($arr, $obj);
			}
		}
	
        return $arr;
    }
}
?>