<?php
include_once('../connection.php');
include_once('../api.php');
include_once('../object/category.php');
include_once('../object/topping.php');
include_once('../object/pizza.php');
include_once('../object/pizza_detail.php');

if (isset($_POST['category']) && isset($_POST['toppingArr']) && isset($_POST['notToppingArr']) && isset($_POST['search'])) {
    $pizzaArr = Pizza::getByFilter($_POST['category'], $_POST['toppingArr'], $_POST['notToppingArr'], $_POST['search']);
}else if (isset($_POST['search'])) {
    $pizzaArr = Pizza::getByFilter('all', ['all'], [''], $_POST['search']);
}else {
    $pizzaArr = Pizza::getAll();
}

if (count($pizzaArr) == 0) {
    echo '<p> Không tìm thấy bất cứ pizza nào! </p>';
    exit();
}


foreach ($pizzaArr as $pizza) :

$arr = PizzaDetail::getAllByPizzaId($pizza->getId());

if (count($arr) <= 0) {
    continue;
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
<?php endforeach; ?>

<script>
    $(".sold-out-button").click(function(e) {
        alert("Loại bánh này đã được bán hết. Bạn có thể chọn loại bánh khác!");
    });

    $(".product-button").click(function(e) {
        $.ajax({
            url: "../product_modal.php", 
            method: "POST",
            data: {id: e.target.dataset.id},
            success: function(response){
                $(".modal").html(response);
                $(".modal").modal("show");
            }
        });
    });
</script>