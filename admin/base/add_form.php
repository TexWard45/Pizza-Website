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
            <h5 class="modal-title"> Thêm đế bánh pizza </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
                <div class="fw-bold"> Tên đế bánh: </div>
                <input class="form-control display" type="text" name="display" required>
        </div>

        <div class="modal-footer">
            <button type="submit" class=" btn btn-primary"> Thêm </button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> Đóng </button>
      </div>
    </form>
</div>

<script> 
    $(".add-form").submit(function() {
        if (confirm("Xác nhận thêm đế bánh pizza?")) {
            $.ajax({
                url: "/admin/base/add.php", 
                method: "POST",
                data: {display: $(".display")[0].value},
                success: function(response){
                    if (response == "success") {
                        alert("Thêm đế bánh pizza thành công!");
                        $(".modal").modal("hide");
                        reloadAdmin();
                    }else if (response == "conflict") {
                        alert("Tên đế bánh pizza đã tồn tại!");
                    }
                }
            });
        }
    });
</script>