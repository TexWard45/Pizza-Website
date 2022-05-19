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
    <title> Theo dõi đơn hàng </title>
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
</style>

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
?>

<body class="wrapper">
    <?php $_GET['site'] = 'Theo dõi đơn hàng'?>
    <?php include('../header.php');?>

    <div class="container py-3" style="padding-bottom: 0px !important">
        <p class="h3"> Theo dõi đơn hàng </p>
        <hr/>
    </div>

    <div class="history-wrapper container">
        <?php
            $orders = Order::getByUsername($_SESSION['username']);
        
            if (count($orders) > 0) :
        ?>

        <table class="table">
            <tr>
                <th> Mã đơn </th>
                <th> Trạng thái </th>
                <th> Thời gian đặt hàng </th>
                <th> Cập nhật lần cuối </th>
                <th> Số lượng </th>
                <th> Tổng tiền </th>
                <th> Xem chi tiết </th>
            </tr>
            <?php 
                $index = 0;
                foreach ($orders as $order) : 
                    $index++;

                    $firstStatusDetail = StatusDetail::getFirstStatusDetail($order->getId());
                    $lastStatusDetail = StatusDetail::getLastStatusDetail($order->getId());
                    $firstStatus = Status::getById($firstStatusDetail->getStatusId());
                    $lastStatus = Status::getById($lastStatusDetail->getStatusId());
                    $totalPrice = $order->getTotalPrice();
                    $quantity = $order->getQuantity();
                    $statusDetailDeny = StatusDetail::getByStatusId($order->getId(), 7);

                    if (isset($statusDetailDeny)) {
                        $denyStatus = Status::getById($statusDetailDeny->getStatusId());
                    }
            ?>

            <tr>
                <td> <?=$order->getId()?> </td>
                <td> 
                    <?php
                        if ($statusDetailDeny != null) {
                            echo $denyStatus->getDisplay();
                        } else {
                            echo $lastStatus->getDisplay();
                        }
                    ?> 
                </td>
                <td> <?=$firstStatusDetail->getTimeCreated()?> </td>
                <td> <?=$lastStatusDetail->getTimeCreated()?> </td>
                <td> <?=$quantity?> </td>
                <td> <?=toMoney($totalPrice)?> </td>
                <td> 
                    <a class="btn btn-success" data-id="<?=$order->getId()?>" href="/history_detail/?id=<?=$order->getId()?>"> Chi tiết </a>
                </td>
            </tr>
            
            <?php endforeach; ?>
        </table>

        <?php else: ?>
            Chưa đặt đơn hàng nào để hiển thị. <a href="/browser/"> Tìm kiếm pizza để đặt hàng? </a>
        <?php endif; ?>
    </div>

    <div class="modal" tabindex="-1">
    </div>
</body>
</html>