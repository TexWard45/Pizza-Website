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
include_once($_SERVER['DOCUMENT_ROOT'].'/object/order.php');

if(session_status() == PHP_SESSION_NONE){
    session_start();
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

if (isset($_SESSION['username'])) {
    if (User::hasPermission($_SESSION['username'], 'lock')) {
        unset($_SESSION['username']);
        echo "<script> alert('Tài khoản này đã bị khóa!') </script>";
        header("Location: /login");
        exit();
    }
}
?>

<style>
    .header-wrapper {
        width: 100%;
        background-color: var(--red-color);
    }

    .nav-cart-item {
        position: relative;
    }

    .nav-cart-count {
        position: absolute;
        right: -20px;
        top: 0px;
        color: white;
    }

    .right-menu {
        display: flex;
        color: white;
        padding: 8px;
    }

    .search-bar {
        position: relative;
        width: 280px;
    }

    .search-bar-icon {
        display: flex;
        position: absolute;
        width: 38px;
        height: 38px;
        border-radius: 5px;
        right: 0px;
        top: 0px;
        background-color: var(--bs-green);
        border: 0px;
    }

    .user-session {
        display: flex;
        padding-left: 1rem;
    }
</style>

<div class="header-wrapper">
    <nav class="navbar navbar-expand container navbar-light">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav" style="margin-right: auto">
                <li class="nav-item d-flex">
                    <img src="/img/logo.png" width="40" height="40">
                    <a class="nav-link text-white fw-bold" href="#"> FastPizza </a>
                </li>

                <li class="nav-item d-flex">
                    <a class="nav-link text-white <?=isset($_GET['site']) && $_GET['site'] == 'Trang chủ' ? 'fw-bold' : ''?>" href="/"> Trang chủ </a>
                </li>

                <li class="nav-item d-flex">
                    <a class="nav-link text-white <?=isset($_GET['site']) && $_GET['site'] == 'Khuyến mãi' ? 'fw-bold' : ''?>" href="/promotion"> Khuyến mãi </a>
                </li>

                <li class="nav-item d-flex">
                    <a class="nav-link text-white <?=isset($_GET['site']) && $_GET['site'] == 'Tìm kiếm' ? 'fw-bold' : ''?>" href="/browser"> Tìm kiếm </a>
                </li>

                <li class="nav-cart-item" class="nav-item">
                    <a class="nav-link text-white <?=isset($_GET['site']) && $_GET['site'] == 'Giỏ hàng' ? 'fw-bold' : ''?>" href="/cart"> Giỏ hàng </a>
                    <span class="nav-cart-count"> 
                        <?php 
                            $count = 0;

                            foreach ($_SESSION['cart'] as $item) {
                                $count += $item->getQuantity();
                            }
                            
                            echo "(".$count.")";
                        ?> 
                    </span>
                </li>
            </ul>

            <div class="right-menu">
                <div class="search-bar">
                    <form method="POST" action="/browser/index.php" <?=isset($_GET['site']) && $_GET['site'] == 'Tìm kiếm' ? 'onsubmit="return false;"' : ""?>>
                        <input class="form-control" type="text" id="search" name="search" placeholder="Nhập tên pizza cần tìm kiếm" value="<?=isset($_POST['search']) ? $_POST['search'] : ''?>">
                        <button class="search-bar-button btn btn-success search-bar-icon" type="submit">
                            <i class="bi bi-search center"></i>
                        </button>
                    </form>
                </div>

                <div class="user-session">
                    <?php
                        if(session_status() == PHP_SESSION_NONE){
                            session_start();
                        }

                        if (isset($_SESSION['username']) != null) :
                    ?>
                        <div class="d-flex align-items-center"> 
                            <div class="dropdown">
                                <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    <?=$_SESSION['username']?>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li><a class="dropdown-item view-information" href="#">Xem thông tin cá nhân</a></li>
                                    <li><a class="dropdown-item change-password" href="#">Đổi mật khẩu</a></li>
                                    <li><a class="dropdown-item history-purchase" href="/history/">Theo dõi đơn hàng</a></li>
                                </ul>
                            </div>

                            <a class="mx-2 btn btn-light text-danger" style="font-weight: 500" href="/logout.php"> Đăng xuất </a>
                        </div>
                    <?php else : ?>
                        <div class="d-flex"> 
                            <a href="/login" class="btn btn-success"> Đăng nhập </a>

                            <a href="/signup" class="mx-2 btn btn-success"> Đăng ký </a>
                        </div>
                    <?php endif; ?>
                </div> 
            </div>
        </div>
    </nav>
</div>

<script>
    $(".view-information").click(function() {
        $.ajax({
            url: "/view_information_form.php", 
            method: "POST",
            data: {},
            success: function(response){
                $(".modal").html(response);
                $(".modal").modal("show");
            }
        });
    });

    $(".change-password").click(function() {
        $.ajax({
            url: "/change_password_form.php", 
            method: "POST",
            data: {},
            success: function(response){
                $(".modal").html(response);
                $(".modal").modal("show");
            }
        });
    });

    function setCartCount(amount) {
        $(".nav-cart-count").html("(" + amount + ")");
    }

    function updateCartCount() {
        $.ajax({
            url: "/total_quantity_cart.php", 
            method: "POST",
            data: {},
            success: function(response){
                setCartCount(response);
            }
        });
    }
</script>