<?php
include($_SERVER['DOCUMENT_ROOT'].'/connection.php');
include($_SERVER['DOCUMENT_ROOT'].'/api.php');
include($_SERVER['DOCUMENT_ROOT'].'/object/group.php');
include($_SERVER['DOCUMENT_ROOT'].'/object/user.php');
include($_SERVER['DOCUMENT_ROOT'].'/object/cart.php');
include($_SERVER['DOCUMENT_ROOT'].'/object/category.php');
include($_SERVER['DOCUMENT_ROOT'].'/object/topping.php');
include($_SERVER['DOCUMENT_ROOT'].'/object/pizza.php');
include($_SERVER['DOCUMENT_ROOT'].'/object/size.php');
include($_SERVER['DOCUMENT_ROOT'].'/object/base.php');
include($_SERVER['DOCUMENT_ROOT'].'/object/order.php');
include($_SERVER['DOCUMENT_ROOT'].'/object/pizza_detail.php');

if(session_status() == PHP_SESSION_NONE){
    session_start();
}

$handler = $_SESSION['username'];
$id = $_POST['id'];

$lastStatusDetail = StatusDetail::getLastStatusDetail($id);

$currentStatusId = $lastStatusDetail->getStatusId();
$nextStatusId = $lastStatusDetail->getStatusId() + 1;

if ($nextStatusId > 2 && $nextStatusId <= 6) {
    $sql = "SELECT handler FROM `order` WHERE id = $id";

    $result = $connection->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $oldHandler = $row['handler'];
        }
    }

    if ($handler != $oldHandler) {
        echo "not_same_handler";
        exit();
    }
	

    StatusDetail::add(new StatusDetail($id, $nextStatusId, null));
    echo "success";
    exit();
}

if ($currentStatusId == 6) {
    echo "already_done";
    exit();
}

if ($currentStatusId == 7) {
    echo "deny";
    exit();
}

$orderDetails = OrderDetail::getByOrderId($id); 

foreach ($orderDetails as $orderDetail) {
$pizzaDetail = PizzaDetail::getById($orderDetail->getPizzaDetailId());

if ($pizzaDetail->getQuantity() - $orderDetail->getQuantity() < 0) {
echo "not_enough";
exit();
}
}

foreach ($orderDetails as $orderDetail) {
$pizzaDetailId = $orderDetail->getPizzaDetailId();
$quantity = $orderDetail->getQuantity();
$sql = "UPDATE pizza_detail SET quantity = quantity - $quantity WHERE id = $pizzaDetailId";
$connection->query($sql);
}

$sql = "UPDATE `order` SET handler = '$handler' WHERE id = $id";
$connection->query($sql);

StatusDetail::add(new StatusDetail($id, 2, null));

echo "success";
exit();
?>