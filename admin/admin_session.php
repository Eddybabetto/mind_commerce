<?php
error_reporting(0);
session_start();
// require dentro un file di cui viene fatto il require, come in questo caso dove admin_session viene richiesto dai file dentro la cartella users
// va a prendere il path dell'ultimo file chiamante (esempio /users/index.php), quindi la cartella attuale risulta essere quella di esempio /users/index.php
// per effettuare l'include in questo caso con il path di admin_session.php e non dei file che lo chiamano, usaimo la magic word __DIR__
// __DIR__ contiene il percorso del file attuale, non quello che lo include, e pertanto il path dentro admin_session.php fa riferimento a quello giusto
require(__DIR__ . "/../env/getenv.php");

if (!isset($_SESSION["utente"])) {
  echo "non loggato";
  die();
}

$utente_sessione = json_decode($_SESSION["utente"], true);
if ($utente_sessione["administrator"] == 0) {
  header("Location: " . getenvterm("DOMAIN"));
  die();
}
