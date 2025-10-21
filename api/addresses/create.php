<?php

$mysqli = new mysqli("127.0.0.1", "root", "", "mind_commerce", 3306);

$result = $mysqli->query("
INSERT INTO 
`address`(
    via, 
    numero_civico, 
    citta, 
    provincia, 
    cap, 
    regione, 
    paese, 
    id_user
    ) 
VALUES (
    '" . $_POST['via'] . "',
    '" . $_POST['civico'] . "',
    '" . $_POST['citta'] . "',
    '" . $_POST['provincia'] . "',
    '" . $_POST['cap'] . "',
    '" . $_POST['regione'] . "',
    '" . $_POST['paese'] . "',
    '" . $_POST['id_utente'] . "'
    )"
);


$mysqli->close();
header("Content-Type: application/json");
if ($result == false) {

    echo json_encode(["insert" => "error"]);
} else {
    echo json_encode(["insert" => "true"]);
}

die();
