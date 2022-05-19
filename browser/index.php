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
    <title> Tìm kiếm </title>
</head>

<style>
    body {
        margin: 0px;
    }

    .wrapper {
        width: 100%;
    }

    .browser-wrapper {
        display: flex;
    }

    .browser-filter {
        flex: 0 0 200px;
        height: 100vh;
        border-right: 1px solid lightgray;
    }

    .browser-product {
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        flex-grow: 1;
        width: 100%;
        padding: 0rem 1rem;
    }
</style>

<?php
    include('../connection.php');
    include('../api.php');
    include('../object/cart.php');
    include('../object/category.php');
    include('../object/topping.php');
    include('../object/pizza.php');
    include('../object/pizza_detail.php');
?>

<body class="wrapper">
    <?php $_GET['site'] = 'Tìm kiếm'?>
    <?php include('../header.php');?>

    <div class="container py-3" style="padding-bottom: 0px !important">
        <p class="h3"> Tìm kiếm bánh pizza </p>
        <hr/>
    </div>

    <div class="browser-wrapper container py-2">

        <div class="browser-filter"> 
            <?php include('filter.php')?>
        </div>

        <div class="browser-product"> 
            <?php include('product.php')?>
        </div>
    </div>

    <div class="modal" tabindex="-1">
    </div>
</body>
</html>