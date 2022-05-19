<style>
    .menu-logo {
        display: flex;
        position: relative;
        width: 100%;
        height: 120px;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }

    .menu-item {
        width: 100%;
        margin-top: 0.25rem !important;
        margin-bottom: 0.25rem !important;
    }
</style>

<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/connection.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/api.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/object/group.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/object/user.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/object/cart.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/object/category.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/object/topping.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/object/pizza.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/object/size.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/object/base.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/object/pizza_detail.php');

if(session_status() == PHP_SESSION_NONE){
    session_start();
}

$items = array(
    "group" => "Nhóm tài khoản",
    "user" => "Tài khoản",
    "category" => "Danh mục bánh pizza",
    "topping" => "Nhân bánh pizza",
    "size" => "Kích thước bánh pizza",
    "base" => "Đế bánh pizza",
    "pizza" => "Bánh pizza",
    "order" => "Đơn hàng",
    "statistic" => "Thống kê báo cáo",
);
?>

<div>
    <div class="menu-logo">
        <img src="/img/logo.png" width="75px" height="75px"> </img>
        <span class="fw-bold" style="font-size: 1.2rem; margin-left: 10px; color: white"> FastPizza </span>
    </div>

    <?php
        foreach($items as $key => $value) :
            if (!User::hasPermission($_SESSION['username'], "admin.".$key)) {
                continue;
            }
    ?>
        <button class="btn btn-secondary menu-item" data-path="<?=$key?>"> <?=$value?> </button>
    <?php endforeach; ?>
</div>


<div>
    <div class="btn d-flex my-2 btn-primary" style="color: white; justify-content: center; align-items:center"> 
        <?=$_SESSION['username']?>
    </div>

    <a class="btn d-flex p-3" style="background-color: var(--red-color); color: white; justify-content: center; align-items:center" href="/logout.php"> 
        Đăng xuất
    </a>
</div>

<script>
var currentMenu = "user";

$(".menu-item").click(function() {
    let element = $(this)[0];

    currentMenu = element.dataset.path;

    $.ajax({
        url: "/admin/" + element.dataset.path + "/index.php", 
        method: "POST",
        data: {},
        success: function(response){
            if (response == 'no_permission') {
                alert("Bạn không có quyền truy cập!");
            }else {
                $(".content").html(response);
            }
        }
    });
});

function reloadAdmin() {
    $.ajax({
        url: "/admin/" + currentMenu + "/index.php", 
        method: "POST",
        data: {},
        success: function(response){
            $(".content").html(response);
        }
    });
}

function reloadLeftMenu() {
    $.ajax({
        url: "/admin/left_menu.php", 
        method: "POST",
        data: {},
        success: function(response){
            $(".left-menu").html(response);
        }
    });
}
</script>