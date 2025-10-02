<?php

$mysqli = new mysqli("127.0.0.1", "root", "", "mind_commerce");

$result = $mysqli->query("
DELETE FROM products_orders WHERE 
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
