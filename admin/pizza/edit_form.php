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
$pizza = Pizza::getById($id);
?>

<style>
    .modal-body {
        max-height: 70vh;
        overflow-y: auto;
    }

    .form-check-input.size:checked ~ .base-div {
        display: unset !important;
    }

    .form-check-input.base:checked ~ .detail-div {
        display: unset !important;
    }
</style>

<div class="modal-dialog">
    <form class="edit-form" onsubmit="return false;" method="post" enctype="multipart/form-data" action="/game/pizza/edit.php">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"> Sửa bánh pizza </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
                <div class="fw-bold"> Tên bánh: </div>
                <input class="form-control display" type="text" name="display" value="<?=$pizza->getDisplay()?>" required>
                <div class="fw-bold"> Danh mục bánh: </div>
                <select class="form-select group" name="category">
                    <?php
                        $categories = Category::getAll();

                        foreach ($categories as $category) :
                    ?>
                        <option value="<?=$category->getId()?>" <?=$category->getId() == $pizza->getCategoryId() ? 'selected="selected"' : ''?>> <?=$category->getDisplay()?> </option>
                    <?php endforeach; ?>
                </select>
                <div class="fw-bold"> Mô tả: </div>
                <textarea class="form-control description" name="description" rows="3" required><?=$pizza->getDescription()?></textarea>
                <div class="fw-bold"> Hình ảnh: </div>
                <input class="form-control image" type="file" name="image">
                <div class="fw-bold"> Nhân bánh: </div>
                <div style="height: 130px; overflow-y:auto">
                <?php
                    global $connection;

                    $toppings = Topping::getAll();

                    foreach ($toppings as $topping) :
                        $toppingId = $topping->getId();
                        $sql = "SELECT * FROM topping_detail WHERE pizza_id = $id AND topping_id = $toppingId";
                        $toppingCheck = ($connection->query($sql)->num_rows) > 0;
                    ?>

                    <div class="form-check">
                        <input class="form-check-input topping" type="checkbox" name="topping-<?=$topping->getId();?>" id="topping-<?=$topping->getId();?>" data-id="<?=$topping->getId();?>" <?=$toppingCheck ? "checked" : ""?>>
                        <label class="form-check-label" for="topping-<?=$topping->getId();?>">
                            <?=$topping->getDisplay();?>
                        </label>
                    </div>

                    <?php endforeach; ?>
                </div>
                <div class="fw-bold"> Kích thước: </div>
                <?php
                    $sizes = Size::getAll();

                    foreach ($sizes as $size) :
                        $sizeId = $size->getId();
                        $sql = "SELECT * FROM pizza_detail WHERE pizza_id = $id AND size_id = $sizeId";
                        $sizeCheck = ($connection->query($sql)->num_rows) > 0;
                ?>
                    <div class="form-check">
                        <input class="form-check-input size" type="checkbox" name="size-<?=$size->getId();?>" id="size-<?=$size->getId();?>" data-id="<?=$size->getId();?>" <?=$sizeCheck ? "checked" : ""?>>
                        <label class="form-check-label" for="size-<?=$size->getId();?>">
                            <?=$size->getDisplay();?>
                        </label>
                        <div class="base-div" style="display: none"> 
                            <?php
                                $bases = Base::getAll();

                                foreach ($bases as $base) :
                                    $baseId = $base->getId();
                                    $sql = "SELECT * FROM pizza_detail WHERE pizza_id = $id AND size_id = $sizeId AND base_id = $baseId";

                                    $result = $connection->query($sql);
                                    $baseCheck = false;
                                    
                                    if ($result->num_rows > 0) {
                                        $baseCheck = true;
                                        
                                        while($row = $result->fetch_assoc()) {
                                            $price = $row['price'];
                                            $quantity = $row['quantity'];
                                        }
                                    }else {
                                        $price = "";
                                        $quantity = "";
                                    }

                            ?>
                                <div class="form-check">
                                    <input class="form-check-input base base-<?=$size->getId()?>" type="checkbox" name="base-<?=$base->getId();?>" id="base-<?=$base->getId();?>" data-id="<?=$base->getId();?>" <?=$baseCheck ? "checked" : ""?>>
                                    <label class="form-check-label" for="base-<?=$base->getId();?>">
                                        <?=$base->getDisplay();?>
                                    </label>
                                    <div class="detail-div" style="display: none"> 
                                        <div class="d-flex mb-2">
                                            <input type="text" readonly="" class="form-control-plaintext" value="Giá">
                                            <input class="form-control price-<?=$size->getId()?>-<?=$base->getId()?>" type="text" id="price-<?=$base->getId()?>" value="<?=$price?>">
                                        </div>

                                        <div class="d-flex">
                                            <input type="text" readonly="" class="form-control-plaintext" value="Số lượng">
                                            <input class="form-control amount-<?=$size->getId()?>-<?=$base->getId()?>" type="number" id="amount-<?=$base->getId()?>" value="<?=$quantity?>">
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach;?>
                        </div>
                    </div>

                    <hr />
                <?php endforeach; ?>
        </div>

        <div class="modal-footer">
            <button type="submit" class=" btn btn-primary"> Sửa </button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> Đóng </button>
      </div>
    </form>
</div>

<script> 
    $(".edit-form").submit(function() {
        if (getToppingList().length == 0) {
            alert("Chọn tối thiểu 1 nhân bánh pizza");
            return;
        }

        if (confirm("Xác nhận sửa bánh pizza?")) {
            let formData = new FormData(this);
            formData.append('id', "<?=$id?>");
            
            $('.topping').each(function(index, value) {
                formData.append("topping-value.dataset.id", value.checked);
            });


            $('.size').each(function(index, value) {
                if (value.checked) {
                    let sizeId = value.dataset.id;
                    $('.base-' + sizeId).each(function(index, value) {
                        if (value.checked) {
                            let baseId = value.dataset.id;
                            
                            let price = $('.price-' + sizeId + "-" + baseId)[0].value;
                            let amount = $('.amount-' + sizeId + "-" + baseId)[0].value;

                            formData.append("price-" + sizeId + "-" + baseId, price);
                            formData.append("amount-" + sizeId + "-" + baseId, amount);
                        }
                    });
                }
            });

            $.ajax({
                url: "/admin/pizza/edit.php", 
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response){
                    alert(response);
                    $(".modal").modal("hide");
                    reloadAdmin();
                }
            });
        }
    });

    function getToppingList() {
        let arr = [];

        $('.topping').each(function(index, value) {
            if (value.checked) {
                arr.push(value.dataset.id);
            }
        });

        return arr;
    }
</script>