<?php
session_start();

if (!isset($_SESSION["utente"])) {
    http_response_code(401);

  die();
}

$utente_sessione = json_decode($_SESSION["utente"], true);
if ($utente_sessione["administrator"] !=1 && $utente_sessione["id"] != $_GET["id_user"]) {
  http_response_code(401);
  die();
}
require("../../db/session.php");

$mysqli = open_db_connection();

$query_preparata = " SELECT * FROM addresses WHERE user_id=? LIMIT 2 OFFSET ?";

$results = $mysqli->execute_query($query_preparata, [$_GET["id_user"], $_GET["page"]*2]);

$risultati_indirizzi = $results->fetch_all(MYSQLI_ASSOC);


$query_preparata_tot = " SELECT COUNT(*) as tot FROM addresses WHERE user_id=? ";

$results_tot = $mysqli->execute_query($query_preparata_tot, [$_GET["id_user"]]);

$risultati_tot= $results_tot->fetch_all(MYSQLI_ASSOC);


header("Content-Type: application/json;");
echo json_encode(["indirizzi"=>$risultati_indirizzi, "tot"=>$risultati_tot[0]["tot"] , "nrows"=>2]);


die();
?>