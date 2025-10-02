<?php

$mysqli = new mysqli("127.0.0.1", "root", "", "mind_commerce");

$result = $mysqli->query("
DELETE FROM products WHERE id='".$_POST["product_id"]."'
");


$mysqli->close();
header("Content-Type: application/json");
if ($result == false) {
    echo json_encode(["read" => "error"]);
} else {
    echo $result;
}

die();
