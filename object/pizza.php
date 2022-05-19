<?php
class Pizza {
    private $id;
    private $categoryId;
    private $display;
    private $description;
    private $image;

    public function __construct($id, $categoryId, $display, $description, $image) {
        $this->id = $id;
        $this->categoryId = $categoryId;
        $this->display = $display;
        $this->description = $description;
        $this->image = $image;
    }

    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; return $this; }
    public function getCategoryId() { return $this->categoryId; } 
    public function setCategoryId($categoryId) { $this->categoryId = $categoryId; return $this; }
    public function getDisplay() { return $this->display; }
    public function setDisplay($display) { $this->display = $display; return $this; }
    public function getDescription() { return $this->description; }
    public function setDescription($description) { $this->description = $description; return $this; }
    public function getImage() { return $this->image; }
    public function setImage($image) { $this->image = $image; return $this; }

    public static function getByFilter($category, $toppingArr, $notToppingArr, $search) {
        global $connection;

        $sql = "SELECT * FROM pizza inner join topping_detail on pizza.id = topping_detail.pizza_id";

        $wheres = array();

        if ($category != 'all') {
            array_push($wheres, "category_id = '$category'");
        }

        if (count($toppingArr) > 0 && $toppingArr[0] != 'all') {
            array_push($wheres, "topping_detail.topping_id IN ('".join("','", $toppingArr)."')");
        }

        if (isset($search)) {
            array_push($wheres, "display LIKE '%".$search."%'");
        }
        
        $sql = $sql." WHERE ".join(" AND ", $wheres)." GROUP BY pizza.id";

        $result = $connection->query($sql);

		$arr = array();

        if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$obj = new Pizza($row['id'], $row['category_id'], $row['display'], $row['description'], $row['image']);
                array_push($arr, $obj);
			}
		}

        $newArr = array();
        foreach ($arr as $obj) {
            $id = $obj->getId();
            $sql = "SELECT * FROM pizza inner join topping_detail on pizza.id = topping_detail.pizza_id WHERE pizza.id= '$id'";
            $find = false;

            $result = $connection->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    if (in_array($row['topping_id'], $notToppingArr)) {
                        $find = true;
                        break;
                    }
                }
            }

            if ($find) {
                continue;
            }
            array_push($newArr, $obj);
        }

        return $newArr;
    }

    public static function getAll() {
        global $connection;

        $sql = "SELECT * FROM pizza";
		
		$result = $connection->query($sql);

		$arr = array();

        if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$obj = new Pizza($row['id'], $row['category_id'], $row['display'], $row['description'], $row['image']);
                array_push($arr, $obj);
			}
		}
	
        return $arr;
    }

    public static function getById($id) {
        global $connection;

        $sql = "SELECT * FROM pizza WHERE id = $id";
		
		$result = $connection->query($sql);

        if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				return new Pizza($row['id'], $row['category_id'], $row['display'], $row['description'], $row['image']);
			}
		}
	
        return null;
    }

    public static function getByCategoryId($categoryId) {
        global $connection;

        $sql = "SELECT * FROM pizza WHERE category_id = $categoryId";
		
		$result = $connection->query($sql);

        $arr = array();

        if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$obj = new Pizza($row['id'], $row['category_id'], $row['display'], $row['description'], $row['image']);
                array_push($arr, $obj);
			}
		}
	
        return $arr;
    }

    public static function getBySearch($display) {
        global $connection;

        $sql = "SELECT * FROM `pizza` WHERE display LIKE '%$display%'";
		
		$result = $connection->query($sql);

        $arr = array();

        if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$obj = new Pizza($row['id'], $row['category_id'], $row['display'], $row['description'], $row['image']);
                array_push($arr, $obj);
			}
		}
	
        return $arr;
    }
}
?>