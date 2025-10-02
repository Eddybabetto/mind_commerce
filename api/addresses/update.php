<?php

$mysqli = new mysqli("127.0.0.1", "root", "", "mind_commerce", 3306);

$result = $mysqli->query("
UPDATE `address`
SET via='".$_POST["via"]."',
    numero_civico='".$_POST["via"]."',
    città='".$_POST["via"]."',
    provincia='".$_POST["via"]."',
    cap='".$_POST["via"]."',
    regione='".$_POST["via"]."',
    paese='".$_POST["via"]."',
    id_user='".$_POST["via"]."',
WHERE id='".$_POST["address_id"]."'
");

$mysqli->close();
header("Content-Type: application/json");
if ($result == false) {
    echo json_encode(["read" => "error"]);
} else {
    echo $result;
}

die();
