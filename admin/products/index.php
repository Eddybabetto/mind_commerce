<?php
include("../admin_session.php");
include("../header.php");
if (isset($_GET["error"])) {
  echo '<div class="alert alert-success" role="alert">' . urldecode($_GET["error"]) . '  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button></div>';
}

require("../../db/session.php");
?>

<!DOCTYPE html>
<html lang="en">

<body>

  <?php
  include("../menu.php");
  ?>
  <table id="tabella" class="centrato">
    <thead>
      <tr>
        <th>ID</th>
        <th>SKU</th>
        <th>Nome Prodotto</th>
        <th>Descrizione</th>
        <th>Giacenza</th>
        <th>Categoria</th>
        <th>Prezzo</th>
        <th>Immagine</th>
        <th>Azioni</th>
      </tr>
    </thead>
    <tbody>
      <?php

      $mysqli = open_db_connection();

      $results = $mysqli->query("
        SELECT * FROM products WHERE deleted_at IS NULL;
        ");
      $array_prodotti = $results->fetch_all(MYSQLI_ASSOC); // lunghezza 3

      ?>

      <?php foreach ($array_prodotti as $prodotto): ?>
        <tr>
          <td><?= $prodotto["id"] ?></td>
          <td><?= $prodotto["SKU"] ?></td>
          <td><?= $prodotto["name"] ?></td>
          <td><?= $prodotto["description"] ?></td>
          <td><?= $prodotto["stock"] ?></td>
          <td><?= $prodotto["categories"] ?></td>
          <td><?= $prodotto["price"] ?></td>
          <td><img src="<?= getenvterm("DOMAIN") ?>uploads/images/<?= $prodotto["SKU"] ?>.png" /> </td>
          <td>
            <a href="delete.php?id=<?= $prodotto["id"] ?>&soft_delete=true"><button>Elimina Prodotto</button></a>
            <a href="update.php?id_user=<?= $prodotto["id"] ?>"><button>Modifica Prodotto</button></a>
          </td>
        </tr>

      <?php endforeach;

      close_db_connection($mysqli);

      ?>
    </tbody>
  </table>
  <br />
  <div class="centrato">PRODOTTI ELIMINATI</div>
  <table id="tabella" class="centrato">
    <thead>

      <tr>
        <th>ID</th>
        <th>SKU</th>
        <th>Nome Prodotto</th>
        <th>Azioni</th>
      </tr>
    </thead>
    <tbody>
      <?php
      error_reporting(E_ALL);
      $mysqli = open_db_connection();

      $results = $mysqli->query("
        SELECT * FROM products WHERE deleted_at IS NOT NULL;
        ");
      $array_prodotti = $results->fetch_all(MYSQLI_ASSOC);

      for ($n = 0; $n < count($array_prodotti); $n++) {

        echo "
          <tr>
            <td>" . $array_prodotti[$n]["id"] . "</td>
            <td>" . $array_prodotti[$n]["SKU"] . "</td>
            <td>" . $array_prodotti[$n]["name"] . "</td>
            <td>
               <a href=\"undelete.php?id=" . $array_prodotti[$n]["id"] . "\"><button>Ripristina Prodotto</button></a>
            </td>
          </tr>
        ";
      }

      close_db_connection($mysqli);

      ?>
    </tbody>
  </table>
  <br>
  <div class="centrato">
    <a href="create.php"><button>Aggiungi Prodotto</button></a>
  </div>

</body>
<script>



</script>

</html>