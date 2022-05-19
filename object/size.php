<?php
class Size {
    private $id;
    private $display;
    private $priority;

    public function __construct($id, $display, $priority) {
        $this->id = $id;
        $this->display = $display;
        $this->priority = $priority;
    }

    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; return $this; }
    public function getDisplay() { return $this->display; }
    public function setDisplay($display) { $this->display = $display; return $this; }
    public function getPriority() { return $this->priority; }
    public function setPriority($priority) { $this->priority = $priority; return $this; }

    public static function getAll() {
        global $connection;

        $sql = "SELECT * FROM size ORDER BY priority ASC";
		
		$result = $connection->query($sql);

		$arr = array();

        if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$obj = new Size($row['id'], $row['display'], $row['priority']);
                array_push($arr, $obj);
			}
		}
	
        return $arr;
    }

    public static function getById($id) {
        global $connection;

        $sql = "SELECT * FROM size WHERE id = $id ORDER BY priority ASC";
		
		$result = $connection->query($sql);

        if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				return new Size($row['id'], $row['display'], $row['priority']);
			}
		}
	
        return null;
    }

    public static function getAllByPizzaId($id) {
        global $connection;

        $sql = "SELECT DISTINCT size.id, size.display, size.priority
                FROM size 
                    INNER JOIN pizza_detail on size.id = pizza_detail.size_id 
                    INNER JOIN pizza on pizza_detail.pizza_id = pizza.id
                WHERE pizza.id = $id ORDER BY priority ASC";
		
		$result = $connection->query($sql);

        $arr = array();

        if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$obj = new Size($row['id'], $row['display'], $row['priority']);
                array_push($arr, $obj);
			}
		}
	
        return $arr;
    }

    public static function getBySearch($display) {
        global $connection;

        $sql = "SELECT * FROM `size` WHERE display LIKE '%$display%' ORDER BY priority ASC";
		
		$result = $connection->query($sql);

        $arr = array();

        if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$obj = new Size($row['id'], $row['display'], $row['priority']);
                array_push($arr, $obj);
			}
		}
	
        return $arr;
    }
}
?>