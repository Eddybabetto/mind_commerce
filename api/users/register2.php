<?php
require("../../db/session.php");
require("../../env/getenv.php");

$utente = $_POST["email"];
$password = $_POST["password"];
$nome = $_POST["nome"];
$cognome = $_POST["cognome"];
$cf = $_POST["cf"];
$telefono = $_POST["telefono"];

// select * da crud
$mysqli = open_db_connection();

$query_preparata = "SELECT * FROM users WHERE email= ? AND delete_at IS NULL ; ";

$results = $mysqli->execute_query($query_preparata, [$utente]);

$risultati_utente_trovato_db = $results->fetch_all();

header("Content-Type: application/json");

if (count($risultati_utente_trovato_db) != 0) {
  http_response_code(400);
  echo json_encode(["error" => "utente già registrato"]);

} else {

  $hash_password = hash('sha256', $password . getenvterm("SALT"));

  $query_preparata = $mysqli->prepare(
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
    ?,
    ?,
    ?,
    ?,
    ?,
    ?,
    0 )"
  );
  $query_preparata->bind_param("ssssss", $utente, $hash_password, $nome, $cognome, $cf, $telefono);
  $result = $query_preparata->execute(); //ritorna true o false in base se la query è stata fatta o no
  http_response_code(200);
  echo json_encode(["utente_inserito" => json_encode($result)]);

  // end select * da crud
}

close_db_connection($mysqli);

die();
