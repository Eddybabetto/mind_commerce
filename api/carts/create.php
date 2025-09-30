<?php

$mysqli = new mysqli("127.0.0.1", "root", "", "mind_commerce", 3306);

$result = $mysqli->query("INSERT INTO 
carts(id_user, id_product, qty) 
VALUES (" . $_POST['id_user'] . ", " . $_POST['id_product'] . ", " . $_POST['qty'] . "");

$mysqli->close();
header("Content-Type: application/json");
if ($result == false) {

    echo json_encode(["insert" => "error"]);
} else {
    echo json_encode(["insert" => "true"]);
}

die();
