<?php

$mysqli = new mysqli("127.0.0.1", "root", "", "mind_commerce", 3306);

$result = $mysqli->query("INSERT INTO 
products_orders(id_order, id_products, qty, prezzo) 
VALUES (" . $_POST['order'] . ", " . $_POST['product'] . ", '" . $_POST['qty'] . "', '" . $_POST['price'] . "'");

$mysqli->close();
header("Content-Type: application/json");
if ($result == false) {

    echo json_encode(["insert" => "error"]);
} else {
    echo json_encode(["insert" => "true"]);
}

die();
