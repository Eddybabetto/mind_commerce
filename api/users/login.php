<?php
require("../../db/session.php");
require("../../env/getenv.php");

$utente = $_POST["email"];
$password = $_POST["password"];
header("Content-Type: application/json");

$mysqli = open_db_connection();
$hash_password = hash('sha256', $password . getenvterm("SALT"));

$query_preparata = "SELECT * FROM users WHERE email=? AND pass=? AND deleted_at IS NULL ; ";

$results = $mysqli->execute_query($query_preparata, [$utente, $hash_password]);

$risultati_utente_trovato_db = $results->fetch_all(MYSQLI_ASSOC);

if (count($risultati_utente_trovato_db) != 0) {
   // login ok
   http_response_code(200);
   session_start();
   $_SESSION["utente"] = json_encode($risultati_utente_trovato_db[0]);
   $utente = $risultati_utente_trovato_db[0];
   if ($utente["administrator"] == 1) {
      echo json_encode(["redirect" =>  getenvterm("DOMAIN")."admin/index.php"]);
   } else {
      echo json_encode(["redirect" => getenvterm("DOMAIN")]);
   }

   die();
} else {
   http_response_code(400);
   echo json_encode(["login" => False]);
}

close_db_connection($mysqli);
die();
