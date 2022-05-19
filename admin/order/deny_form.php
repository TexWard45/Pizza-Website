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

$id = $_POST['id_array'][0];
?>

<div class="modal-dialog">
    <form class="deny-form" onsubmit="return false;">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"> Xác nhận hủy đơn hàng? </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-footer">
            <button type="submit" class=" btn btn-danger"> Hủy </button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> Đóng </button>
      </div>
    </form>
</div>

<script> 
    $(".deny-form").submit(function() {
        if (confirm("Bạn có chắc muốn hủy đơn hàng?")) {
            $.ajax({
                url: "/admin/order/deny.php", 
                method: "POST",
                data: {id: <?=$id?>},
                success: function(response){
                    if (response == "success") {
                        alert("Hủy đơn hàng thành công!");
                        $(".modal").modal("hide");
                        reloadAdmin();
                    }else if (response == 'already_approve') {
                        alert("Không thể hủy đơn hàng đã xử lý!");
                        $(".modal").modal("hide");
                    }else if (response == 'already_deny') {
                        alert("Đơn hàng này đã bị hủy trước đó!");
                        $(".modal").modal("hide");
                    }
                }
            });
        }
    });
</script>