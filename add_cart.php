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

if (isset($_POST["pizza_id"]) && isset($_POST["size_id"]) && isset($_POST["base_id"])) {
    $current = new Cart($_POST["pizza_id"], $_POST["size_id"], $_POST["base_id"], 0);

    $find = false;
    if (count($_SESSION['cart']) > 0) {
        foreach($_SESSION['cart'] as $item) {
            if ($item->getPizzaId() == $current->getPizzaId() && $item->getSizeId() == $current->getSizeId() && $item->getBaseId() == $current->getBaseId()) {
                $current = $item;
                $find = true;
            }
        }
    }

    if (!$find) {
        array_push($_SESSION['cart'], $current);
    }

    if ($current->getQuantity() + 1 > 9) {
        echo "exceedlimit";
        exit();
    }else {
        $current->setQuantity($current->getQuantity() + 1);
    }
    echo "success";
    exit();
}
?>