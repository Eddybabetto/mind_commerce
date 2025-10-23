<?php
include("../admin_session.php");
include("../header.php");
require("../../db/session.php");

$utente = "";
$password = "";
$nome = "";
$cognome = "";
$cf = "";
$telefono = "";
$admin = "";
$mysqli = open_db_connection();
if (isset($_POST["submit"])) {
  //update utente


  $utente = $_POST["email"];
  $password = $_POST["password"];
  $nome = $_POST["nome"];
  $cognome = $_POST["cognome"];
  $cf = $_POST["cf"];
  $telefono = $_POST["telefono"];
  $admin = $_POST["admin"] || 0;

  // select * da crud


  $query_preparata = "SELECT * FROM users WHERE email= ? AND deleted_at IS NULL AND id <> ?; ";

  $results = $mysqli->execute_query($query_preparata, [$utente, $_POST["id_user"]]);

  $risultati_utente_trovato_db = $results->fetch_all();

  if (count($risultati_utente_trovato_db) != 0) {

    echo "<script>alert(\"Un altro utente ha la stessa mail impostata, non posso aggiornarlo\")</script>";
  } else {

    $hash_password = hash('sha256', $password . getenvterm("SALT"));

    $query_preparata = $mysqli->prepare(
      $query_preparata = "UPDATE users
      SET email=?,
          pass=?,
          first_name=?,
          last_name=?,
          cf=?,
          tel=?,
          administrator=?
      WHERE id=? "
    );
    $query_preparata->bind_param("ssssssii", $utente, $hash_password, $nome, $cognome, $cf, $telefono, $admin, $_POST["id_user"]);
    $result = $query_preparata->execute(); //ritorna true o false in base se la query è stata fatta o no

    echo "<script>alert(\"Utente aggiornato correttamente\")</script>";
  }
} else {
  if (isset($_GET["id_user"])) {

    $query_preparata = "SELECT * FROM users WHERE deleted_at IS NULL AND id = ?; ";

    $results = $mysqli->execute_query($query_preparata, [$_GET["id_user"]]);

    $risultati_utente_trovato_db = $results->fetch_all(MYSQLI_ASSOC);

    $utente = $risultati_utente_trovato_db[0]["email"];
    $password = "";
    $nome = $risultati_utente_trovato_db[0]["first_name"];
    $cognome =  $risultati_utente_trovato_db[0]["last_name"];
    $cf =  $risultati_utente_trovato_db[0]["cf"];
    $telefono =  $risultati_utente_trovato_db[0]["tel"];
    $admin =  $risultati_utente_trovato_db[0]["administrator"];
  }
}

close_db_connection($mysqli);
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
    <input type="hidden" name="id_user" value="<?php echo $_REQUEST["id_user"] ?>">
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