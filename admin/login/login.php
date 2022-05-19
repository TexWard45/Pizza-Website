<?php
include($_SERVER['DOCUMENT_ROOT'].'/connection.php');
include($_SERVER['DOCUMENT_ROOT'].'/api.php');
include($_SERVER['DOCUMENT_ROOT'].'/object/group.php');
include($_SERVER['DOCUMENT_ROOT'].'/object/user.php');

if(session_status() == PHP_SESSION_NONE){
    session_start();
}

if (isset($_POST['username']) && isset($_POST['password'])) {
    if (User::check($_POST['username'], $_POST['password'])) {
        $_SESSION['username'] = $_POST['username'];
        echo 'success';
        exit();
    }
}

echo 'fail';
exit();
?>