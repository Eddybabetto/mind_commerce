<?php

$mysqli = new mysqli("127.0.0.1", "root", "", "mind_commerce", 3306);

$result = $mysqli->query("
UPDATE products_orders
SET qty='".$_POST["qty"]."',
    prezzo='".$_POST["prezzo"]."'
WHERE 
id_order='".$_POST["order_id"]."' 
AND id_products='".$_POST["id_product"]."'
");

$mysqli->close();
header("Content-Type: application/json");
if ($result == false) {
    echo json_encode(["read" => "error"]);
} else {
    echo $result;
}

die();
