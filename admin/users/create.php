<?php
include("../admin_session.php");
include("../header.php");
require("../../db/session.php");
if (isset($_POST["submit"])) {
  //crea utente

  $utente = $_POST["email"];
  $password = $_POST["password"];
  $nome = $_POST["nome"];
  $cognome = $_POST["cognome"];
  $cf = $_POST["cf"];
  $telefono = $_POST["telefono"];
  $admin = $_POST["admin"] || 0;

  // select * da crud
  $mysqli = open_db_connection();

  $query_preparata = "SELECT * FROM users WHERE email= ? AND deleted_at IS NULL ; ";

  $results = $mysqli->execute_query($query_preparata, [$utente]);

  $risultati_utente_trovato_db = $results->fetch_all();

  if (count($risultati_utente_trovato_db) != 0) {

    echo "<script>alert(\"Utente già registrato\")</script>";
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
    ? )"
    );
    $query_preparata->bind_param("ssssssi", $utente, $hash_password, $nome, $cognome, $cf, $telefono, $admin);
    $result = $query_preparata->execute(); //ritorna true o false in base se la query è stata fatta o no

    echo "<script>alert(\"Utente registrato correttamente\")</script>";

    // pulisco variabili se registro utente
    unset($utente);
    unset($password);
    unset($nome);
    unset($cognome);
    unset($cf);
    unset($telefono);
    unset($admin);
  }

  close_db_connection($mysqli);
}
?>


<!DOCTYPE html>
<html lang="it">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Crea utente ADMIN</title>
  <style href="<?= getenvterm("DOMAIN") ?>css/index.css"></style>
</head>

<body>
  <?php
  include("../menu.php");
  ?>
  <form method="post" class="form-example" id="form">
    <div class="form-example">
      <label for="name">Nome: </label>
      <input type="text" name="nome" id="name" <?php echo isset($nome) ? "value='" . $nome . "'" : "" ?> required />
    </div>
    <div class="form-example">
      <label for="cognome">Cognome: </label>
      <input type="text" name="cognome" id="cognome" <?php echo isset($cognome) ? "value='" . $cognome . "'" : "" ?> required />
    </div>
    <div class="form-example">
      <label for="email">Email: </label>
      <input type="text" name="email" id="email" <?php echo isset($utente) ? "value='" . $utente . "'" : "" ?> required />
    </div>
    <div class="form-example">
      <label for="password">password: </label>
      <input type="password" name="password" <?php echo isset($password) ? "value='" . $password . "'" : "" ?> id="password" required />
    </div>
    <div class="form-example">
      <label for="cf">CF: </label>
      <input type="text" name="cf" id="cf" <?php echo isset($cf) ? "value='" . $cf . "'" : "" ?> maxlength="16" />
    </div>
    <div class="form-example">
      <label for="telefono">Tel: </label>
      <input type="text" name="telefono" id="telefono" <?php echo isset($telefono) ? "value='" . $telefono . "'" : "" ?> maxlength="14" />
    </div>
    <div class="form-example">
      <label for="admin">Amministratore? </label>
      <input type="checkbox" name="admin" id="admin" value="1" <?php echo $admin ? "checked" : "" ?> />
    </div>
    <div class="form-example">
      <input type="submit" name="submit" value="invia" />
    </div>

  </form>


</body>

</html>