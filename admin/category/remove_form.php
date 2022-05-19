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

$idArray = $_POST['id_array'];
?>

<div class="modal-dialog">
    <form class="remove-form" onsubmit="return false;">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"> Xác nhận xóa danh mục bánh pizza? </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-footer">
            <button type="submit" class=" btn btn-danger"> Xóa </button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> Đóng </button>
      </div>
    </form>
</div>

<script> 
    $(".remove-form").submit(function() {
        if (confirm("Bạn có chắc muốn xóa?")) {
            $.ajax({
                url: "/admin/category/remove.php", 
                method: "POST",
                data: {id_array: <?=json_encode($idArray)?>},
                success: function(response){
                    if (response == "success") {
                        alert("Xóa danh mục bánh pizza thành công!");
                        $(".modal").modal("hide");
                        reloadAdmin();
                    }else if (response == 'exists') {
                        alert("Không thể xóa danh mục bánh pizza đang được sử dụng bởi bánh pizza khác!");
                        $(".modal").modal("hide");
                    }
                }
            });
        }
    });
</script>