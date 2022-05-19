<?php
include('../connection.php');
include('../api.php');
include('../object/cart.php');
include('../object/user.php');
include('../object/category.php');
include('../object/topping.php');
include('../object/pizza.php');
include('../object/pizza_detail.php');
include('../object/order.php');
include('../object/base.php');
include('../object/size.php');

if(session_status() == PHP_SESSION_NONE){
    session_start();
}

if (!isset($_GET['id']) || !isset($_SESSION['username'])) {
header("Location: /");
exit();
}

$id = $_GET['id'];
$user = User::getByUsername($_SESSION['username']);

$order = Order::getByUsernameAndId($_SESSION['username'], $id);
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
    <title> Chi tiết đơn hàng </title>
</head>

<style>
    body {
        margin: 0px;
    }

    .wrapper {
        width: 100%;
    }

    td {
        vertical-align: middle;
    }

    th:nth-child(1) {
        text-align: center;
    }

    th.status {
        text-align: center;
    }
</style>


<body class="wrapper">
    <?php $_GET['site'] = 'Chi tiết đơn hàng'?>
    <?php include('../header.php');?>

    <div class="container py-3" style="padding-bottom: 0px !important">
        <p class="h3"> 
            <a href="/history/" style="text-decoration: none !important; color: unset !important"> 
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-arrow-90deg-left" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M1.146 4.854a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 4H12.5A2.5 2.5 0 0 1 15 6.5v8a.5.5 0 0 1-1 0v-8A1.5 1.5 0 0 0 12.5 5H2.707l3.147 3.146a.5.5 0 1 1-.708.708l-4-4z"/>
            </svg>
            </a>
            Chi tiết đơn hàng #<?=$id?> 
        </p>
        <hr/>
    </div>

    <div class="history-wrapper container">
        <div class="fw-bold"> Trạng thái đơn hàng: </div>
        <table class="table"> 
            <tr>
                <th class="status"> Chờ xác nhận </th>
                <th class="status"> Đang chuẩn bị </th>
                <th class="status"> Đang nướng bánh </th>
                <th class="status"> Đang đóng hộp </th>
                <th class="status"> Đang vận chuyển </th>
                <th class="status"> Đã giao </th>
            </tr>

            <tr> 
                <?php
                    $statusDetailDeny = StatusDetail::getByStatusId($id, 7);

                    if ($statusDetailDeny != null) :
                ?>
                    <td colspan="6" style="text-align: center; background-color: #dc3545; color: white"> Đơn hàng đã bị hủy </td>
                <?php else: ?>
                <?php 
                    for ($i = 1; $i <= 6; $i++) :
                        $statusDetail = StatusDetail::getByStatusId($id, $i);
                        $statusDetail2 = StatusDetail::getByStatusId($id, $i + 1);

                        if (isset($statusDetail) && isset($statusDetail2)) :
                ?>
                    <th class="status" style="background-color: #198754; color: white"> <?=$statusDetail->getTimeCreated()?> </th>
                <?php endif; ?>

                <?php if (!isset($statusDetail2) && $i == 6) : ?>
                    <th class="status" style="background-color: #198754; color: white"> <?=$statusDetail->getTimeCreated()?> </th>
                <?php break; endif; ?>

                <?php if (!isset($statusDetail2) && $i != 6) : ?>
                    <th class="status" style="background-color: #fd7e14; color: white"> <?=$statusDetail->getTimeCreated()?> </th>
                <?php break; endif; ?>

                <?php endfor; ?>
                <?php endif; ?>
            </tr>
        </table>

        <div class="fw-bold"> Họ tên khách hàng: <span class="fw-lighter"> <?=$order->getFullname()?> </span> </div>
        <div class="fw-bold"> Địa chỉ giao hàng: <span class="fw-lighter"> <?=$order->getAddress()?> </span> </div>
        <div class="fw-bold"> Số điện thoại liên lạc: <span class="fw-lighter"> <?=$order->getPhone()?> </span> </div>
        <div class="fw-bold"> Phương thức thanh toán: 
            <span class="fw-lighter"> 
                <?php 
                    $type = $order->getPaymentType();

                    if ($type == 0) {
                        echo 'Tiền mặt';
                    }else if ($type == 1) {
                        echo 'ATM';
                    }else if ($type == 2) {
                        echo 'Momo';
                    }else if ($type == 3) {
                        echo 'ShopeePay';
                    }else if ($type == 4) {
                        echo 'ZaloPay';
                    }
                ?> 
            </span> 
        </div>
        <div class="fw-bold"> Thời gian giao hàng: 
            <span class="fw-lighter"> 
                <?php 
                    $type = $order->getOrderType();
                    $time = $order->getOrderTime();
                    
                    if ($type == 0) {
                        echo 'Giao hàng ngay';
                    }else if ($type == 1) {
                        echo 'Giao vào lúc '.$time;
                    }
                ?> 
            </span> 
        </div>
        <div class="fw-bold"> Chú thích: <div class="fw-lighter"> <?=$order->getNote()?> </div> </div>
        <div class="fw-bold"> Tổng tiền: <span class="fw-lighter"> <?=toMoney($order->getTotalPrice())?> </span> </div>

        <table class="table">
            <tr>
                <th> Ảnh </th>
                <th> Tên pizza </th>
                <th> Số lượng </th>
                <th> Tổng giá </th>
            </tr>
    
            <?php 
                $index = 0;
                $orderDetails = OrderDetail::getByOrderId($id);

                foreach ($orderDetails as $orderDetail) : 
                    $index++;

                    $pizzaDetail = PizzaDetail::getById($orderDetail->getId());
                    $pizza = Pizza::getById($pizzaDetail->getPizzaId());
                    $size = Size::getById($pizzaDetail->getSizeId());
                    $base = Base::getById($pizzaDetail->getBaseId());
            ?>

                <tr>
                    <td style="width: 100px">
                        <img src="/img/pizza/<?=$pizza->getImage()?>" width="120px" height="120px">                    
                    </td>

                    <td>
                        <h5> <?=$pizza->getDisplay()?> </h5>
                        <p> Kích thước - <?=$size->getDisplay()?> </p>
                        <p> Đế - <?=$base->getDisplay()?> </p>
                    </td>

                    <td>
                        <p> <?=$orderDetail->getQuantity()?> </p>
                    </td>

                    <td> 
                        <p> <?=toMoney($orderDetail->getPrice() * $orderDetail->getQuantity())?> </p>
                    </td>
                </tr>
            
            <?php endforeach; ?>
        </table>
    </div>

    <div class="modal" tabindex="-1">
    </div>
</body>
</html>