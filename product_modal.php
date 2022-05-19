<?php
include($_SERVER['DOCUMENT_ROOT'].'/connection.php');
include($_SERVER['DOCUMENT_ROOT'].'/api.php');
include($_SERVER['DOCUMENT_ROOT'].'/object/pizza.php');
include($_SERVER['DOCUMENT_ROOT'].'/object/pizza_detail.php');
include($_SERVER['DOCUMENT_ROOT'].'/object/size.php');
include($_SERVER['DOCUMENT_ROOT'].'/object/base.php');

$pizza = Pizza::getById($_POST['id']);
$pizzaDetail = PizzaDetail::getAllByPizzaId($_POST['id']);
$sizeArr = Size::getAllByPizzaId($_POST['id']);

if (isset($_POST['size_id'])) {
    $postSizeId = $_POST['size_id'];
}

if (isset($_POST['base_id'])) {
    $postBaseId = $_POST['base_id'];
}

if (count($sizeArr) > 0 && !isset($_POST['size_id'])) {
    $postSizeId = $sizeArr[0]->getId();
}

$baseArr = Base::getAllByPizzaIdAndSizeId($_POST['id'], $postSizeId);

if (count($baseArr) > 0 && (!isset($_POST['base_id']) || isset($_POST['change']) && $_POST['change'] == 'size')) {
    $postBaseId = $baseArr[0]->getId();
}

$currentPizzaDetail = PizzaDetail::getBySizeBasePizzaId($postSizeId, $postBaseId, $_POST['id']);

$currentSize = Size::getById($postSizeId);
$currentBase = Base::getById($postBaseId);

$price = toMoney($currentPizzaDetail->getPrice());
?>

<div class="modal-dialog" style="max-width: 1020px !important">
    <div class="modal-content" style="flex-direction: row; border-radius: 5px; height: 700px">
        <div class="modal-header" style="flex-direction: column; border-radius: 5px; justify-content: unset !important;">
            <img src="/img/pizza/<?=$pizza->getImage();?>" class="card-img-top" alt="..." style="width: 450px; height: 450px">
            <h3> <?=$price?> </h3>
        </div>
        <div class="modal-body" style="background-color: #fafafa; border-radius: 5px; max-width: 536px">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="position: absolute; right: 20px; top: 20px;"></button>
            <h3 class="modal-title"> <?=$pizza->getDisplay()?> </h3>
            <p style="color:#00B041"> Kích thước <?=$currentSize->getDisplay()?> - Đế <?=$currentBase->getDisplay()?> </p>
            <p> <?=$pizza->getDescription()?> </p>
            <hr/>
            <h5> Kích thước </h5>

            <?php
                $index = 0;

                foreach($sizeArr as $size) :
                    $currentSizeId = $size->getId();
            ?>

                <div class="form-check">
                    <input class="form-check-input size size-item" type="radio" name="size" id="size-<?=$size->getId();?>" data-id="<?=$size->getId();?>" <?=$currentSizeId == $postSizeId ? "checked" : ""?>>
                    <label class="form-check-label" for="size-<?=$size->getId();?>">
                        <?=$size->getDisplay();?>
                    </label>
                </div>

            <?php endforeach; ?>

            <hr/>

            <h5> Đế bánh </h5>

            <?php
                $index = 0;

                foreach($baseArr as $base) :
                    $currentBaseId = $base->getId();
            ?>

                <div class="form-check">
                    <input class="form-check-input base base-item" type="radio" name="base" id="base-<?=$base->getId();?>" data-id="<?=$base->getId();?>" <?=$currentBaseId == $postBaseId ? "checked" : ""?>>
                    <label class="form-check-label" for="base-<?=$base->getId();?>">
                        <?=$base->getDisplay();?>
                    </label>
                </div>

            <?php endforeach; ?>

            <hr/>

            <?php
                if ($currentPizzaDetail->getQuantity() > 0) :
            ?>
                <button class="add-cart-button btn btn-success" style="position:absolute; bottom: 20px; font-size: 1.0rem; font-weight: 600; width: 500px"> Thêm vào giỏ hàng </button>
            <?php
                else :
            ?>
                <button class="sold-out-button2 btn btn-danger" style="position:absolute; bottom: 20px; font-size: 1.0rem; font-weight: 600; width: 500px"> Đã bán hết </button>
            <?php endif;?>
        </div>
    </div>
</div>

<script>
    function getBase() {
        let id = 0;
        $('.base').each(function(index, value) {
            if (value.checked) {
                id = value.dataset.id;
            }
        });
        return id;
    }

    function getSize() {
        let id = 0;
        $('.size').each(function(index, value) {
            if (value.checked) {
                id = value.dataset.id;
            }
        });
        return id;
    }

    $('.size').change(function(e) {
        $.ajax({
            url: "/product_modal.php", 
            method: "POST",
            data: {"base_id": getBase(), "size_id": e.target.dataset.id, "id": <?=$_POST['id']?>, "change": "size"},
            success: function(response){
                $(".modal").html(response);
            }
        });
    });

    $('.base').change(function(e) {
        $.ajax({
            url: "/product_modal.php", 
            method: "POST",
            data: {"base_id": e.target.dataset.id, "size_id": getSize(), "id": <?=$_POST['id']?>, "change": "base"},
            success: function(response){
                $(".modal").html(response);
            }
        });
    });

    $('.sold-out-button2').click(function(e) {
        alert("Rất tiếc mẫu bánh này đã hết, bạn có thể lựa chọn kích thước, đế bánh khác cùng loại!");
    });

    $('.add-cart-button').click(function(e) {
        $.ajax({
            url: "/add_cart.php", 
            method: "POST",
            data: {"base_id": getBase(), "size_id": getSize(), "pizza_id": <?=$_POST['id']?>},
            success: function(response){
                if (response == "success") {
                    alert("Thêm vào giỏ hàng thành công!");
                    updateCartCount();
                }else {
                    alert("Tối đa 9 bánh pizza cùng loại trong giỏ hàng!");
                }
            }
        });
    });
</script>