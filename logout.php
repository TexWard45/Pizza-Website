<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}

if (isset($_SESSION['username'])) {
    unset($_SESSION['username']);
}
header("Location: /index.php");
exit();
?>