<?php

$utente=$_POST["email"];
$password=$_POST["password"];

$stringa_dati_file = file_get_contents("./credenziali.json");

$array_credenziali = json_decode($stringa_dati_file, true);

header("Content-Type: application/json");
$trovato=false;

for($n = 0; $n<count($array_credenziali) && $trovato==false; $n++){

  if ($utente == $array_credenziali[$n]["user"] &&  $password == $array_credenziali[$n]["password"]){
   
  $trovato=true;
  break;
  }

}

echo json_encode(["logged" => $trovato]);
die();


?>