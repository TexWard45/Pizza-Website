<?php
class Order {
    private $id;
    private $customer;
    private $handler;
    private $totalPrice;
    private $quantity;
    private $fullname;
    private $address;
    private $phone;
    private $paymentType;
    private $orderType;
    private $orderTime;
    private $note;

    public function __construct($id, $customer, $handler, $totalPrice, $quantity, $fullname, $address, $phone, $paymentType, $orderType, $orderTime, $note) {
        $this->id = $id;
        $this->customer = $customer;
        $this->handler = $handler;
        $this->totalPrice = $totalPrice;
        $this->quantity = $quantity;
        $this->fullname = $fullname;
        $this->address = $address;
        $this->phone = $phone;
        $this->paymentType = $paymentType;
        $this->orderType = $orderType;
        $this->orderTime = $orderTime;
        $this->note = $note;
    }

    public function getId() { return $this->id; } 
    public function setId($id) { $this->id = $id; return $this; }
    public function getCustomer() { return $this->customer; }
    public function setCustomer($customer) { $this->customer = $customer; return $this; }
    public function getHandler() { return $this->handler; } 
    public function setHandler($handler) { $this->handler = $handler; return $this; }
    public function getTotalPrice() { return $this->totalPrice; }
    public function setTotalPrice($totalPrice) { $this->totalPrice = $totalPrice; return $this; }
    public function getQuantity() { return $this->quantity; }
    public function setQuantity($quantity) { $this->quantity = $quantity; return $this; }
    public function getFullname() { return $this->fullname; }
    public function setFullname($fullname) { $this->fullname = $fullname; return $this; }
    public function getAddress() { return $this->address; }
    public function setAddress($address) { $this->address = $address; return $this; }
    public function getPhone() { return $this->phone; }
    public function setPhone($phone) { $this->phone = $phone; return $this;}
    public function getPaymentType() { return $this->paymentType; }
    public function setPaymentType($paymentType) { $this->paymentType = $paymentType; return $this;}
    public function getOrderType() { return $this->orderType; }
    public function setOrderType($orderType) { $this->orderType = $orderType; return $this;}
    public function getOrderTime() { return $this->orderTime; }
    public function setOrderTime($orderTime) { $this->orderTime = $orderTime; return $this;}
    public function getNote() { return $this->note; }
    public function setNote($note) { $this->note = $note; return $this;}

    public static function add($order) {
        global $connection;

        $customer = $order->getCustomer();
        $totalPrice = $order->getTotalPrice();
        $quantity = $order->getQuantity();
        $fullname = $order->getFullname();
        $address = $order->getAddress();
        $phone = $order->getPhone();
        $paymentType = $order->getPaymentType();
        $orderType = $order->getOrderType();
        $orderTime = $order->getOrderTime();
        $note = $order->getNote();

        $sql = "INSERT INTO `order`(customer, handler, total_price, quantity, fullname, address, phone, payment_type, order_type, order_time, note)
                VALUES ('$customer', null,'$totalPrice','$quantity', '$fullname', '$address', '$phone', '$paymentType', '$orderType', '$orderTime', '$note')";

        if ($connection->query($sql)) {
            return $connection->insert_id;
        }
        return 0;
    }

    public static function getByUsername($username) {
        global $connection;

        $sql = "SELECT * FROM `order` WHERE customer = '$username' ORDER BY id DESC";

        $result = $connection->query($sql);

        $arr = array();

        if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$obj = new Order($row['id'], $row['customer'], $row['handler'], $row['total_price'], $row['quantity'], $row['fullname'], $row['address'], $row['phone'], $row['payment_type'], $row['order_type'], $row['order_time'], $row['note']);
                array_push($arr, $obj);
			}
		}
	
        return $arr;
    }

    public static function getById($id) {
        global $connection;

        $sql = "SELECT * FROM `order` WHERE id = '$id'";

        $result = $connection->query($sql);

        if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				return new Order($row['id'], $row['customer'], $row['handler'], $row['total_price'], $row['quantity'], $row['fullname'], $row['address'], $row['phone'], $row['payment_type'], $row['order_type'], $row['order_time'], $row['note']);
			}
		}
	
        return null;
    }

    public static function getAll() {
        global $connection;

        $sql = "SELECT * FROM `order`";

        $result = $connection->query($sql);

        $arr = array();

        if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$obj = new Order($row['id'], $row['customer'], $row['handler'], $row['total_price'], $row['quantity'], $row['fullname'], $row['address'], $row['phone'], $row['payment_type'], $row['order_type'], $row['order_time'], $row['note']);
                array_push($arr, $obj);
			}
		}
	
        return $arr;
    }

    public static function getByUsernameAndId($username, $orderId) {
        global $connection;

        $sql = "SELECT * FROM `order` WHERE customer = '$username' AND id = $orderId ORDER BY id DESC";

        $result = $connection->query($sql);

        if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				return new Order($row['id'], $row['customer'], $row['handler'], $row['total_price'], $row['quantity'], $row['fullname'], $row['address'], $row['phone'], $row['payment_type'], $row['order_type'], $row['order_time'], $row['note']);
			}
		}
	
        return null;
    }

    public static function getBySearch($startdate, $enddate) {
        global $connection;

        if (!empty($startdate) && !empty($enddate)) {
            $sql = "SELECT * FROM `order` INNER JOIN status_detail ON order.id = status_detail.order_id WHERE status_id = 1 AND time_created >= '$startdate' AND time_created <= '$enddate'";
        }else if (!empty($startdate)) {
            $sql = "SELECT * FROM `order` INNER JOIN status_detail ON order.id = status_detail.order_id WHERE status_id = 1 AND time_created >= '$startdate'";
        }else if (!empty($enddate)) {
            $sql = "SELECT * FROM `order` INNER JOIN status_detail ON order.id = status_detail.order_id WHERE status_id = 1 AND time_created <= '$enddate'";
        }
		
		$result = $connection->query($sql);

        $arr = array();

        if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$obj = new Order($row['id'], $row['customer'], $row['handler'], $row['total_price'], $row['quantity'], $row['fullname'], $row['address'], $row['phone'], $row['payment_type'], $row['order_type'], $row['order_time'], $row['note']);
                array_push($arr, $obj);
			}
		}
	
        return $arr;
    }
}

class OrderDetail {
    private $id;
    private $orderId;
    private $pizzaDetailId;
    private $price;
    private $quantity;

    public function __construct($id, $orderId, $pizzaDetailId, $price, $quantity) {
        $this->id = $id;
        $this->orderId = $orderId;
        $this->pizzaDetailId = $pizzaDetailId;
        $this->price = $price;
        $this->quantity = $quantity;
    }

    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; return $this; }
    public function getOrderId() { return $this->orderId; }
    public function setOrderId($orderId) { $this->orderId = $orderId; return $this; }
    public function getPizzaDetailId() { return $this->pizzaDetailId; }
    public function setPizzaDetailId($pizzaDetailId) { $this->pizzaDetailId = $pizzaDetailId; return $this; }
    public function getPrice() { return $this->price; }
    public function setPrice($price) { $this->price = $price; return $this; }
    public function getQuantity() { return $this->quantity; }
    public function setQuantity($quantity) { $this->quantity = $quantity; return $this; }

    public static function add($orderDetail) {
        global $connection;

        $orderId = $orderDetail->getOrderId();
        $pizzaDetailId = $orderDetail->getPizzaDetailId();
        $price = $orderDetail->getPrice();
        $quantity = $orderDetail->getQuantity();

        $sql = "INSERT INTO order_detail(order_id, pizza_detail_id, price, quantity)
                VALUES ('$orderId','$pizzaDetailId','$price', '$quantity')";

        $connection->query($sql);
    }

    public static function getByOrderId($orderId) {
        global $connection;

        $sql = "SELECT * FROM `order_detail` WHERE order_id = $orderId ORDER BY id DESC";

        $result = $connection->query($sql);

        $arr = array();

        if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$obj = new OrderDetail($row['id'], $row['order_id'], $row['pizza_detail_id'], $row['price'], $row['quantity']);
                array_push($arr, $obj);
			}
		}
	
        return $arr;
    }
}

class Status {
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

        $sql = "SELECT * FROM `status` WHERE id = $id";

        $result = $connection->query($sql);

        if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				return new Status($row['id'], $row['display']);
			}
		}
	
        return null;
    }
}

class StatusDetail {
    private $orderId;
    private $statusId;
    private $timeCreated;
    
    public function __construct($orderId, $statusId, $timeCreated) {
        $this->orderId = $orderId;
        $this->statusId = $statusId;
        $this->timeCreated = $timeCreated;
    }

    public function getOrderId() { return $this->orderId; }
    public function setOrderId($orderId) { $this->orderId = $orderId; return $this; }
    public function getStatusId() { return $this->statusId; } 
    public function setStatusId($statusId) { $this->statusId = $statusId; return $this; }
    public function getTimeCreated() { return $this->timeCreated; } 
    public function setTimeCreated($timeCreated) { $this->timeCreated = $timeCreated; return $this; }

    public static function add($statusDetail) {
        global $connection;

        $orderId = $statusDetail->getOrderId();
        $statusId = $statusDetail->getStatusId();
        $datetime = getCurrentDateTime();

        $sql = "INSERT INTO status_detail(order_id, status_id, time_created)
                VALUES ('$orderId','$statusId','$datetime')";

        $connection->query($sql);
    }

    public static function getByStatusId($orderId, $statusId) {
        global $connection;

        $sql = "SELECT * FROM `status_detail` WHERE order_id = '$orderId' AND status_id = $statusId";

        $result = $connection->query($sql);

        if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				return new StatusDetail($row['order_id'], $row['status_id'], $row['time_created']);
			}
		}
	
        return null;
    }

    public static function getFirstStatusDetail($orderId) {
        global $connection;

        $sql = "SELECT * FROM `status_detail` WHERE order_id = '$orderId' ORDER BY status_id ASC";

        $result = $connection->query($sql);

        if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				return new StatusDetail($row['order_id'], $row['status_id'], $row['time_created']);
			}
		}
	
        return null;
    }

    public static function getLastStatusDetail($orderId) {
        global $connection;

        $sql = "SELECT * FROM `status_detail` WHERE order_id = '$orderId' ORDER BY status_id DESC";

        $result = $connection->query($sql);

        if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				return new StatusDetail($row['order_id'], $row['status_id'], $row['time_created']);
			}
		}
	
        return null;
    }
}
?>