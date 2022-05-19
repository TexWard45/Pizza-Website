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

$permissionArr = array(
    "login" => "Đăng nhập trang quản trị",
    "group" => "Quản lý nhóm tài khoản",
    "user" => "Quản lý tài khoản",
    "category" => "Quản lý danh mục bánh",
    "topping" => "Quản lý nhân bánh",
    "size" => "Quản lý kích thước bánh",
    "base" => "Quản lý đế bánh",
    "pizza" => "Quản lý bánh pizza",
    "order" => "Quản lý đơn hàng",
    "statistic" => "Thống kê báo cáo",
);
?>

<div class="modal-dialog">
    <form class="permission-form" onsubmit="return false;">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"> Phân quyền </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <?php
                foreach($permissionArr as $key => $value) :
                    $permission = "admin.".$key;

                    $isSet = UserPermission::isSet($username, $permission);
                    
                    $autoChecked = "";
                    $trueChecked = "";
                    $falseChecked = "";
                    if (!$isSet) {
                        $autoChecked = "checked";
                    }else {
                        if (UserPermission::has($username, $permission)) {
                            $trueChecked = "checked";
                        }else {
                            $falseChecked = "checked";
                        }
                    }
            ?>
                <div class="fw-bold"> <?=$value?>: </div>
                <div class="d-flex justify-content-between">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="<?=$key?>-permission" id="<?=$key?>-permission-true" <?=$trueChecked?> value="1">
                        <label class="form-check-label" for="group-permission-true">
                            Có
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="<?=$key?>-permission" id="<?=$key?>-permission-false" <?=$falseChecked?> value="0">
                        <label class="form-check-label" for="<?=$key?>-permission-false">
                            Không
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="<?=$key?>-permission" id="<?=$key?>-permission-auto" <?=$autoChecked?> value="-1">
                        <label class="form-check-label" for="<?=$key?>-permission-auto">
                            Tự động
                        </label>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="modal-footer">
            <button type="submit" class=" btn btn-primary"> Lưu </button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> Đóng </button>
      </div>
    </form>
</div>

<script> 
    $(".permission-form").submit(function() {
        if (confirm("Xác nhận lưu thay đổi?")) {
            $.ajax({
                url: "/admin/user/permission.php", 
                method: "POST",
                data: {
                    "username": "<?=$username?>",
                    "login_permission": $('input[name="login-permission"]:checked')[0].value,
                    "group_permission": $('input[name="group-permission"]:checked')[0].value,
                    "user_permission": $('input[name="user-permission"]:checked')[0].value,
                    "category_permission": $('input[name="category-permission"]:checked')[0].value,
                    "topping_permission": $('input[name="topping-permission"]:checked')[0].value,
                    "size_permission": $('input[name="size-permission"]:checked')[0].value,
                    "base_permission": $('input[name="base-permission"]:checked')[0].value,
                    "pizza_permission": $('input[name="pizza-permission"]:checked')[0].value,
                    "order_permission": $('input[name="order-permission"]:checked')[0].value,
                    "statistic_permission": $('input[name="statistic-permission"]:checked')[0].value,
                },
                success: function(response){
                    if (response == "success") {
                        alert("Phân quyền tài khoản thành công!");
                        $(".modal").modal("hide");
                        reloadAdmin();
                        reloadLeftMenu();
                    }
                }
            });
        }
    });
</script>