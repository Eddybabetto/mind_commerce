<?php
include("../../admin_session.php");
require("../../../db/session.php");

// error_reporting(E_ALL);
$mysqli = open_db_connection();

$id = $_POST["id_product"];
$SKU = $_POST["sku"];
$name = $_POST["nome_prodotto"];
$description = $_POST["descrizione"];
$stock = $_POST["giacenza"];
$categories = $_POST["categoria"];
$price = $_POST["prezzo"] ?? 0; 

$updated_at = date("Y-m-d H:i:s", time());

$query_preparata = $mysqli->prepare(
    $query_preparata = "UPDATE products 
      SET SKU=?,
          name=?,
          description=?,
          stock=?,
          categories=?,
          price=?,
          updated_at=?
      WHERE id=? AND deleted_at IS NULL"
);
$query_preparata->bind_param("sssisdsi", $SKU, $name, $description, $stock, $categories, $price, $updated_at, $id);
$result = $query_preparata->execute(); //ritorna true o false in base se la query è stata fatta o no
close_db_connection($mysqli);
header('Content-Type: application/json');

if ($result == true) {
    echo json_encode($result);
    die();
} else {
    echo json_encode($result);
}
