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

if (isset($_POST['pizza_id']) && isset($_POST['size_id']) && isset($_POST['base_id'])) {
    $current = new Cart($_POST["pizza_id"], $_POST["size_id"], $_POST["base_id"], 0);

    if (count($_SESSION['cart']) > 0) {
        foreach($_SESSION['cart'] as $item) {
            if ($item->getPizzaId() == $current->getPizzaId() && $item->getSizeId() == $current->getSizeId() && $item->getBaseId() == $current->getBaseId()) {
                echo toMoney($item->getQuantity() * PizzaDetail::getBySizeBasePizzaId($item->getSizeId(), $item->getBaseId(), $item->getPizzaId())->getPrice());
                exit();
            }
        }
    }
}
exit();
?>