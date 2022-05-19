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

if(session_status() == PHP_SESSION_NONE){
    session_start();
}
?>

<div class="modal-dialog">
    <form class="search-form" onsubmit="return false;">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"> Tìm kiếm đơn hàng </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="fw-bold"> Từ thời gian: </div>
            <input class="form-control startdate" type="text" name="startdate" placeholder="yyyy-mm-dd HH:mm:ss">
            <div class="fw-bold"> Đến thời gian: </div>
            <input class="form-control enddate" type="text" name="enddate" placeholder="yyyy-mm-dd HH:mm:ss">
        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-primary"> Tìm kiếm </button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> Đóng </button>
      </div>
    </form>
</div>

<script> 
    $(".search-form").submit(function() {
        $.ajax({
            url: "/admin/order/index.php", 
            method: "POST",
            data: {startdate: $(".startdate")[0].value, enddate: $(".enddate")[0].value},
            success: function(response){
                $(".content").html(response);
                $(".modal").modal("hide");
            }
        });
    });
</script>