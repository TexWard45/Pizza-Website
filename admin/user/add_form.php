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
            <h5 class="modal-title"> Thêm tài khoản </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
                <div class="fw-bold"> Tên tài khoản: </div>
                <input class="form-control username" type="text" name="username" required>
                <div class="fw-bold"> Nhóm tài khoản: </div>
                <select class="form-select group">
                    <?php
                        $groups = Group::getAll();

                        foreach ($groups as $group) :
                    ?>
                        <option value="<?=$group->getId()?>"> <?=$group->getDisplay()?> </option>
                    <?php endforeach; ?>
                </select>
                <div class="fw-bold"> Mật khẩu: </div>
                <input class="form-control password" type="password" name="password" required>
                <div class="fw-bold"> Nhập lại mật khẩu: </div>
                <input class="form-control password" type="password" name="retypepassword" required>
                <div class="fw-bold"> Họ tên: </div>
                <input class="form-control fullname" type="text" name="fullname" required>
                <div class="fw-bold"> Ngày sinh: </div>
                <input class="form-control birth" type="date" name="birth" required>
                <div class="fw-bold"> Địa chỉ: </div>
                <input class="form-control address" type="text" name="address" required>
                <div class="fw-bold"> Số điện thoại: </div>
                <input class="form-control phone" type="text" name="phone" required>
                <div class="fw-bold"> Email: </div>
                <input class="form-control email" type="text" name="email" required>
        </div>

        <div class="modal-footer">
            <button type="submit" class=" btn btn-primary"> Thêm </button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> Đóng </button>
      </div>
    </form>
</div>

<script> 
    $(".add-form").submit(function() {
        if (confirm("Xác nhận thêm tài khoản?")) {
            $.ajax({
                url: "/admin/user/add.php", 
                method: "POST",
                data: {username: $(".username")[0].value, group_id: $(".group")[0].value, password: $(".password")[0].value, fullname: $(".fullname")[0].value, birth: $(".birth")[0].value, address: $(".address")[0].value, phone: $(".phone")[0].value, email: $(".email")[0].value},
                success: function(response){
                    if (response == "success") {
                        alert("Thêm tài khoản thành công!");
                        $(".modal").modal("hide");
                        reloadAdmin();
                    }else if (response == "conflict") {
                        alert("Tên tài khoản đã tồn tại!");
                    }
                }
            });
        }
    });
</script>