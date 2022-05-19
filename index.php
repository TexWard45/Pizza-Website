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
    <title> Trang chủ </title>
</head>

<?php
    include('connection.php');
    include('api.php');
    include('object/cart.php');
    include('object/category.php');
    include('object/topping.php');
    include('object/pizza.php');
    include('object/pizza_detail.php');
?>

<body>
    <?php $_GET['site'] = 'Trang chủ'?>
    <?php include('header.php');?>

    <div class="modal" tabindex="-1">
    </div>

    <div class="container">
        <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel" style="padding: 1rem 10rem;">
            <div class="carousel-inner">
                <div class="carousel-item active">
                <img src="/img/introduce.png" class="d-block w-100" alt="..." style="border-radius: 10px">
                </div>
                <div class="carousel-item">
                <img src="/img/introduce2.png" class="d-block w-100" alt="..." style="border-radius: 10px;">
                </div>
                <div class="carousel-item">
                <img src="/img/introduce.png" class="d-block w-100" alt="..." style="border-radius: 10px">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

        <div style="padding: 1rem 9rem;">
            <?php
                $categories = Category::getAll();

                foreach($categories as $category) :
                    $pizzaArr = Pizza::getByCategoryId($category->getId());

                    $size = count($pizzaArr) < 4 ? count($pizzaArr) : 4; 
            ?>
            <h3 style="padding: 1rem"> <?=$category->getDisplay()?> </h3>
            <div style="display: flex; flex-direction: row">
            <?php
                    for ($i = 0; $i < $size; $i++) :
                        $pizza = $pizzaArr[$i];
                        $arr = PizzaDetail::getAllByPizzaId($pizza->getId());
    
                        if (count($arr) <= 0) {
                            break;
                        }
                        
                        $price = toMoney($arr[0]->getPrice());
            ?>
            
            <div class="card" style="max-width: 18rem; max-height: 28rem; margin: 0rem 1rem 2rem 1rem;">
                <img src="/img/pizza/<?=$pizza->getImage();?>" class="card-img-top" alt="..." style="width: 285px; height: 286px">
                <div class="card-body">
                    <h5 class="card-title"> <?=$pizza->getDisplay();?> </h5>
                    <p class="card-text" style="
                        display: -webkit-box;
                        -webkit-line-clamp: 2;
                        -webkit-box-orient: vertical;
                        overflow: hidden;
                        text-overflow: ellipsis;
                    "> <?=$pizza->getDescription();?> </p>

                    <div class="d-flex justify-content-between"> 
                        <span class="d-flex align-items-center h4 m-0"> <?=$price?> </span>

                        <?php 
                            $pizzaDetail = PizzaDetail::getTotalQuantity($pizza->getId());

                            if ($pizzaDetail->getQuantity() > 0) :
                        ?>
                            <a href="#" class="product-button btn btn-success" style="float: right" data-id="<?=$pizza->getId()?>"> Mua ngay </a>
                        <?php else : ?>
                            <a href="#" class="sold-out-button btn btn-danger" style="float: right" data-id="<?=$pizza->getId()?>"> Đã bán hết </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <?php endfor; ?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>

<script>
    $(".sold-out-button").click(function(e) {
        alert("Loại bánh này đã được bán hết. Bạn có thể chọn loại bánh khác!");
    });

    $(".product-button").click(function(e) {
        $.ajax({
            url: "product_modal.php", 
            method: "POST",
            data: {id: e.target.dataset.id},
            success: function(response){
                $(".modal").html(response);
                $(".modal").modal("show");
            }
        });
    });
</script>