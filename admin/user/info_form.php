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
    <form class="edit-information-form" onsubmit="return false;">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"> Xem tài khoản </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
                <div class="fw-bold"> Tên tài khoản: </div>
                <div> <?=$user->getUsername()?> </div>
                <div class="fw-bold"> Nhóm tài khoản: </div>
                <div> <?=Group::getById($user->getGroupId())->getDisplay()?> </div>
                <div class="fw-bold"> Họ tên: </div>
                <div> <?=$user->getFullname()?> </div>
                <div class="fw-bold"> Ngày sinh: </div>
                <div> <?=$user->getBirth()?> </div>
                <div class="fw-bold"> Địa chỉ: </div>
                <div> <?=$user->getAddress()?> </div>
                <div class="fw-bold"> Số điện thoại: </div>
                <div> <?=$user->getPhone()?> </div>
                <div class="fw-bold"> Email: </div>
                <div> <?=$user->getEmail()?> </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> Đóng </button>
      </div>
    </form>
</div>