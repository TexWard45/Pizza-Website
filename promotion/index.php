<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="/node_modules/jquery/dist/jquery.js"></script>
    <script src="/node_modules/@popperjs/core/dist/umd/popper.js"></script>
    <script src="/node_modules/bootstrap/dist/js/bootstrap.js"></script>
    <link rel="shortcut icon" type="image/ico" href="/img/logo.ico">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/node_modules/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" href="/node_modules/bootstrap-icons/font/bootstrap-icons.css">
    <title> Khuyến mãi </title>
</head>

<style>
    body {
        margin: 0px;
    }

    .wrapper {
        width: 100%;
    }

    .promotion-wrapper {
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .promotion-container {
        display: flex;
        flex-direction: row;
        gap: 0.5rem;
    }

    .promotion-image {
        border: 3px solid black;
        border-radius: 10px;
    }

    .promotion-image > img {
        height: 240px;
        padding: 20px;
    }

    .promotion-content {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        border: 3px solid black;
        border-radius: 10px;
        flex: 1;
        padding: 0.5rem 1rem;
    }

    .promotion-title {
        text-transform: uppercase;
        font-size: 1.75rem;
        font-weight: bold;
        color: var(--red-color);
    }

    .promotion-text {
        font-size: 1.25rem;
        font-weight: bold;
    }

    .font-weight-bold {
        font-weight: bold;
    }

    .promotion-button {
        margin-top: 1rem;
    }
</style>

<?php
    include('../connection.php');
    include('../api.php');
    include('../object/cart.php');
    include('../object/category.php');
    include('../object/topping.php');
    include('../object/pizza.php');
    include('../object/size.php');
    include('../object/base.php');
    include('../object/user.php');
    include('../object/pizza_detail.php');

    if(session_status() == PHP_SESSION_NONE){
        session_start();
    }
?>

<body class="wrapper">
    <?php $_GET['site'] = 'Khuyến mãi'?>
    <?php include('../header.php');?>

    <div class="container py-3" style="padding-bottom: 0px !important">
        <p class="h3"> Khuyến mãi </p>
        <hr/>
    </div>

    <div class="promotion-wrapper container">
        <div class="promotion-container"> 
            <div class="promotion-image"> 
                <img src="/img/promotion/promotion0.png"> 
            </div>

            <div class="promotion-content">
                <div> 
                    <div class="promotion-title">
                        MUA 1 TẶNG 1 THỨ 3
                    </div> 

                    <hr />

                    <div class="promotion-text">
                        Mua 1 bánh Pizza size Vừa/Lớn kèm Nước uống bất kỳ sẽ được tặng 1 bánh Pizza cùng cỡ.
                    </div> 
                </div>

                <div> 
                    <button class="btn btn-success font-weight-bold"> Đặt ngay size Vừa </button>

                    <button class="btn btn-success font-weight-bold"> Đặt ngay size Lớn </button>
                </div>
            </div> 
        </div>

        <div class="promotion-container"> 
            <div class="promotion-image"> 
                <img src="/img/promotion/promotion1.png"> 
            </div>

            <div class="promotion-content">
                <div> 
                    <div class="promotion-title">
                        GIẢM 70% CHO PIZZA THỨ 2 - ÁP DỤNG MUA MANG VỀ & GIAO HÀNG TẬN NƠI
                    </div> 

                    <hr />

                    <div class="promotion-text">
                        * Mua Pizza size Vừa hoặc Lớn kèm nước uống nguyên giá được giảm 70% cho bánh Pizza thứ 2 cùng size có giá bằng hoặc thấp hơn Pizza thứ nhất.
                    </div>
                    <div class="promotion-text">
                        * Áp dụng cho Mua Mang Về & Giao Hàng Tận Nơi tất cả các ngày trong tuần.
                    </div> 
                </div>

                <div class="promotion-button"> 
                    <button class="btn btn-success font-weight-bold"> Đặt ngay size Vừa </button>

                    <button class="btn btn-success font-weight-bold"> Đặt ngay size Lớn </button>
                </div>
            </div> 
        </div>

        <div class="promotion-container"> 
            <div class="promotion-image"> 
                <img src="/img/promotion/promotion2.png"> 
            </div>

            <div class="promotion-content">
                <div> 
                    <div class="promotion-title">
                        DEAL SIÊU TO CHO NHÓM
                    </div> 

                    <hr />

                    <div class="promotion-text">
                        * Combo 229K cho 2 người gồm 1 pizza size Vừa + 1 chai nước (390ml)
                    </div>
                    <div class="promotion-text">
                        * Combo 309K cho 3-4 người gồm 1 pizza size Lớn + 2 chai nước (390ml)
                    </div> 
                    <div class="promotion-text">
                        * Combo 339K cho 3-4 người gồm 1 pizza size Lớn + 1 chai nước (1.5L)
                    </div> 
                </div>

                <div class="promotion-button"> 
                    <button class="btn btn-success font-weight-bold"> Combo 229k </button>

                    <button class="btn btn-success font-weight-bold"> Combo 309k </button>

                    <button class="btn btn-success font-weight-bold"> Combo 339k </button>
                </div>
            </div> 
        </div>
    </div>

    <div class="modal" tabindex="-1">
    </div>
</body>
</html>
