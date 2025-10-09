<?php
session_start();
if (!isset($_SESSION["utente"])) {
  echo "non loggato";
  die();
}

$utente = json_decode($_SESSION["utente"], true);
if ($utente["administrator"] == 0) {
  header("Location: http://localhost/mind_commerce/index.php");
  die();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <a href="users.php">Vedi tutti gli utenti registrati</a>
</body>

</html>