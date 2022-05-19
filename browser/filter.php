<p class="h5"> Danh mục </p>

<div class="form-check">
    <input class="form-check-input category" type="radio" name="category" id="category-all" checked>
    <label class="form-check-label" for="category-all">
        Tất cả
    </label>
</div>

<?php
$categories = Category::getAll();

foreach ($categories as $category) :
?>

<div class="form-check">
    <input class="form-check-input category category-item" type="radio" name="category" id="category-<?=$category->getId();?>" data-id="<?=$category->getId();?>">
    <label class="form-check-label" for="category-<?=$category->getId();?>">
        <?=$category->getDisplay();?>
    </label>
</div>

<?php endforeach; ?>

<p class="h5"> Nhân bánh </p>

<div class="form-check">
    <input class="form-check-input topping" type="checkbox" name="topping-all" id="topping-all" checked data-id="all">
    <label class="form-check-label" for="topping-all?>">
        Tất cả
    </label>
</div>

<?php
$toppings = Topping::getAll();

foreach ($toppings as $topping) :
?>

<div class="form-check">
    <input class="form-check-input topping topping-item" type="checkbox" name="topping-<?=$topping->getId();?>" id="topping-<?=$topping->getId();?>" data-id="<?=$topping->getId();?>" checked>
    <label class="form-check-label" for="topping-<?=$topping->getId();?>">
        <?=$topping->getDisplay();?>
    </label>
</div>

<?php endforeach; ?>

<script>
    $('.category').change(function(e) {
        updateProduct();
    });

    $('.search-bar-button').click(function(e) {
        updateProduct();
    });

    $('.topping').change(function(e) {
        let id = e.target.dataset.id;

        if (id == 'all') {
            $('.topping-item').prop("checked", e.target.checked);
        }else {
            if (!e.target.checked) {
                $('#topping-all').prop("checked", false);
            }else {
                let noFalse = true;

                $('.topping-item').each(function(index, value) {
                    noFalse = noFalse && value.checked;
                });

                $('#topping-all').prop("checked", noFalse);
            }
        }

        updateProduct();
    });

    function updateProduct() {
        $.ajax({
            url: "/browser/product.php", 
            method: "POST",
            data: {"category": getCategory(), "toppingArr": getToppingList(), "notToppingArr": getNotToppingList(), "search": getSearch()},
            success: function(response){
                $(".browser-product").html(response);
            }
        });
    }

    function getToppingList() {
        if ($('#topping-all')[0].checked) {
            return ['all'];
        }
        let arr = [];

        $('.topping-item').each(function(index, value) {
            if (value.checked) {
                arr.push(value.dataset.id);
            }
        });

        if (arr.length == 0) {
            return ['empty'];
        }

        return arr;
    }

    function getNotToppingList() {
        let arr = [];

        $('.topping-item').each(function(index, value) {
            if (!value.checked) {
                arr.push(value.dataset.id);
            }
        });

        if (arr.length == 0) {
            return ['empty'];
        }

        return arr;
    }

    function getCategory() {
        let id = 'all';
        $('.category-item').each(function(index, value) {
            if (value.checked) {
                id = value.dataset.id;
            }
        });
        return id;
    }

    function getSearch() {
        return $('#search')[0].value;
    }
</script>