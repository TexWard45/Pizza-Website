<?php
include($_SERVER['DOCUMENT_ROOT'].'/connection.php');
include($_SERVER['DOCUMENT_ROOT'].'/api.php');
include($_SERVER['DOCUMENT_ROOT'].'/object/cart.php');

if(session_status() == PHP_SESSION_NONE){
    session_start();
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

$count = 0;

foreach ($_SESSION['cart'] as $item) {
    $count += $item->getQuantity();
}

echo $count;
exit();
?>