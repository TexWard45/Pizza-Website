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

    .payment-info-wrapper {
        display: flex;
        flex-wrap: wrap;
    }

    .payment-info-user {
        padding-right: 1rem;
    }

    @media (max-width: 768px) {
        .payment-info-user {
            padding-right: 0rem;
        }
    }

    .payment > input {
        margin-top: 10px;
    }

    .payment > label > img {
        width: 40px;
        height: 40px;
    }

    .payment > label > span {
        font-weight: bold;
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

    if (count($_SESSION['cart']) == 0 || !isset($_SESSION['username'])) {
        header("Location: /cart");
    }

    $user = User::getByUsername($_SESSION['username']);
?>

<body class="wrapper">
    <?php $_GET['site'] = 'Giỏ hàng'?>
    <?php include('../header.php');?>

    <div class="payment-info-wrapper container py-3">
        <div class="payment-info-user col-lg-6 col-12">
            <div style="padding-bottom: 0px !important">
                <p class="h3"> Thông tin người dùng </p>
                <hr/>
            </div>

            <div class="cart-wrapper">
                <div class="fw-bold"> Họ tên khách hàng: </div>
                <input class="form-control fullname" type="text" name="fullname" value="<?=$user->getFullname()?>" required>
                <div class="fw-bold"> Địa chỉ giao hàng: </div>
                <input class="form-control address" type="text" name="address" value="<?=$user->getAddress()?>" required>
                <div class="fw-bold"> Số điện thoại liên lạc: </div>
                <input class="form-control phone" type="text" name="phone" value="<?=$user->getPhone()?>" required>    
            </div>
        </div>

        <div class="payment-info-order col-lg-6 col-12">
            <div style="padding-bottom: 0px !important">
                <p class="h3"> Thông tin đơn hàng </p>
                <hr/>
            </div>

            <div class="cart-wrapper">
                <div class="fw-bold"> Ghi chú: </div>
                <input class="form-control note" type="text" name="note" placeholder="Nhập ghi chú cho đơn hàng">

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="order-type" id="payment-info-order-now" value="0" checked>
                    <label class="form-check-label" for="payment-info-order-now">
                        Đặt hàng - Giao hàng ngay
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="order-type" id="payment-info-order-later" value="1">
                    <label class="form-check-label" for="payment-info-order-later">
                        Giao hàng - Nhận hàng hẹn giờ
                    </label>
                </div>

                <div class="form-group">
                    <select class="form-control" id="order-time">
                        <option value=" "> Chọn giờ nhận hàng </option><option value="10:30:08">10h 30p</option><option value="10:40:08">10h 40p</option><option value="10:50:08">10h 50p</option><option value="11:00:08">11h 0p</option><option value="11:10:08">11h 10p</option><option value="11:20:08">11h 20p</option><option value="11:30:08">11h 30p</option><option value="11:40:08">11h 40p</option><option value="11:50:08">11h 50p</option><option value="12:00:08">12h 0p</option><option value="12:10:08">12h 10p</option><option value="12:20:08">12h 20p</option><option value="12:30:08">12h 30p</option><option value="12:40:08">12h 40p</option><option value="12:50:08">12h 50p</option><option value="13:00:08">13h 0p</option><option value="13:10:08">13h 10p</option><option value="13:20:08">13h 20p</option><option value="13:30:08">13h 30p</option><option value="13:40:08">13h 40p</option><option value="13:50:08">13h 50p</option><option value="14:00:08">14h 0p</option><option value="14:10:08">14h 10p</option><option value="14:20:08">14h 20p</option><option value="14:30:08">14h 30p</option><option value="14:40:08">14h 40p</option><option value="14:50:08">14h 50p</option><option value="15:00:08">15h 0p</option><option value="15:10:08">15h 10p</option><option value="15:20:08">15h 20p</option><option value="15:30:08">15h 30p</option><option value="15:40:08">15h 40p</option><option value="15:50:08">15h 50p</option><option value="16:00:08">16h 0p</option><option value="16:10:08">16h 10p</option><option value="16:20:08">16h 20p</option><option value="16:30:08">16h 30p</option><option value="16:40:08">16h 40p</option><option value="16:50:08">16h 50p</option><option value="17:00:08">17h 0p</option><option value="17:10:08">17h 10p</option><option value="17:20:08">17h 20p</option><option value="17:30:08">17h 30p</option><option value="17:40:08">17h 40p</option><option value="17:50:08">17h 50p</option><option value="18:00:08">18h 0p</option><option value="18:10:08">18h 10p</option><option value="18:20:08">18h 20p</option><option value="18:30:08">18h 30p</option><option value="18:40:08">18h 40p</option><option value="18:50:08">18h 50p</option><option value="19:00:08">19h 0p</option><option value="19:10:08">19h 10p</option><option value="19:20:08">19h 20p</option><option value="19:30:08">19h 30p</option><option value="19:40:08">19h 40p</option><option value="19:50:08">19h 50p</option><option value="20:00:08">20h 0p</option><option value="20:10:08">20h 10p</option><option value="20:20:08">20h 20p</option><option value="20:30:08">20h 30p</option><option value="20:40:08">20h 40p</option><option value="20:50:08">20h 50p</option><option value="21:00:08">21h 0p</option><option value="21:10:08">21h 10p</option><option value="21:20:08">21h 20p</option><option value="21:30:08">21h 30p</option><option value="21:40:08">21h 40p</option><option value="21:50:08">21h 50p</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="payment-info-order col-12">
            <div style="padding-bottom: 0px !important">
                <p class="h3"> Phương thức thanh toán </p>
                <hr/>
            </div>

            <div class="cart-wrapper">
                <div class="form-check payment">
                    <input class="form-check-input" type="radio" id="payment0" value="0" name="payment" checked>
                    <label class="form-check-label" for="payment0">
                        <img src="/img/payment/cash.png">
                        <span> Tiền mặt </span>
                    </label>
                </div>

                <div class="form-check payment">
                    <input class="form-check-input" type="radio" id="payment1" value="1" name="payment">
                    <label class="form-check-label" for="payment1">
                        <img src="/img/payment/credit.png">
                        <span> ATM </span>
                    </label>
                </div>

                <div class="form-check payment">
                    <input class="form-check-input" type="radio" id="payment2" value="2" name="payment">
                    <label class="form-check-label" for="payment2">
                        <img src="/img/payment/momo.png">
                        <span> Momo </span>
                    </label>
                </div>

                <div class="form-check payment">
                    <input class="form-check-input" type="radio" id="payment3" value="3" name="payment">
                    <label class="form-check-label" for="payment3">
                        <img src="/img/payment/shopeepay.png">
                        <span> ShopeePay </span>
                    </label>
                </div>

                <div class="form-check payment">
                    <input class="form-check-input" type="radio" id="payment4" value="4" name="payment">
                    <label class="form-check-label" for="payment4">
                        <img src="/img/payment/zalo-pay.png">
                        <span> ZaloPay </span>
                    </label>
                </div>
            </div>
        </div>
    </div>


    <div class="container py-3" style="padding-bottom: 0px !important">
        <p class="h3"> Đơn hàng </p>
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

                    <td style="vertical-align: middle">
                        <p> <?=$item->getQuantity()?> </p>
                    </td>

                    <td style="vertical-align: middle"> 
                        <h5 class="pizzaprice-<?=$item->getPizzaId()?>-<?=$item->getSizeId()?>-<?=$item->getBaseId()?>"> <?=toMoney($pizza_detail->getPrice() * $item->getQuantity())?> </h5>
                    </td>

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
                    <button class="payment-button btn btn-success w-100"> Hoàn tất thanh toán </button>
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
    $(".payment-button").click(function() {
        if (confirm("Xác nhận thanh toán?")) {
            $.ajax({
                url: "checkout.php", 
                method: "POST",
                data: {fullname: $(".fullname")[0].value, note: $(".note")[0].value, address: $(".address")[0].value, phone: $(".phone")[0].value, payment_type: $('input[name="payment"]:checked').val(), order_type: $('input[name="order-type"]:checked').val(), order_time: $('#order-time').val()},
                success: function(response){
                    alert("Thanh toán đơn hàng thành công!");
                    window.location.href = '/cart';
                }
            });
        }
    });

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