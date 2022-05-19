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
    <form class="add-form" onsubmit="return false;">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"> Thêm kích thước bánh pizza </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
                <div class="fw-bold"> Tên kích thước bánh: </div>
                <input class="form-control display" type="text" name="display" required>

                <div class="fw-bold"> Độ ưu tiên: </div>
                <input class="form-control priority" type="number" name="priority" required>
        </div>

        <div class="modal-footer">
            <button type="submit" class=" btn btn-primary"> Thêm </button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> Đóng </button>
      </div>
    </form>
</div>

<script> 
    $(".add-form").submit(function() {
        if (confirm("Xác nhận thêm kích thước bánh pizza?")) {
            $.ajax({
                url: "/admin/size/add.php", 
                method: "POST",
                data: {display: $(".display")[0].value, priority: $(".priority")[0].value},
                success: function(response){
                    if (response == "success") {
                        alert("Thêm kích thước bánh pizza thành công!");
                        $(".modal").modal("hide");
                        reloadAdmin();
                    }else if (response == "conflict") {
                        alert("Tên kích thước bánh pizza đã tồn tại!");
                    }
                }
            });
        }
    });
</script>