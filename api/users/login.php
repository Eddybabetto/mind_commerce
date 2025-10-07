<?php

$utente = $_POST["email"];
$password = $_POST["password"];
header("Content-Type: application/json"); 

$mysqli = new mysqli("127.0.0.1", "root", "", "mind_commerce");

 $results = $mysqli->query(" SELECT * FROM users WHERE email='" . $utente . "' AND pass='".$password."' ; ");

$risultati_utente_trovato_db = $results->fetch_all(); 

  if (count($risultati_utente_trovato_db) != 0) {
     http_response_code(200); 
     session_start();
     $_SESSION["utente"]=json_encode($risultati_utente_trovato_db[0]);
     echo json_encode(["utente_presente" => "Ben Tornato!"]); 
    } else {
       http_response_code(400); 
       echo json_encode(["error" => "utente non esistente"]);
       
  } 
  
  $mysqli->close(); die();