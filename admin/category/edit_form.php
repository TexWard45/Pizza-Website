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
$category = Category::getById($id);
?>

<div class="modal-dialog">
    <form class="edit-form" onsubmit="return false;">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"> Sửa danh mục bánh pizza </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
                <div class="fw-bold"> Tên danh mục: </div>
                <input class="form-control display" type="text" name="display">
        </div>

        <div class="modal-footer">
            <button type="submit" class=" btn btn-primary"> Sửa </button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> Đóng </button>
      </div>
    </form>
</div>

<script> 
    $(".edit-form").submit(function() {
        if (confirm("Xác nhận sửa danh mục bánh pizza?")) {
            $.ajax({
                url: "/admin/category/edit.php", 
                method: "POST",
                data: {id: "<?=$id?>", display: $(".display")[0].value},
                success: function(response){
                    if (response == "success") {
                        alert("Sửa danh mục bánh pizza thành công!");
                        $(".modal").modal("hide");
                        reloadAdmin();
                    }
                }
            });
        }
    });
</script>