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

global $connection;

$searchdate = "";

if (isset($_POST['startdate']) || isset($_POST['enddate'])) {
    if (!empty($_POST['startdate']) && !empty($_POST['enddate'])) {
        $startdate = $_POST['startdate'];
        $enddate = $_POST['enddate'];
        $searchdate = 'Từ '.$startdate.' đến '.$enddate;
        $sql = "SELECT `order_detail`.order_id, pizza.id as pizza_id, SUM(order_detail.price * order_detail.quantity) as total_price, SUM(order_detail.quantity) as total_quantity
        FROM `order_detail` 
        INNER JOIN pizza_detail ON order_detail.pizza_detail_id = pizza_detail.id
        INNER JOIN pizza ON pizza_detail.pizza_id = pizza.id
        INNER JOIN status_detail ON order_detail.order_id = status_detail.order_id
        WHERE status_detail.status_id = 1 AND time_created >= '$startdate' AND time_created <= '$enddate'
        GROUP BY order_id, pizza_id
        ";
    }else if (!empty($_POST['startdate'])) {
        $startdate = $_POST['startdate'];
        $searchdate = 'Từ '.$startdate;
        $sql = "SELECT `order_detail`.order_id, pizza.id as pizza_id, SUM(order_detail.price * order_detail.quantity) as total_price, SUM(order_detail.quantity) as total_quantity
        FROM `order_detail` 
        INNER JOIN pizza_detail ON order_detail.pizza_detail_id = pizza_detail.id
        INNER JOIN pizza ON pizza_detail.pizza_id = pizza.id
        INNER JOIN status_detail ON order_detail.order_id = status_detail.order_id
        WHERE status_detail.status_id = 1 AND time_created >= '$startdate'
        GROUP BY order_id, pizza_id
        ";
    }else {
        $enddate = $_POST['enddate'];
        $searchdate = 'Đến '.$enddate;
        $sql = "SELECT `order_detail`.order_id, pizza.id as pizza_id, SUM(order_detail.price * order_detail.quantity) as total_price, SUM(order_detail.quantity) as total_quantity
        FROM `order_detail` 
        INNER JOIN pizza_detail ON order_detail.pizza_detail_id = pizza_detail.id
        INNER JOIN pizza ON pizza_detail.pizza_id = pizza.id
        INNER JOIN status_detail ON order_detail.order_id = status_detail.order_id
        WHERE status_detail.status_id = 1 AND time_created <= '$enddate'
        GROUP BY order_id, pizza_id
        ";
    }
}else {
    $sql = "SELECT `order_detail`.order_id, pizza.id as pizza_id, SUM(order_detail.price * order_detail.quantity) as total_price, SUM(order_detail.quantity) as total_quantity
            FROM `order_detail` 
            INNER JOIN pizza_detail ON order_detail.pizza_detail_id = pizza_detail.id
            INNER JOIN pizza ON pizza_detail.pizza_id = pizza.id
            INNER JOIN status_detail ON order_detail.order_id = status_detail.order_id
            WHERE status_detail.status_id = 1
            GROUP BY order_id, pizza_id
        ";
}

$result = $connection->query($sql);

$orderDetails = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $obj = array($row['order_id'], $row['pizza_id'], $row['total_price'], $row['total_quantity']);
        array_push($orderDetails, $obj);
    }
}
?>

<div class="p-3">
    <div class="d-flex justify-content-between">
        <div class="title">
            <span class="h3"> Thống kê doanh thu theo bánh pizza <?=$searchdate?> </span>
        </div>

        <div class="operation">
            <div class="item" data-operation="search"> 
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                </svg> 
            </div>
        </div>
    </div>
    <hr/>

    <div class="table-overflow">
    <table class="table">
        <tr>
            <th> Tổng doanh thu thực tế </th>
            <th> Tổng doanh thu dự kiến </th>
            <th> Tổng số lượng bán được thực tế </th>
            <th> Tổng số lượng bán được dự kiến </th>
        </tr>

        <?php
            $pizzaArr = Pizza::getAll();

            $i = 0;

            $totalOfRevenue1 = 0;
            $totalOfQuantity1 = 0;
            $totalOfRevenue2 = 0;
            $totalOfQuantity2 = 0;

            foreach ($pizzaArr as $pizza) {
                $i++;
                
                $totalRevenue1 = 0;
                $totalQuantity1 = 0;
                $totalRevenue2 = 0;
                $totalQuantity2 = 0;

                foreach ($orderDetails as $orderDetail) {
                    $order_id = $orderDetail[0];
                    $pizzaId = $orderDetail[1];
                    if ($pizzaId != $pizza->getId()) {
                        continue;
                    }
                    $price = $orderDetail[2];
                    $quantity = $orderDetail[3];
                    $statusDetail = StatusDetail::getLastStatusDetail($order_id);

                    if ($statusDetail->getStatusId() == 6) {
                        $totalRevenue1 += $price;
                        $totalQuantity1 += $quantity;
                    }

                    if ($statusDetail->getStatusId() < 6) {
                        $totalRevenue2 += $price;
                        $totalQuantity2 += $quantity;
                    }
                }

                $totalOfRevenue1 += $totalRevenue1;
                $totalOfQuantity1 += $totalQuantity1;
                $totalOfRevenue2 += $totalRevenue2;
                $totalOfQuantity2 += $totalQuantity2;
            }
        ?>
        <tr>
            <td> <?=$totalOfRevenue1?> </td>
            <td> <?=$totalOfRevenue2?> </td>
            <td> <?=$totalOfQuantity1?> </td>
            <td> <?=$totalOfQuantity2?> </td>
        </tr>
    </table>

    <div class="table-overflow">
    <table class="table">
        <tr>
            <th> STT </th>
            <th> Mã danh mục </th>
            <th> Tên danh mục </th>
            <th> Doanh thu thực tế </th>
            <th> Doanh thu dự kiến </th>
            <th> Số lượng bán được thực tế </th>
            <th> Số lượng bán được dự kiến </th>
        </tr>

        <?php
            $pizzaArr = Pizza::getAll();

            $i = 0;

            foreach ($pizzaArr as $pizza) :
                $i++;
                
                $totalRevenue1 = 0;
                $totalQuantity1 = 0;
                $totalRevenue2 = 0;
                $totalQuantity2 = 0;

                foreach ($orderDetails as $orderDetail) {
                    $order_id = $orderDetail[0];
                    $pizzaId = $orderDetail[1];
                    if ($pizzaId != $pizza->getId()) {
                        continue;
                    }
                    $price = $orderDetail[2];
                    $quantity = $orderDetail[3];
                    $statusDetail = StatusDetail::getLastStatusDetail($order_id);

                    if ($statusDetail->getStatusId() == 6) {
                        $totalRevenue1 += $price;
                        $totalQuantity1 += $quantity;
                    }

                    if ($statusDetail->getStatusId() < 6) {
                        $totalRevenue2 += $price;
                        $totalQuantity2 += $quantity;
                    }
                }
        ?>
            <tr>
                <td> <?=$i?> </td>
                <td> <?=$pizza->getId()?> </td>
                <td> <?=$pizza->getDisplay()?> </td>
                <td> <?=$totalRevenue1?> </td>
                <td> <?=$totalRevenue2?> </td>
                <td> <?=$totalQuantity1?> </td>
                <td> <?=$totalQuantity2?> </td>
            </tr>
        <?php endforeach; ?>
    </table>
    </div>
</div>

<script>
    $(".item").click(function() {
        let operation = $(this)[0].dataset.operation;
        let arr = getSelects();
        $.ajax({
            url: "/admin/statistic/category/" + operation + "_form.php", 
            method: "POST",
            data: {id_array: arr},
            success: function(response) {
                $(".modal").html(response);
                $(".modal").modal("show");
                uncheckAll();
            }
        });
    });
</script>