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

$id_array = $_POST['id_array'];

$wheres = array();
foreach($id_array as $id) {
array_push($wheres, "id = '$id'");
}

foreach($id_array as $id) {
$sql = "SELECT * FROM pizza_detail WHERE size_id = $id";

$result = $connection->query($sql);

if ($result->num_rows > 0) {
echo "exists";
exit();
}
}

$sql = "DELETE FROM `size` WHERE ".join(" OR ", $wheres);
$connection->query($sql);

echo "success";
exit();
?>