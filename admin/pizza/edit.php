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

if (!isset($_FILES["image"]) || $_FILES["image"]['error'] != 0) {
    if (isset($_POST['display']) && isset($_POST['description']) && isset($_POST['category'])) {
        // Kiểm tra dữ liệu gửi đến
        $category_id = $_POST['category'];
        $display = str_replace("'", "''", $_POST['display']);
        $description = $_POST['description'];
        $image = $_FILES["image"]["name"];
        $pizza_id = $_POST['id'];
        $sql = "UPDATE pizza SET category_id = '$category_id', display = '$display', description = '$description' WHERE id = '$pizza_id'";
        $connection->query($sql);

        $sql = "DELETE FROM topping_detail WHERE pizza_id = $pizza_id";
        $connection->query($sql);

        $toppings = Topping::getAll();
        foreach ($toppings as $topping) {
            if (isset($_POST['topping-'.$topping->getId()]) && $_POST['topping-' . $topping->getId()]) {
                $topping_id = $topping->getId();
                $sql = "INSERT INTO topping_detail(pizza_id, topping_id) VALUES
                        ('$pizza_id', '$topping_id')";
                $connection->query($sql);
            }
        }

        $sql = "DELETE FROM pizza_detail WHERE pizza_id = $pizza_id";
        $connection->query($sql);

        $sizes = Size::getAll();

        foreach($sizes as $size) {
            $sizeId = $size->getId();

            $bases = Base::getAll();
            foreach($bases as $base) {
                $baseId = $base->getId();

                if (isset($_POST["price-$sizeId-$baseId"]) && isset($_POST["amount-$sizeId-$baseId"])) {
                    $price = $_POST["price-$sizeId-$baseId"];
                    $amount = $_POST["amount-$sizeId-$baseId"];

                    $sql = "INSERT INTO pizza_detail(pizza_id, size_id, base_id, price, quantity) VALUES
                        ('$pizza_id', '$sizeId', '$baseId', '$price', '$amount')";
                    $connection->query($sql);
                }
            }
        }

        // Trỏ về trang sản phẩm và thông báo tạo thành công
        echo "Sửa sản phẩm thành công";
        exit;
    }  
    exit;
}

$temp = explode(".", $_FILES["image"]["name"]);
$newfilename = round(microtime(true)) . '.' . end($temp);
$target_dir    = $_SERVER["DOCUMENT_ROOT"]."/img/pizza/";
$target_file   = $target_dir . basename($_FILES["image"]["name"]);

$allowUpload = true;

$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

$maxfilesize = 2000000;

$allowtypes = array('jpg', 'png');

if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if($check !== false) {
        $allowUpload = true;
    } else {
        $allowUpload = false;
    }
}

if (file_exists($target_file)) {
    echo "Đã tồn tại file trong hệ thống, không thể ghi đè file!";
    exit;
}

if ($_FILES["image"]["size"] > $maxfilesize) {
    echo "File tối đa 2MB!";
    exit;
}

if (!in_array($imageFileType,$allowtypes )) {
    echo "Chỉ có thể tải file dạng JPG, PNG!";
    exit;
}

if ($allowUpload) {
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        if (isset($_POST['display']) && isset($_POST['description']) && isset($_POST['category'])) {
        // Kiểm tra dữ liệu gửi đến
            $category_id = $_POST['category'];
            $display = $_POST['display'];
            $description = $_POST['description'];
            $image = $_FILES["image"]["name"];
            $sql = "INSERT INTO pizza(category_id, display, description, image) VALUES
                    ('$category_id', '$display', '$description', '$image')";
    
            $connection->query($sql);
            $pizza_id = $connection->insert_id;

            $sql = "DELETE FROM topping_detail WHERE pizza_id = $pizza_id";
            $connection->query($sql);

            $toppings = Topping::getAll();
            foreach ($toppings as $topping) {
                if (isset($_POST['topping-'.$topping->getId()]) && $_POST['topping-' . $topping->getId()]) {
                    $topping_id = $topping->getId();
                    $sql = "INSERT INTO topping_detail(pizza_id, topping_id) VALUES
                            ('$pizza_id', '$topping_id')";
                    $connection->query($sql);
                }
            }

            $sql = "DELETE FROM pizza_detail WHERE pizza_id = $pizza_id";
            $connection->query($sql);

            $sizes = Size::getAll();

            foreach($sizes as $size) {
                $sizeId = $size->getId();

                $bases = Base::getAll();
                foreach($bases as $base) {
                    $baseId = $base->getId();

                    if (isset($_POST["price-$sizeId-$baseId"]) && isset($_POST["amount-$sizeId-$baseId"])) {
                        $price = $_POST["price-$sizeId-$baseId"];
                        $amount = $_POST["amount-$sizeId-$baseId"];

                        $sql = "INSERT INTO pizza_detail(pizza_id, size_id, base_id, price, quantity) VALUES
                            ('$pizza_id', '$sizeId', '$baseId', '$price', '$amount')";
                        $connection->query($sql);
                    }
                }
            }

            // Trỏ về trang sản phẩm và thông báo tạo thành công
            echo "Sửa sản phẩm thành công";
            exit;
        }
        echo "Thiếu dữ kiện!";
    } else {
        echo "Lỗi tải file!";
    }
} else {
    echo "Không thể tải file!";
}
?>
