<?php
include('../api.php');
include('../connection.php');
include('../object/user.php');
include('../object/group.php');

if(session_status() == PHP_SESSION_NONE){
    session_start();
}

if (isset($_POST['username']) && isset($_POST['password'])) {
    if (User::check($_POST['username'], $_POST['password'])) {
        if (User::hasPermission($_POST['username'], 'lock')) {
            echo 'lock';
            exit();
        }

        $_SESSION['username'] = $_POST['username'];
        echo 'success';
        exit();
    }
}
echo 'fail';
exit();
?>