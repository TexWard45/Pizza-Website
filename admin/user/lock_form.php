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

$username = $_POST['id_array'][0];
$user = User::getByUsername($username);
?>

<div class="modal-dialog">
    <form class="lock-form" onsubmit="return false;">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"> Xác nhận khóa/mở khóa tài khoản? </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-footer">
            <button type="submit" class=" btn btn-danger"> Khóa/mở </button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> Đóng </button>
      </div>
    </form>
</div>

<script> 
    $(".lock-form").submit(function() {
        if (confirm("Bạn có chắc muốn khóa/mở khóa tài khoản?")) {
            $.ajax({
                url: "/admin/user/lock.php", 
                method: "POST",
                data: {username: "<?=$username?>"},
                success: function(response){
                    console.log(response);
                    if (response == "admin") {
                        alert("Không thể khóa tài khoản admin!");
                    }else if (response == "success") {
                        alert("Khóa/mở khóa tài khoản thành công!");
                        $(".modal").modal("hide");
                        reloadAdmin();
                    }
                }
            });
        }
    });
</script>