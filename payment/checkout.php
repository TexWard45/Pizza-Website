<?php
include('../connection.php');
include('../api.php');
include('../object/user.php');
include('../object/cart.php');
include('../object/category.php');
include('../object/topping.php');
include('../object/pizza.php');
include('../object/size.php');
include('../object/base.php');
include('../object/pizza_detail.php');
include('../object/order.php');

if(session_status() == PHP_SESSION_NONE){
    session_start();
}

$customer = $_SESSION['username'];
$fullname = $_POST['fullname'];
$address = $_POST['address'];
$phone = $_POST['phone'];
$paymentType = $_POST['payment_type'];
$orderType = $_POST['order_type'];
$orderTime = $_POST['order_time'];
$note = $_POST['note'];
$totalPrice = 0;
$quantity = 0;
foreach ($_SESSION['cart'] as $item) {
    $pizzaDetail = PizzaDetail::getBySizeBasePizzaId($item->getSizeId(), $item->getBaseId(), $item->getPizzaId());
    $totalPrice += $item->getQuantity() * $pizzaDetail->getPrice();
    $quantity += $item->getQuantity();
}

$order = new Order(0, $customer, null, $totalPrice, $quantity, $fullname, $address, $phone, $paymentType, $orderType, $orderTime, $note);
$orderId = Order::add($order);

foreach ($_SESSION['cart'] as $item) {
    $pizzaDetail = PizzaDetail::getBySizeBasePizzaId($item->getSizeId(), $item->getBaseId(), $item->getPizzaId());
    $orderDetail = new OrderDetail(0, $orderId, $pizzaDetail->getId(), $pizzaDetail->getPrice(), $item->getQuantity()); 
    OrderDetail::add($orderDetail);
}

StatusDetail::add(new StatusDetail($orderId, 1, null));

$_SESSION['cart'] = array();
exit();
?>