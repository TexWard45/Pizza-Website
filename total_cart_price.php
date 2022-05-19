<?php
include($_SERVER['DOCUMENT_ROOT'].'/connection.php');
include($_SERVER['DOCUMENT_ROOT'].'/api.php');
include($_SERVER['DOCUMENT_ROOT'].'/object/cart.php');
include($_SERVER['DOCUMENT_ROOT'].'/object/pizza_detail.php');

if(session_status() == PHP_SESSION_NONE){
    session_start();
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

$totalPrice = 0;

foreach ($_SESSION['cart'] as $item) {
    $pizza_detail = PizzaDetail::getBySizeBasePizzaId($item->getSizeId(), $item->getBaseId(), $item->getPizzaId());
    $totalPrice +=  $pizza_detail->getPrice() * $item->getQuantity();
}

echo toMoney($totalPrice);
exit();
?>