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

$sql = "SELECT * FROM user WHERE username = '$username'";

$result = $connection->query($sql);

if ($result->num_rows > 0) {
    echo "conflict";
    exit();
}

$username = $_POST['username'];
$group_id = $_POST['group_id'];
$password = $_POST['password'];
$password = password_hash($password, PASSWORD_DEFAULT);
$fullname = $_POST['fullname'];
$birth = $_POST['birth'];
$address = $_POST['address'];
$phone = $_POST['phone'];
$email = $_POST['email'];

$sql = "INSERT INTO user(username, group_id, password, fullname, birth, address, phone, email) 
        VALUES('$username', '$group_id', '$password', '$fullname', '$birth', '$address', '$phone', '$email')";
$connection->query($sql);
echo "success";
exit();
?>