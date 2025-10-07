<?php
require("../../db/session.php");

$utente = $_POST["email"];
$password = $_POST["password"];
$nome = $_POST["nome"];
$cognome = $_POST["cognome"];
$cf = $_POST["cf"];
$telefono = $_POST["telefono"];

// select * da crud

$mysqli = open_db_connection();

$results = $mysqli->query("
SELECT email FROM users;
");

// $results NON è direttamente leggibile, ma possiamo trasformarlo in un dato sensato 
//con fetch_all(MYSQLI_ASSOC) che trasforma il risultato sql in array associativo
$array_credenziali = $results->fetch_all(MYSQLI_ASSOC);
// [
//  0=>[
//      "email"=>"valore email"
//      ],
//  1=>[
//      "email"=>"valore email"
//      ],
// ...
//]

header("Content-Type: application/json");

for ($n = 0; $n < count($array_credenziali); $n++) {

  // $array_credenziali[$n] riga del db che andiamo a verificare

  if ($utente == $array_credenziali[$n]["email"]) {

    http_response_code(400);
    echo json_encode(["error" => "utente già registrato"]);
    die();
  }
}

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
close_db_connection($mysqli);
die();
