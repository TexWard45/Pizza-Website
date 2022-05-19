<?php
    $databaseHost = "localhost";
    $databaseUsername = "root";
    $databasePass = "";
    $databaseName = "pizza";

    // Tạo kết nối CSDL
    if (!($connection = new mysqli($databaseHost, $databaseUsername, $databasePass)))
        die ("Không thể kết nối đến ".$databaseHost);

    if (!$connection->select_db($databaseName))
        echo "Không thể kết nối CSDL";

    // Thiết lập font Unicode
    if (!($connection->query("set names 'utf8'")))
        echo "Không thể thiết lập utf8";
?>