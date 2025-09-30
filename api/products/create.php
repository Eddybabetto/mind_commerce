<?php

$mysqli = new mysqli("127.0.0.1", "root", "", "mind_commerce", 3306);

$result = $mysqli->query("INSERT INTO 
products(SKU, nome, descrizione, giacenza, categoria, prezzo) 
VALUES ('" . $_POST['sku'] . "', '" . $_POST['name'] . "', '" . $_POST['description'] . "', " . $_POST['giacenza'] . ", '" . $_POST['category'] . "'");

$mysqli->close();
header("Content-Type: application/json");
if ($result == false) {

    echo json_encode(["insert" => "error"]);
} else {
    echo json_encode(["insert" => "true"]);
}

die();
