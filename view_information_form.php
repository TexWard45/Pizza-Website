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
    <form class="view-information-form" onsubmit="return false;">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"> Xem thông tin cá nhân </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
                <div class="fw-bold"> Họ tên: </div>
                <span> <?=$user->getFullname()?> </span>
                <div class="fw-bold"> Ngày sinh: </div>
                <span> <?=$user->getBirth()?> </span>
                <div class="fw-bold"> Địa chỉ: </div>
                <span> <?=$user->getAddress()?> </span>
                <div class="fw-bold"> Số điện thoại: </div>
                <span> 
                    <?php 
                        $phone = $user->getPhone();
                        $length = strlen($phone);

                        for ($i = $length - 1; $i >= max(0, $length - 3); $i--) {
                            $phone[$i] = '*';
                        }

                        echo $phone;
                    ?> 
                </span>
                <div class="fw-bold"> Email: </div>
                <span> <?=$user->getEmail()?> </span>
        </div>

        <div class="modal-footer">
            <button type="submit" class=" btn btn-primary"> Chỉnh sửa </button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> Đóng </button>
      </div>
    </form>
</div>

<script> 
    $(".view-information-form").submit(function() {
        $.ajax({
            url: "/edit_information_form.php", 
            method: "POST",
            success: function(response){
                $(".modal").html(response);
            }
        });
    });
</script>