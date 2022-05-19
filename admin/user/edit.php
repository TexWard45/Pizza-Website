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
$group_id = $_POST['group_id'];
$fullname = $_POST['fullname'];
$birth = $_POST['birth'];
$address = $_POST['address'];
$phone = $_POST['phone'];
$email = $_POST['email'];

$sql = "UPDATE user
        SET group_id = $group_id, fullname = '$fullname', birth = '$birth', address = '$address', phone = '$phone', email = '$email'
        WHERE username = '$username'";

$connection->query($sql);

if (isset($_POST['password'])) {
$password = $_POST['password'];
$password = password_hash($password, PASSWORD_DEFAULT);
$sql = "UPDATE user
        SET password = '$password'
        WHERE username = '$username'";
echo "$sql";
$connection->query($sql);
}

echo "success";
exit();
?>