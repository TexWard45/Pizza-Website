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
    <form class="edit-form" onsubmit="return false;">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"> Sửa tài khoản </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
                <div class="fw-bold"> Tên tài khoản: </div>
                <div> <?=$user->getUsername()?> </div>
                <div class="fw-bold"> Nhóm tài khoản: </div>
                <select class="form-select group">
                    <?php
                        $groups = Group::getAll();

                        foreach ($groups as $group) :
                    ?>
                        <option value="<?=$group->getId()?>" <?=$group->getId() == $user->getGroupId() ? "selected" : ""?>> <?=$group->getDisplay()?> </option>
                    <?php endforeach; ?>
                </select>
                <div class="fw-bold"> Mật khẩu mới: </div>
                <input class="form-control password" type="password" name="password">
                <div class="fw-bold"> Nhập lại mật khẩu mới: </div>
                <input class="form-control password" type="password" name="retypepassword">
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
            <button type="submit" class=" btn btn-primary"> Sửa </button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> Đóng </button>
      </div>
    </form>
</div>

<script> 
    $(".edit-form").submit(function() {
        if (confirm("Xác nhận sửa tài khoản?")) {
            $.ajax({
                url: "/admin/user/edit.php", 
                method: "POST",
                data: {username: "<?=$username?>", group_id: $(".group")[0].value, password: $(".password")[0].value, fullname: $(".fullname")[0].value, birth: $(".birth")[0].value, address: $(".address")[0].value, phone: $(".phone")[0].value, email: $(".email")[0].value},
                success: function(response){
                    console.log(response);
                    if (response == "success") {
                        alert("Sửa tài khoản thành công!");
                        $(".modal").modal("hide");
                        reloadAdmin();
                    }
                }
            });
        }
    });
</script>