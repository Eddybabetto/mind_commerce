<?php

$utente = $_POST["email"];
$password = $_POST["password"];
$nome = $_POST["nome"];
$cognome = $_POST["cognome"];
$cf = $_POST["cf"];
$telefono = $_POST["telefono"];

// select * da crud

$mysqli = new mysqli("127.0.0.1", "root", "", "mind_commerce");

$results = $mysqli->query("
SELECT email FROM users WHERE email='" . $utente . "';
");

$risultati_utente_trovato_db = $results->fetch_all();

header("Content-Type: application/json");

if (count($risultati_utente_trovato_db) != 0) {
  http_response_code(400);
  echo json_encode(["error" => "utente già registrato"]);

} else {
  $result = $mysqli->query(
    "
INSERT INTO users(
    email,
    pass,
    first_name,
    last_name,
    cf,
    tel,
    administrator
    ) 
VALUES (
    '" . $utente . "',
    '" . $password . "',
    '" . $nome . "',
    '" . $cognome . "',
    '" . $cf . "',
    '" . $telefono . "',
     0 )"
  );

  http_response_code(200);
  echo json_encode(["utente_inserito" => json_encode($result)]);

  // end select * da crud
}


$mysqli->close();
die();
