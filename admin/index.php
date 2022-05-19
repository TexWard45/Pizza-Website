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
include($_SERVER['DOCUMENT_ROOT'].'/object/order.php');

if(session_status() == PHP_SESSION_NONE){
    session_start();
}

if (!isset($_SESSION['username'])) {
    header("Location: /admin/login");
    exit();
}

if (!User::hasPermission($_SESSION['username'], 'admin.login')) {
    header("Location: /");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="/node_modules/jquery/dist/jquery.js"></script>
    <script src="/node_modules/@popperjs/core/dist/umd/popper.js"></script>
    <script src="/node_modules/bootstrap/dist/js/bootstrap.js"></script>
    <link rel="shortcut icon" type="image/ico" href="/img/logo.ico">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/node_modules/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" href="/node_modules/bootstrap-icons/font/bootstrap-icons.css">
    <title> Quản trị viên </title>
</head>

<style>
    body {
        margin: 0px;
    }

    .wrapper {
        width: 100%;
        height: 100vh;
        display: flex;
    }

    .left-menu {
        display: flex;
        justify-content: space-between;
        flex-direction: column;
        width: 190px;
        height: 100%;
        background-color: var(--bs-gray-dark);
    }

    .content {
        position: relative;
        flex: 1;
    }

    .operation {
        display: flex;
    }

    .operation > div {
        display: flex;
        padding: 0.5rem;
        width: 40px;
        height: 40px;
        justify-content: center;
        align-items: center;
        background-color: var(--bs-gray-dark);
        color: white;
        border-radius: 5px;
        margin-left: 10px;
    }

    .operation > div:hover {
        opacity: 0.8;
        cursor: pointer;
    }

    .operation > div:active {
        opacity: 1.0;
        cursor: pointer;
    }

    .table-overflow {
        max-height: 84vh;
        overflow-y: auto;
    }
</style>

<body class="wrapper">
    <div class="left-menu"> 
        <?php include('left_menu.php')?>
    </div>
    <div class="content"> 
    <!-- <script>
        $.ajax({
            url: "/admin/user/index.php", 
            method: "POST",
            data: {},
            success: function(response){
                $(".content").html(response);
            }
        });
    </script> -->
    </div>

    <div class="modal" tabindex="-1">
    </div>
</body>
</html>

<script>
    function getSelects() {
        let arr = [];

        $('.checkbox').each(function(index, value) {
            if (value.checked) {
                arr.push(value.dataset.id);
            }
        });

        return arr;
    }

    function isEmptySelect() {
        return getSelects().length == 0;
    }

    function uncheckAll() {
        $('.checkbox').prop('checked',false);
    }
</script>