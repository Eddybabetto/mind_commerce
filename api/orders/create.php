<?php

$mysqli = new mysqli("127.0.0.1", "root", "", "mind_commerce", 3306);

$result = $mysqli->query("INSERT INTO 
ordini(id_utente, id_indirizzo, totale_ivato, note_ordine) 
VALUES (" . $_POST['id_user'] . ", " . $_POST['id_address'] . ", '" . $_POST['tot'] . "', '" . $_POST['note'] . "'");

$mysqli->close();
header("Content-Type: application/json");
if ($result == false) {

    echo json_encode(["insert" => "error"]);
} else {
    echo json_encode(["insert" => "true"]);
}

die();
