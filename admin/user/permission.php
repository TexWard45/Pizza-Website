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
include($_SERVER['DOCUMENT_ROOT'].'/object/pizza_detail.php');

if(session_status() == PHP_SESSION_NONE){
    session_start();
}

$username = $_POST['username'];

UserPermission::set($username, "admin.login", $_POST['login_permission']);
UserPermission::set($username, "admin.group", $_POST['group_permission']);
UserPermission::set($username, "admin.user", $_POST['user_permission']);
UserPermission::set($username, "admin.category", $_POST['category_permission']);
UserPermission::set($username, "admin.topping", $_POST['topping_permission']);
UserPermission::set($username, "admin.size", $_POST['size_permission']);
UserPermission::set($username, "admin.base", $_POST['base_permission']);
UserPermission::set($username, "admin.pizza", $_POST['pizza_permission']);
UserPermission::set($username, "admin.order", $_POST['order_permission']);
UserPermission::set($username, "admin.statistic", $_POST['statistic_permission']);

echo "success";
exit();
?>