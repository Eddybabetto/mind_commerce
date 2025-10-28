<?php
include("../admin_session.php");
include("../header.php");
require("../../db/session.php");
if (isset($_POST["submit"])) {
  // crea prodotto


  $target_dir = "../../uploads/images/"; //delimito la cartella degli upload 
  $target_file = $target_dir . basename($_POST["filename"] ? $_POST["filename"] : $_POST["SKU"]); // decido che nome deve avere il file, in questo caso posso settare un override
  $continue = true; // variabile accessoria per i controlli
  $file_type = explode("/", strtolower($_FILES["file"]["type"]))[1]; //recupero il tipo di file, di solito il fo0rmato è [gruppo generico]/[estensione specifica]

  if (file_exists($target_file)) {
    echo "<script>alert(\"Il file esiste già\")</script>";

    die();
  }

  if (
    $file_type != "jpg" && $file_type != "png" && $file_type != "jpeg"
    && $file_type != "gif"
  ) {
    echo "<script>alert(\"Puoi caricare solo foto\")</script>";

    die();
  }


  if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file.".".$file_type)) { //muovo il file dalla richiesta al path (viene scritto un nuovo file e copiato il contenuto)
    echo "<script>alert(\"File caricato\")</script>";
  } else {
    //se dovesse fallire, ritorno un errore
    echo "<script>alert(\"Errore nel caricamento del file\")</script>";
  }

  $SKU = $_POST["SKU"];
  $name = $_POST["name"];
  $description = $_POST["description"];
  $stock = $_POST["stock"];
  $categories = $_POST["categories"];
  $price = $_POST["price"];

  $mysqli = open_db_connection();

  $query_preparata = $mysqli->prepare(
    "
INSERT INTO products(
    SKU,
    name,
    description,
    stock,
    categories,
    price
    ) 
VALUES (
    ?,
    ?,
    ?,
    ?,
    ?,
    ? )"
  );
  $query_preparata->bind_param("sssisd", $SKU, $name, $description, $stock, $categories, $price);
  $result = $query_preparata->execute(); //ritorna true o false in base se la query è stata fatta o no

  echo "<script>alert(\"Prodotto inserito correttamente\")</script>";

  // pulisco variabili se registro prodotto
  unset($SKU);
  unset($name);
  unset($description);
  unset($stock);
  unset($categories);
  unset($price);

  close_db_connection($mysqli);
}
?>


<!DOCTYPE html>
<html lang="it">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Crea Nuovo Prodotto</title>
  <style href="<?= getenvterm("DOMAIN") ?>css/index.css"></style>
</head>

<body>
  <?php
  include("../menu.php");
  ?>
  <form method="post" class="form-example" id="form" enctype="multipart/form-data">
    <div class="form-example">
      <label for="name">Nome: </label>
      <input type="text" name="name" id="name" <?php echo isset($name) ? "value='" . $nome . "'" : "" ?> required />
    </div>
    <div class="form-example">
      <label for="SKU">SKU: </label>
      <input type="text" name="SKU" id="SKU" <?php echo isset($SKU) ? "value='" . $SKU . "'" : "" ?> required />
    </div>
    <div class="form-example">
      <label for="description">Descrizione: </label>

      <textarea id="story" name="description" rows="5" cols="33" required>
 <?php echo isset($description) ?  $description : "" ?>
</textarea>


    </div>
    <div class="form-example">
      <label for="stock">Giacenza: </label>
      <input type="number" name="stock" <?php echo isset($stock) ? "value='" . $stock . "'" : "" ?> id="stock" required />
    </div>
    <div class="form-example">
      <label for="categories">Categoria: </label>
      <input type="text" name="categories" id="categories" <?php echo isset($categories) ? "value='" . $categories . "'" : "" ?> />
    </div>
    <div class="form-example">
      <label for="price">Prezzo: </label>
      <input type="number" name="price" id="price" step="0.01" <?php echo isset($price) ? "value='" . $price . "'" : "" ?> />
    </div>
    <input type="file" name="file" accept="image/png, image/jpeg">
    <div class="form-example">
      <input type="submit" name="submit" value="invia" />
    </div>

  </form>


</body>

</html>