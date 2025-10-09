<?php
require("../../db/session.php");
require("../../env/getenv.php");

$utente = $_POST["email"];
$password = $_POST["password"];
header("Content-Type: application/json");

$mysqli = open_db_connection();
$hash_password = hash('sha256', $password . getenvterm("SALT"));

$query_preparata = "SELECT * FROM users WHERE email=? AND pass=? ; ";

$results = $mysqli->execute_query($query_preparata, [$utente, $hash_password]);

$risultati_utente_trovato_db = $results->fetch_all();

if (count($risultati_utente_trovato_db) != 0) {
   http_response_code(200);
   session_start();
   $_SESSION["utente"] = json_encode($risultati_utente_trovato_db[0]);
   echo json_encode(["login" => True]);
} else {
   http_response_code(400);
   echo json_encode(["login" => False]);
}

close_db_connection($mysqli);
die();
