<?php

$mysqli = new mysqli("127.0.0.1", "root", "", "mind_commerce");

$result = $mysqli->query("
DELETE FROM carts WHERE 
    id_user='".$_POST["id_user"]."' 
    AND id_product='".$_POST["id_product"]."'
");


$mysqli->close();
header("Content-Type: application/json");
if ($result == false) {
    echo json_encode(["read" => "error"]);
} else {
    echo $result;
}

die();
