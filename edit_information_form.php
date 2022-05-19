<?php
include($_SERVER['DOCUMENT_ROOT'].'/connection.php');
include($_SERVER['DOCUMENT_ROOT'].'/api.php');
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

$user = User::getByUsername($_SESSION['username']);
?>

<div class="modal-dialog">
    <form class="edit-information-form" onsubmit="return false;">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"> Chỉnh sửa thông tin cá nhân </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
                <div class="fw-bold"> Họ tên: </div>
                <input class="form-control fullname" type="text" name="fullname" value="<?=$user->getFullname()?>" required>
                <div class="fw-bold"> Ngày sinh: </div>
                <input class="form-control birth" type="date" name="birth" value="<?=$user->getBirth()?>" required>
                <div class="fw-bold"> Địa chỉ: </div>
                <input class="form-control address" type="text" name="address" value="<?=$user->getAddress()?>" required>
                <div class="fw-bold"> Số điện thoại: </div>
                <input class="form-control phone" type="text" name="phone" value="<?=$user->getPhone()?>" required>
                <div class="fw-bold"> Email: </div>
                <input class="form-control email" type="text" name="email" value="<?=$user->getEmail()?>" required>
        </div>

        <div class="modal-footer">
            <button type="submit" class=" btn btn-primary"> Lưu thay đổi </button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> Đóng </button>
      </div>
    </form>
</div>

<script> 
    $(".edit-information-form").submit(function() {
        if (confirm("Xác nhận lưu thay đổi?")) {
            $.ajax({
                url: "/change_information.php", 
                method: "POST",
                data: {fullname: $(".fullname")[0].value, birth: $(".birth")[0].value, address: $(".address")[0].value, phone: $(".phone")[0].value, email: $(".email")[0].value},
                success: function(response){
                    alert("Lưu thay đổi thành công!");
                    $(".modal").modal("hide");
                }
            });
        }
    });
</script>