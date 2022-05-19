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

if (isset($_POST['display'])) {
    $display = str_replace("'", "''", $_POST['display']);
    $sizes = Size::getBySearch($display);
}else {
    $sizes = Size::getAll();
}
?>

<div class="p-3">
    <div class="d-flex justify-content-between">
        <div class="title">
            <span class="h3"> Quản lý kích thước bánh pizza </span>
        </div>

        <div class="operation">
            <div class="item" data-operation="search"> 
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                </svg> 
            </div>

            <div class="item" data-operation="info"> 
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                    <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                </svg>
            </div>

            <div class="item" data-operation="add"> 
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                </svg>
            </div>

            <div class="item" data-operation="edit"> 
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                    <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
                </svg>
            </div>

            <div class="item" data-operation="remove"> 
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                     <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                </svg>
            </div>
        </div>
    </div>
    <hr/>

    <?php
        if (count($sizes) == 0) :
    ?>
        <div> Không tìm thấy kích thước nào! </div>
    <?php else: ?>

    <div class="table-overflow">
    <table class="table">
        <tr>
            <th> </th>
            <th> Mã kích thước bánh </th>
            <th> Tên kích thước bánh </th>
            <th> Độ ưu tiên </th>
        </tr>

        <?php
            foreach ($sizes as $size) :
        ?>
            <tr>
                <td>
                    <input class="form-check-input checkbox" type="checkbox" data-id="<?=$size->getId()?>">
                </td>
                <td> <?=$size->getId()?> </td>
                <td> <?=$size->getDisplay()?> </td>
                <td> <?=$size->getPriority()?> </td>
            </tr>
        <?php endforeach; ?>
    </table>
    </div>

    <?php endif; ?>
</div>

<script>
    $(".item").click(function() {
        let operation = $(this)[0].dataset.operation;
        let arr = getSelects();
        $.ajax({
            url: "/admin/size/" + operation + "_form.php", 
            method: "POST",
            data: {id_array: arr},
            success: function(response) {
                if ((operation == "info" || operation == "edit" || operation == "permission" || operation == "remove" || operation == "lock") && arr.length == 0) {
                    alert("Chọn tối thiểu 1 dòng để thao tác!");
                    return;
                }

                if ((operation == "info" || operation == "edit" || operation == "permission" || operation == "lock") && arr.length > 1) {
                    alert("Chỉ có thể thao tác trên 1 dòng cùng lúc!");
                    return;
                }

                $(".modal").html(response);
                $(".modal").modal("show");
                uncheckAll();
            }
        });
    });
</script>