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

$id = $_POST['id_array'][0];
$order = Order::getById($id);
$customer = User::getByUsername($order->getCustomer());
?>

<style>
     .modal-body {
        max-height: 70vh;
        overflow-y: auto;
    }

    .info-order > tbody > tr > th:nth-child(3) {
        text-align: right;
    }

    .info-order > tbody > tr > td:nth-child(3) {
        text-align: right;
    }
</style>

<div class="modal-dialog">
    <form class="payment-form" onsubmit="return false;">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"> Thông tin đơn đặt hàng </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
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

                <div class="fw-bold"> Trạng thái đơn hàng </div>

                <table class="info-order" style="width: 100%">
                    <tr>
                        <th> Trạng thái </th>
                        <th> Người xử lý </th>
                        <th> Thời gian xử lý </th>
                    </tr>
                </table>

                <div>   
                    <div class="float-start fw-bold"> Trạng thái </div>
                    <div class="float-end fw-bold"> Thời gian xử lý </div>
                    <div class="clearfix"> </div>
                </div>
                <?php
                    $currentStatusDetail = StatusDetail::getLastStatusDetail($id);

                    for ($i = 1; $i <= 7; $i++) :
                        $statusDetail = StatusDetail::getByStatusId($id, $i);

                        if (isset($statusDetail)) :
                ?>
                    <div>   
                        <div class="float-start"> <?=Status::getById($i)->getDisplay()?> </div>
                        <div class="float-end"> <?=$statusDetail->getTimeCreated()?> </div>
                        <div class="clearfix"> </div>
                    </div>
                <?php else : ?>
                    <div>   
                        <div class="float-start"> <?=Status::getById($i)->getDisplay()?> </div>
                        <div class="float-end"> Trống </div>
                        <div class="clearfix"> </div>
                    </div>
                <?php endif; ?>
                <?php endfor; ?>

                <div class="fw-bold"> Chi tiết đơn hàng </div>
                <div>
                    <div class="float-start fw-bold"> Pizza </div>
                    <div class="float-end fw-bold"> Giá </div>
                    <div class="clearfix"> </div>
                </div>

                <hr/>

                <?php
                    $totalPrice = 0;
                    $orderDetails = OrderDetail::getByOrderId($id);

                    foreach ($orderDetails as $orderDetail) :
                        $pizza_detail = PizzaDetail::getById($orderDetail->getPizzaDetailId());
                        $pizza = Pizza::getById($pizza_detail->getPizzaId());
                        $size = Size::getById($pizza_detail->getSizeId());
                        $base = Base::getById($pizza_detail->getBaseId());
                        $totalPrice += $pizza_detail->getPrice() * $orderDetail->getQuantity();
                ?>
                    <div>
                        <div class="float-start"> <?=$pizza->getDisplay()?> x <?=$orderDetail->getQuantity()?> </div>
                        <div class="float-end"> <?=toMoney($orderDetail->getPrice() * $orderDetail->getQuantity())?> </div>
                        <div class="clearfix"> </div>
                    </div>

                    <div>
                        <div class="float-start"> Kích thước <?=$size->getDisplay()?>, Đế <?=$base->getDisplay()?> </div>
                        <div class="float-end"> </div>
                        <div class="clearfix"> </div>
                    </div>
                <?php endforeach; ?>

                <hr/>

                <div>
                    <div class="float-start fw-bold"> Tổng tiền </div>
                    <div class="float-end"> <?=toMoney($totalPrice)?> </div>
                    <div class="clearfix"> </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </form>
</div>