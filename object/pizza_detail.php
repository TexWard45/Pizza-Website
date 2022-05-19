<?php
class PizzaDetail {
    private $id;
    private $pizzaId;
    private $sizeId;
    private $baseId;
    private $price;
    private $quantity;

    public function __construct($id, $pizzaId, $sizeId, $baseId, $price, $quantity) {
        $this->id = $id;
        $this->pizzaId = $pizzaId;
        $this->sizeId = $sizeId;
        $this->baseId = $baseId;
        $this->price = $price;
        $this->quantity = $quantity;
    }

    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; return $this; }
    public function getPizzaId() { return $this->pizzaId; } 
    public function setPizzaId($pizzaId) { $this->pizzaId = $pizzaId; return $this; }
    public function getSizeId() { return $this->sizeId;}
    public function setSizeId($sizeId) { $this->sizeId = $sizeId; return $this; }
    public function getBaseId() { return $this->baseId; } 
    public function setBaseId($baseId) { $this->baseId = $baseId; return $this; }
    public function getPrice() { return $this->price; }
    public function setPrice($price) { $this->price = $price; return $this; }
    public function getQuantity() { return $this->quantity; }
    public function setQuantity($quantity) { $this->quantity = $quantity; return $this; }

    public static function getTotalQuantity($id) {
        global $connection;

        $sql = "SELECT *, SUM(quantity) as 'total_quantity' FROM pizza_detail WHERE pizza_id = $id GROUP BY pizza_id";

        $result = $connection->query($sql);

        if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				return new PizzaDetail($row['id'], $row['pizza_id'], $row['size_id'], $row['base_id'], $row['price'], $row['total_quantity']);
			}
		}

        return null;
    }

    public static function getAllByPizzaId($id) {
        global $connection;

        $sql = "SELECT * FROM pizza_detail WHERE pizza_id = $id";
		
		$result = $connection->query($sql);

		$arr = array();

        if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$obj = new PizzaDetail($row['id'], $row['pizza_id'], $row['size_id'], $row['base_id'], $row['price'], $row['quantity']);
                array_push($arr, $obj);
			}
		}
	
        return $arr;
    }

    public static function getBySizeBasePizzaId($size_id, $base_id, $pizza_id) {
        global $connection;

        $sql = "SELECT * FROM pizza_detail WHERE size_id = $size_id AND base_id = $base_id AND pizza_id = $pizza_id";
		
		$result = $connection->query($sql);

        if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				return new PizzaDetail($row['id'], $row['pizza_id'], $row['size_id'], $row['base_id'], $row['price'], $row['quantity']);
			}
		}
	
        return null;
    }

    public static function getById($id) {
        global $connection;

        $sql = "SELECT * FROM pizza_detail WHERE id = $id";
		
		$result = $connection->query($sql);

        if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				return new PizzaDetail($row['id'], $row['pizza_id'], $row['size_id'], $row['base_id'], $row['price'], $row['quantity']);
			}
		}
	
        return null;
    }
}
?>