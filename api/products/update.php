<?php

$mysqli = new mysqli("127.0.0.1", "root", "", "mind_commerce", 3306);

$result = $mysqli->query("
UPDATE products
SET  SKU='".$_POST["SKU"]."',
    nome='".$_POST["SKU"]."',
    descrizione='".$_POST["SKU"]."',
    giacenza='".$_POST["SKU"]."',
    categoria='".$_POST["SKU"]."',
    prezzo='".$_POST["SKU"]."'
WHERE id='".$_POST["product_id"]."'
");

$mysqli->close();
header("Content-Type: application/json");
if ($result == false) {
    echo json_encode(["read" => "error"]);
} else {
    echo $result;
}

die();
