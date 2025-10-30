<?php
include("../admin_session.php");
include("../header.php");
require("../../db/session.php");

if (isset($_POST["submit"])) {

  // crea prodotto

  function saveImage($file)
  {

    $target_dir = "../../uploads/images/"; //delimito la cartella degli upload 
    $target_file = $target_dir . basename($file["name"]); // $_FILES["file"]["name"] decido che nome deve avere il file, in questo caso posso settare un override
    $continue = true; // variabile accessoria per i controlli
    $file_type = explode("/", strtolower($file["type"]))[1]; //recupero il tipo di file, di solito il fo0rmato è [gruppo generico]/[estensione specifica]


    if (file_exists($target_file . "." . $file_type)) {
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

    if ($file['size'] > 3145728) { // maggiore di 3MB
      echo "<script>alert(\"File troppo grande\")</script>";

      die();
    }


    if (move_uploaded_file($file["tmp_name"], $target_file)) { //muovo il file dalla richiesta al path (viene scritto un nuovo file e copiato il contenuto)
      echo "<script>alert(\"File caricato\")</script>";
    } else {
      //se dovesse fallire, ritorno un errore
      echo "<script>alert(\"Errore nel caricamento del file\")</script>";
    }
  }

  $array_pulito = [];

  $lunghezza_prodotti = count($_POST["SKU"]);

  for ($i = 0; $i < $lunghezza_prodotti; $i++) {
    $array_pulito[$i] = [
      "SKU" => $_POST["SKU"][$i],
      "product" => $_POST["product"][$i],
      "description" => $_POST["description"][$i],
      "stock" => $_POST["stock"][$i],
      "categories" => $_POST["categories"][$i],
      "price" => $_POST["price"][$i],

    ];
  }
  for ($i = 0; $i < $lunghezza_prodotti; $i++) {

    $array_pulito[$i] = array_merge(
      $array_pulito[$i],
      [
        "file" => [
          "name" => $_FILES["file"]["name"][$i],
          "full_path" => $_FILES["file"]["full_path"][$i],
          "type" => $_FILES["file"]["type"][$i],
          "tmp_name" => $_FILES["file"]["tmp_name"][$i]
        ]
      ]
    );
  }



  $values_string = "";
  $bindings_type_string = "";
  $bindings_values_array = [];
  //$stmt->bind_param('ss', ...['DEU', 'POL']);




  foreach ($array_pulito as $index => $product) {
    $values_string .= "(
    ?,
    ?,
    ?,
    ?,
    ?,
    ? )";

    if ($index < (count($array_pulito) - 1)) {
      $values_string .= ",";
    }

    $bindings_type_string .= "sssisd";
    $bindings_values_array = array_merge($bindings_values_array, [$product["SKU"], $product["product"], $product["description"], $product["stock"], $product["categories"], $product["price"]]);

    echo var_dump($product);
    saveImage($product["file"]);
  }



  $SKU = $_POST["SKU"];
  $name = $_POST["product"];
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
VALUES " . $values_string
  );

  $query_preparata->bind_param($bindings_type_string, ...$bindings_values_array);

  try {
    $result = $query_preparata->execute(); //ritorna true o false in base se la query è stata fatta o no
  } catch (mysqli_sql_exception) {
    printf("Error - SQLSTATE %s.\n", $mysqli->sqlstate);
  }

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
    <div class="product-lines" id="product-line">
      <div class="form-example">
        <label for="name">Nome: </label>
        <input type="text" name="product[]" id="name" <?php echo isset($name) ? "value='" . $nome . "'" : "" ?> required />
      </div>
      <div class="form-example">
        <label for="SKU">SKU: </label>
        <input type="text" name="SKU[]" id="SKU" <?php echo isset($SKU) ? "value='" . $SKU . "'" : "" ?> required />
      </div>
      <div class="form-example">
        <label for="description">Descrizione: </label>
        <textarea id="story" name="description[]" rows="5" cols="33" required>
            <?php echo isset($description) ?  $description : "" ?>
        </textarea>
      </div>
      <div class="form-example">
        <label for="stock">Giacenza: </label>
        <input type="number" name="stock[]" <?php echo isset($stock) ? "value='" . $stock . "'" : "" ?> id="stock" required />
      </div>
      <div class="form-example">
        <label for="categories">Categoria: </label>
        <input type="text" name="categories[]" id="categories" <?php echo isset($categories) ? "value='" . $categories . "'" : "" ?> />
      </div>
      <div class="form-example">
        <label for="price">Prezzo: </label>
        <input type="number" name="price[]" id="price" step="0.01" <?php echo isset($price) ? "value='" . $price . "'" : "" ?> />
      </div>
      <input type="file" name="file[]" accept="image/png, image/jpeg">
    </div>
    <hr>

    <hr>
    <div class="form-example">
      <input type="submit" name="submit" value="invia" />
    </div>

  </form>


  <button id="duplica">Aggiungi prodotto</button>

</body>



<script>
  function clearForm(cloned_element) {
    let all_input = cloned_element.querySelectorAll("input")
    let all_input_array = Array.from(all_input)
    all_input_array.forEach(input => {
      input.value = ""
      input.innerText = ""
    })

  }

  let btnDuplica = document.getElementById('duplica'); // Pulsante per Disconnettersi in Alto a Destra 
  btnDuplica.addEventListener('click', (event) => {
      event.preventDefault();
      let prodottoDaCopiare = document.getElementById('product-line');
      console.log(prodottoDaCopiare);
      // let copiaProdotto = structuredClone(prodottoDaCopiare);
      let copiaProdotto = prodottoDaCopiare.cloneNode(true);
      clearForm(copiaProdotto)
      copiaProdotto.setAttribute('id', "");
      let contenitore = document.getElementById('form');
      document.quer
      contenitore.insertBefore(copiaProdotto, prodottoDaCopiare);
    }

  );
</script>


</html>