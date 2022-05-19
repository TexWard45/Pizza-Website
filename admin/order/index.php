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

if (isset($_POST['startdate']) || isset($_POST['enddate'])) {
    if (!empty($_POST['startdate']) && !empty($_POST['enddate'])) {
        $orders = Order::getBySearch($_POST['startdate'], $_POST['enddate']);
    }else if (!empty($_POST['startdate'])) {
        $orders = Order::getBySearch($_POST['startdate'], null);
    }else {
        $orders = Order::getBySearch(null, $_POST['enddate']);
    }
}else {
    $orders = Order::getAll();
}
?>

<div class="p-3">
    <div class="d-flex justify-content-between">
        <div class="title">
            <span class="h3"> Quản lý đơn hàng </span>
        </div>

        <div class="operation">
            <div class="item" data-operation="search"> 
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                </svg> 
            </div>

            <div class="item" data-operation="info"> 
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                    <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                </svg>
            </div>

            <div class="item" data-operation="check"> 
                <svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="28px" height="28px" viewBox="0 0 900.000000 900.000000" preserveAspectRatio="xMidYMid meet">
                    <g transform="translate(0.000000,900.000000) scale(0.100000,-0.100000)" fill="currentColor" stroke="none">
                        <path d="M841 8494 c-168 -45 -304 -190 -340 -362 -15 -72 -16 -5305 -1 -5383 36 -190 200 -349 390 -379 76 -12 2584 -14 2578 -2 -2 4 -18 35 -36 69 -55 107 -77 258 -53 380 l8 43 -1201 2 -1201 3 -2 2573 -3 2572 2580 0 2580 0 0 -1982 0 -1982 244 240 243 239 2 1797 c1 1737 0 1798 -18 1857 -48 154 -175 274 -336 317 -78 21 -5356 19 -5434 -2z"/>
                        <path d="M3294 7296 c-200 -38 -392 -116 -541 -218 -88 -61 -236 -214 -281 -290 -18 -31 -45 -89 -60 -130 -24 -65 -26 -88 -27 -208 0 -128 1 -138 28 -193 36 -72 107 -146 172 -177 65 -32 210 -40 281 -16 63 21 133 77 196 155 29 36 89 102 133 147 106 107 155 127 310 128 105 1 113 -1 177 -32 82 -40 149 -111 179 -190 17 -47 20 -71 16 -135 -6 -97 -39 -167 -103 -227 -66 -61 -149 -95 -327 -134 -101 -23 -176 -45 -209 -63 -56 -30 -101 -85 -119 -142 -15 -48 -21 -487 -9 -581 12 -93 45 -162 107 -223 70 -70 138 -99 249 -105 264 -14 423 151 424 440 0 47 0 47 43 58 383 95 638 299 746 596 40 110 61 225 68 374 27 581 -323 1020 -922 1155 -97 22 -435 29 -531 11z"/>
                        <path d="M8124 5146 c-275 -63 -663 -344 -1256 -909 -406 -388 -1014 -1036 -1448 -1545 -57 -67 -106 -121 -110 -119 -3 2 -106 53 -230 114 -492 243 -788 341 -1001 331 -113 -6 -184 -33 -243 -94 -93 -96 -119 -246 -59 -335 10 -14 79 -82 153 -151 427 -398 772 -858 1206 -1603 190 -326 186 -319 236 -343 54 -27 110 -28 164 -3 35 16 94 75 94 94 0 3 40 102 89 219 424 1016 933 1891 1536 2643 252 313 369 442 785 855 218 217 411 416 428 442 85 125 83 238 -7 328 -76 76 -207 105 -337 76z"/>
                        <path d="M3375 4423 c-118 -42 -225 -137 -273 -241 -114 -248 25 -537 292 -608 235 -63 485 105 528 354 32 189 -69 380 -249 469 -66 32 -85 37 -161 40 -65 3 -100 -1 -137 -14z"/>
                    </g>
                </svg>
            </div>

            <div class="item" data-operation="approve"> 
                <svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="33px" height="33px" viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet">
                    <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)" fill="currentColor" stroke="none">
                        <path d="M2760 4565 c-265 -45 -519 -166 -715 -341 l-60 -54 -627 0 -628 0 0 -1825 0 -1825 1405 0 1405 0 0 668 0 668 58 28 c413 202 707 589 788 1038 22 125 22 362 0 487 -107 597 -574 1058 -1172 1156 -108 18 -349 18 -454 0z m366 -280 c90 -8 235 -50 331 -95 331 -155 564 -450 639 -810 24 -116 25 -317 1 -430 -64 -301 -241 -563 -487 -722 -109 -71 -156 -94 -260 -130 -281 -95 -600 -74 -863 58 -137 69 -300 204 -391 324 -327 429 -310 1008 42 1423 166 195 423 339 672 376 129 19 165 20 316 6z m-1397 -467 c-149 -287 -196 -658 -120 -970 l18 -78 -98 0 -99 0 0 -145 0 -145 159 0 159 0 28 -47 c36 -63 99 -150 137 -190 l31 -33 -257 0 -257 0 0 -145 0 -145 440 0 441 0 60 -30 c117 -60 279 -108 437 -131 82 -11 339 -7 410 7 l32 6 0 -481 0 -481 -1115 0 -1115 0 0 1540 0 1540 374 0 373 0 -38 -72z"/>
                        <path d="M3193 3318 l-413 -413 -243 243 -242 242 -103 -103 -102 -102 345 -345 345 -345 517 517 518 518 -100 100 c-55 55 -102 100 -105 100 -3 0 -191 -186 -417 -412z"/>
                        <path d="M1430 1510 l0 -140 700 0 700 0 0 140 0 140 -700 0 -700 0 0 -140z"/>
                    </g>
                </svg>
            </div>

            <div class="item" data-operation="deny"> 
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-bag-x-fill" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M10.5 3.5a2.5 2.5 0 0 0-5 0V4h5v-.5zm1 0V4H15v10a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V4h3.5v-.5a3.5 3.5 0 1 1 7 0zM6.854 8.146a.5.5 0 1 0-.708.708L7.293 10l-1.147 1.146a.5.5 0 0 0 .708.708L8 10.707l1.146 1.147a.5.5 0 0 0 .708-.708L8.707 10l1.147-1.146a.5.5 0 0 0-.708-.708L8 9.293 6.854 8.146z"/>
                </svg>
            </div>
        </div>
    </div>
    <hr/>

    <?php
        if (count($orders) == 0) :
    ?>
        <div> Không tìm thấy đơn hàng nào! </div>
    <?php else: ?>

    <div class="table-overflow">
    <table class="table">
        <tr>
            <th> </th>
            <th> Mã đơn hàng </th>
            <th> Trạng thái </th>
            <th> Thời gian đặt </th>
            <th> Thời gian xử lý lần cuối </th>
            <th> Người mua </th>
            <th> Người xử lý </th>
            <th> Tổng giá </th>
            <th> Tổng số lượng </th>
        </tr>

        <?php
            foreach ($orders as $order) :
                $startStatusDetail = StatusDetail::getByStatusId($order->getId(), 1);
                $endStatusDetail = StatusDetail::getLastStatusDetail($order->getId());
                $endStatus = Status::getById($endStatusDetail->getStatusId());

                $lastTime = "Chưa xử lý";
                if ($endStatusDetail->getStatusId() != 1) {
                    $lastTime = $endStatusDetail->getTimeCreated();
                }
        ?>
            <tr>
                <td>
                    <input class="form-check-input checkbox" type="checkbox" data-id="<?=$order->getId()?>">
                </td>
                <td> <?=$order->getId()?> </td>
                <td> 
                    <?php
                        if ($endStatus->getId() < 6) :
                    ?>
                        <span class="btn btn-warning fw-bold"> <?=$endStatus->getDisplay()?> </span>
                    <?php
                        elseif ($endStatus->getId() > 6) :
                    ?>
                        <span class="btn btn-danger text-white fw-bold"> <?=$endStatus->getDisplay()?> </span>
                    <?php else : ?>
                        <span class="btn btn-success text-white fw-bold"> <?=$endStatus->getDisplay()?> </span>
                    <?php endif; ?> 
                </td>
                <td> <?=$startStatusDetail->getTimeCreated()?> </td>
                <td> <?=$lastTime?> </td>
                <td> <?=$order->getCustomer()?> </td>
                <td> <?=!is_null($order->getHandler()) ? $order->getHandler() : "Chưa xử lý"?> </td>
                <td> <?=toMoney($order->getTotalPrice())?> </td>
                <td> <?=$order->getQuantity()?> </td>
            </tr>
        <?php endforeach; ?>
    </table>
    </div>

    <?php endif; ?>
</div>

<script>
    $(".item").click(function() {
        let operation = $(this)[0].dataset.operation;
        let arr = getSelects();
        $.ajax({
            url: "/admin/order/" + operation + "_form.php", 
            method: "POST",
            data: {id_array: arr},
            success: function(response) {
                if ((operation == "check" || operation == "approve" || operation == "deny" || operation == "info") && arr.length == 0) {
                    alert("Chọn tối thiểu 1 dòng để thao tác!");
                    return;
                }

                if ((operation == "check" || operation == "approve" || operation == "deny" || operation == "info") && arr.length > 1) {
                    alert("Chỉ có thể thao tác trên 1 dòng cùng lúc!");
                    return;
                }

                $(".modal").html(response);
                $(".modal").modal("show");
                uncheckAll();
            }
        });
    });
</script>