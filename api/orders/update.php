<?php

$mysqli = new mysqli("127.0.0.1", "root", "", "mind_commerce", 3306);

$result = $mysqli->query("
UPDATE ordini
SET id_utente='".$_POST["user_id"]."',
    id_indirizzo='".$_POST["address_id"]."',
    totale_ivato='".$_POST["tot"]."',
    note_ordine='".$_POST["note"]."',
WHERE id='".$_POST["order_id"]."'
");

$mysqli->close();
header("Content-Type: application/json");
if ($result == false) {
    echo json_encode(["read" => "error"]);
} else {
    echo $result;
}

die();
