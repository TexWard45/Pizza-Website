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

$id = $_POST['id'];

$lastStatusDetail = StatusDetail::getLastStatusDetail($id);

if ($lastStatusDetail->getStatusId() == 6) {
    echo "already_done";
    exit();
}

if ($lastStatusDetail->getStatusId() == 7) {
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

echo "success";
exit();
?>