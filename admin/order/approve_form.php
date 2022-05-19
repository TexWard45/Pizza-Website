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
?>

<div class="modal-dialog">
    <form class="check-form" onsubmit="return false;">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"> Xử lý đơn hàng? </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-footer">
            <button type="submit" class=" btn btn-success"> Xử lý </button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> Đóng </button>
      </div>
    </form>
</div>

<script> 
    $(".check-form").submit(function() {
        if (confirm("Bạn có chắc muốn xử lý đơn hàng này?")) {
            $.ajax({
                url: "/admin/order/approve.php", 
                method: "POST",
                data: {id: <?=$id?>},
                success: function(response){
                    if (response == "success") {
                        alert("Đã xử lý thành công!");
                        $(".modal").modal("hide");
                        reloadAdmin();
                    }else if (response == 'not_enough') {
                        alert("Đơn hàng không đủ nguyên liệu làm bánh!");
                        $(".modal").modal("hide");
                    }else if (response == 'already_done') {
                        alert("Không thể xử lý đơn hàng đã hoàn tất!");
                        $(".modal").modal("hide");
                    }else if (response == 'deny') {
                        alert("Không thể xử lý đơn hàng đã bị hủy!");
                        $(".modal").modal("hide");
                    }else if (response == 'not_same_handler') {
                        alert("Không thể xử lý đơn hàng đã được người khác xử lý!");
                        $(".modal").modal("hide");
                    }
                }
            });
        }
    });
</script>