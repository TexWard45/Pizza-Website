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
$base = Base::getById($id);
?>

<div class="modal-dialog">
    <form class="edit-information-form" onsubmit="return false;">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"> Xem đế bánh pizza </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
                <div class="fw-bold"> Tên đế bánh: </div>
                <div> <?=$base->getDisplay()?> </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> Đóng </button>
      </div>
    </form>
</div>