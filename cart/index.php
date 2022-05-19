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
    <title> Thanh toán </title>
</head>

<style>
    body {
        margin: 0px;
    }

    .wrapper {
        width: 100%;
    }

    .table > tbody > tr > td:nth-child(1) {
        width: 100px;
    }

    .payment-box {
        float: right;
        width: 300px;
        border-radius: 5px;
        border: 1px solid lightgray;
        padding: 10px;
    }

    th:nth-child(1) {
        text-align: center;
    }

    .payment-button > a {
        text-decoration: none;
        color: white;
    }
</style>

<?php
    include('../connection.php');
    include('../api.php');
    include('../object/cart.php');
    include('../object/category.php');
    include('../object/topping.php');
    include('../object/pizza.php');
    include('../object/size.php');
    include('../object/base.php');
    include('../object/user.php');
    include('../object/pizza_detail.php');

    if(session_status() == PHP_SESSION_NONE){
        session_start();
    }
?>

<body class="wrapper">
    <?php $_GET['site'] = 'Giỏ hàng'?>
    <?php include('../header.php');?>

    <div class="container py-3" style="padding-bottom: 0px !important">
        <p class="h3"> Giỏ hàng </p>
        <hr/>
    </div>

    <div class="cart-wrapper container">
        <?php 
            if (count($_SESSION['cart']) == 0) :
        ?>
            Giỏ hàng hiện đang rỗng. <a href="/browser"> Tìm kiếm bánh pizza ? </a>
        <?php else : ?>

        <table class="table">
            <tbody>
                <tr>
                    <th> Ảnh </th>
                    <th> Tên pizza </th>
                    <th> Số lượng </th>
                    <th> Tổng giá </th>
                    <th> </th>
                </tr>

                <?php
                    $totalPrice = 0;
                
                    foreach ($_SESSION['cart'] as $item) :
                        $pizza_detail = PizzaDetail::getBySizeBasePizzaId($item->getSizeId(), $item->getBaseId(), $item->getPizzaId());
                        $pizza = Pizza::getById($item->getPizzaId());
                        $size = Size::getById($item->getSizeId());
                        $base = Base::getById($item->getBaseId());
                        $totalPrice += $pizza_detail->getPrice() * $item->getQuantity();
                ?>
                <tr class="pizza-<?=$item->getPizzaId()?>-<?=$item->getSizeId()?>-<?=$item->getBaseId()?>">
                    <td>
                        <img src="/img/pizza/<?=$pizza->getImage()?>" width="120px" height="120px">                    
                    </td>
                    <td>
                        <h5> <?=$pizza->getDisplay()?> </h5>
                        <p> Kích thước - <?=$size->getDisplay()?> </p>
                        <p> Đế - <?=$base->getDisplay()?> </p>
                    </td>

                    <td style="vertical-align: middle; text-align: center">
                        <input class="form-control quantity-number" style="width: 80px" type="number" value="<?=$item->getQuantity()?>" data-pizzaid="<?=$item->getPizzaId()?>" data-sizeid="<?=$item->getSizeId()?>" data-baseid="<?=$item->getBaseId()?>" min="1" max="9">
                    </td>

                    <td style="vertical-align: middle"> 
                        <h5 class="pizzaprice-<?=$item->getPizzaId()?>-<?=$item->getSizeId()?>-<?=$item->getBaseId()?>"> <?=toMoney($pizza_detail->getPrice() * $item->getQuantity())?> </h5>
                    </td>

                    <td style="vertical-align: middle; text-align: center">
                        <div class="pizza-trash" data-pizzaid="<?=$item->getPizzaId()?>" data-sizeid="<?=$item->getSizeId()?>" data-baseid="<?=$item->getBaseId()?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                            <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                            </svg>
                        </div>
                    </td>
                </tr>

                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="payment-box"> 
            <div class="payment-price-wrapper">
                <div class="float-start h5"> Tổng tiền </div>
                <div class="float-end h5 payment-total-price"> <?=toMoney($totalPrice)?> </div>
                <div class="clearfix"> </div>
            </div>

            <div class="payment-button-wrapper">
                <?php
                    if (!isset($_SESSION['username'])) :
                ?>
                    <button class="btn btn-secondary w-100"> Yêu cầu đăng nhập để tiến hành thanh toán </button>
                <?php elseif (!User::isFullInformation($_SESSION['username'])) : ?>
                    <button class="btn btn-secondary w-100"> Điền đầy đủ thông tin để tiến hành thanh toán </button>
                <?php else : ?>
                    <button class="payment-button btn btn-success w-100"> <a href="/payment"> Tiến hành thanh toán <a> </button>
                <?php endif; ?>        
            </div>
        </div>

        <?php endif; ?>
    </div>

    <div class="modal" tabindex="-1">
    </div>
</body>
</html>

<script>
    $(".pizza-trash").click(function() {
        let element = $(this)[0];

        $.ajax({
            url: "../remove_cart.php", 
            method: "POST",
            data: {pizza_id: element.dataset.pizzaid, size_id: element.dataset.sizeid, base_id: element.dataset.baseid},
            success: function(response){
                updateTotalPrice();
                $(".pizza-" + element.dataset.pizzaid + "-" + element.dataset.sizeid + "-" + element.dataset.baseid).remove();
            }
        });
    });

    function updateTotalPrice() {
        $.ajax({
            url: "../total_cart_price.php", 
            method: "POST",
            data: {},
            success: function(response){
                $(".payment-total-price").html(response);
            }
        });
    }

    function updateCart(quantityInput) {
        $.ajax({
            url: "../update_cart.php", 
            method: "POST",
            data: {pizza_id: quantityInput.dataset.pizzaid, size_id: quantityInput.dataset.sizeid, base_id: quantityInput.dataset.baseid, new_quantity: quantityInput.value},
            success: function(response){
                updateTotalPrice();
                updatePizzaPrice(quantityInput);
            }
        });
    }

    function updatePizzaPrice(quantityInput) {
        $.ajax({
            url: "../get_cart_price.php", 
            method: "POST",
            data: {pizza_id: quantityInput.dataset.pizzaid, size_id: quantityInput.dataset.sizeid, base_id: quantityInput.dataset.baseid},
            success: function(response){
                $(".pizzaprice-" + quantityInput.dataset.pizzaid + "-" + quantityInput.dataset.sizeid + "-" + quantityInput.dataset.baseid).html(response);
            }
        });
    }

    $(".quantity-number").change(function() {
        var max = parseInt($(this).attr('max'));
        var min = parseInt($(this).attr('min'));
        if ($(this).val() > max) {
            $(this).val(max);
        }
        else if ($(this).val() < min) {
            $(this).val(min);
        }       
        updateCart($(this)[0]);
    }); 

    $(".quantity-number").keyup(function() {
        var max = parseInt($(this).attr('max'));
        var min = parseInt($(this).attr('min'));
        if ($(this).val() > max) {
            $(this).val(max);
        }
        else if ($(this).val() < min) {
            $(this).val(min);
        }       
        updateCart($(this)[0]);
    }); 
</script>