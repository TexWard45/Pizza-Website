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
            <h5 class="modal-title"> Đổi mật khẩu </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
                <div class="fw-bold"> Mật khẩu cũ: </div>
                <input class="form-control oldpassword" type="password" name="oldpassword" required>
                <div class="invalid-feedback oldpasswordinvalid">
                    Mật khẩu cũ không chính xác!
                </div>
                <div class="fw-bold"> Mật khẩu mới: </div>
                <input class="form-control newpassword" type="password" name="newpassword" required>
                <div class="fw-bold"> Nhập lại mật khẩu mới: </div>
                <input class="form-control retypenewpassword" type="password" name="retypenewpassword" required>
                <div class="invalid-feedback retypenewpasswordinvalid">
                    Nhập lại mật khẩu mới không khớp!
                </div>
        </div>

        <div class="modal-footer">
            <button type="submit" class=" btn btn-primary"> Lưu thay đổi </button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> Đóng </button>
      </div>
    </form>
</div>

<script> 
    $(".edit-information-form").submit(function() {
        $.ajax({
            url: "/check_password.php", 
            method: "POST",
            data: {password: $(".oldpassword")[0].value},
            success: function(response) {
                if (response == 'true') {
                    if ($(".newpassword")[0].value != $(".retypenewpassword")[0].value) {
                        $(".retypenewpasswordinvalid").show();
                        return;
                    }

                    if (confirm("Xác nhận lưu thay đổi?")) {
                        $.ajax({
                        url: "/change_password.php", 
                            method: "POST",
                            data: {password: $(".newpassword")[0].value},
                            success: function(response){
                                alert("Lưu thay đổi thành công!");
                                $(".modal").modal("hide");
                            }
                        });
                    }
                }else {
                    $(".oldpasswordinvalid").show();
                }
            }
        });
    });
</script>