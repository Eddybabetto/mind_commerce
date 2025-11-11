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
      
        <th>id</th>
        <th>SKU</th>
        <th>Nome Prodotto</th>
        <th>Descrizione</th>
        <th>Giacenza</th>
        <th>Categoria</th>
        <th>Prezzo</th>
        <th>Immagine</th>
        <!-- <th>Immagine BASE64</th> -->
        <th>Azioni</th>
      </tr>
    </thead>
    <tbody>
      <?php

      $mysqli = open_db_connection();

      $results = $mysqli->query("
        SELECT p.id as id, p.SKU as SKU, p.name as name, p.description as description, p.stock as stock, p.categories as categories, p.price as price, i.filename as filename FROM products as p, images as i  WHERE p.deleted_at IS NULL and p.id = i.id_product;
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
          <td><img style='width: 100px' src="<?= getenvterm("DOMAIN") ?>uploads/images/<?= $prodotto["filename"]?>" /> </td>
          <!-- <td><img src="data:image/jpg;base64, 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" /> </td> -->
          <td>
            <a class="button-delete" href="delete.php?id=<?= $prodotto["id"] ?>&soft_delete=true"><button>Elimina Prodotto</button></a>
            <button class="button-edit">Modifica Prodotto</button>
            <button hidden class="button-reset">reset Prodotto</button>
            <button hidden class="button-save">salva Prodotto</button>
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
  let original_data = {}
  let bottoni_edit = document.getElementsByClassName("button-edit")
  Array.from(bottoni_edit).forEach(btn => {
    btn.addEventListener("click", (event) => {
      //event.target è il bottone edit in questa circostanza
      event.target.hidden = true //nascondo bottone edit 
      let button_delete = event.target.parentNode.querySelector(".button-delete")
      button_delete.hidden = true
      let button_reset = event.target.parentNode.querySelector(".button-reset")
      button_reset.hidden = false
      let button_save = event.target.parentNode.querySelector(".button-save")
      button_save.hidden = false
      let tr_ref = event.target.parentNode.parentNode
      let all_tds = Array.from(tr_ref.querySelectorAll("td"))

      original_data[all_tds[0].innerText] = {
        id: all_tds[0].innerText,
        sku: all_tds[1].innerText,
        nome_prodotto: all_tds[2].innerText,
        descrizione: all_tds[3].innerText,
        giacenza: all_tds[4].innerText,
        categoria: all_tds[5].innerText,
        prezzo: all_tds[6].innerText,
      }

      let inputsku = document.createElement("input")
      inputsku.value = structuredClone(original_data[all_tds[0].innerText].sku)
      inputsku.name = "sku"
      inputsku.id = "sku-product-" + all_tds[0].innerText
      inputsku.type = "text"
      all_tds[1].replaceChildren(inputsku)

      let input_nome_prodotto = document.createElement("input")
      input_nome_prodotto.value = structuredClone(original_data[all_tds[0].innerText].nome_prodotto)
      input_nome_prodotto.name = "nome_prodotto"
      input_nome_prodotto.id = "nome_prodotto-product-" + all_tds[0].innerText
      input_nome_prodotto.type = "text"
      all_tds[2].replaceChildren(input_nome_prodotto)

      let input_descrizione = document.createElement("input")
      input_descrizione.value = structuredClone(original_data[all_tds[0].innerText].descrizione)
      input_descrizione.name = "descrizione"
      input_descrizione.id = "descrizione-product-" + all_tds[0].innerText
      input_descrizione.type = "text"
      all_tds[3].replaceChildren(input_descrizione)

      let input_giacenza = document.createElement("input")
      input_giacenza.value = structuredClone(original_data[all_tds[0].innerText].giacenza)
      input_giacenza.name = "giacenza"
      input_giacenza.id = "giacenza-product-" + all_tds[0].innerText
      input_giacenza.type = "number"
      all_tds[4].replaceChildren(input_giacenza)

      let input_categoria = document.createElement("input")
      input_categoria.value = structuredClone(original_data[all_tds[0].innerText].categoria)
      input_categoria.name = "categoria"
      input_categoria.id = "categoria-product-" + all_tds[0].innerText
      input_categoria.type = "text"
      all_tds[5].replaceChildren(input_categoria)

      let input_prezzo = document.createElement("input")
      input_prezzo.value = structuredClone(original_data[all_tds[0].innerText].prezzo)
      input_prezzo.name = "prezzo"
      input_prezzo.id = "prezzo-product-" + all_tds[0].innerText
      input_prezzo.type = "number"
      input_prezzo.step = "0.01"
      all_tds[6].replaceChildren(input_prezzo)

    })


  })
  let bottoni_reset = document.getElementsByClassName("button-reset")
  Array.from(bottoni_reset).forEach(btn => {
    btn.addEventListener("click", (event) => {
      let tr_ref = event.target.parentNode.parentNode
      //event.target è il bottone reset in questa circostanza
      event.target.hidden = true //nascondo bottone reset 
      let button_delete = event.target.parentNode.querySelector(".button-delete")
      button_delete.hidden = false
      let button_edit = event.target.parentNode.querySelector(".button-edit")
      button_edit.hidden = false
      let button_save =  event.target.parentNode.querySelector(".button-save");
      button_save.hidden = true;
      let all_tds = Array.from(tr_ref.querySelectorAll("td"))
      all_tds[1].innerText = original_data[all_tds[0].innerText].sku
      all_tds[2].innerText = original_data[all_tds[0].innerText].nome_prodotto
      all_tds[3].innerText = original_data[all_tds[0].innerText].descrizione
      all_tds[4].innerText = original_data[all_tds[0].innerText].giacenza
      all_tds[5].innerText = original_data[all_tds[0].innerText].categoria
      all_tds[6].innerText = original_data[all_tds[0].innerText].prezzo
    });
  });


  let bottoni_save = document.getElementsByClassName("button-save")
  Array.from(bottoni_save).forEach(btn => {
    btn.addEventListener("click", (event) => {
      salvaModificheProdotti(event.target.parentNode.parentNode)
    })
  })

  async function salvaModificheProdotti(tr) {
    let form = new FormData()
    let td_id = Array.from(tr.querySelectorAll("td"))[0]
    let id_prodotto = td_id.innerText
    console.log(document)
    console.log(tr)

    let inputs = Array.from(tr.querySelectorAll("input[id$=-product-" + id_prodotto + "]"))

    console.log("input[id$=-product-10]") //id finisce con
    console.log("input[id^=product-10]") //id inizia con
    console.log("input[id*=product-10]") //id contiene stringa
    console.log("div[class~=centrato]") //id contiene stringa ma separata da spazi, matcha tipo class="rosso centrato fluttuante", non matcha class="rosso centrato-destra fluttuante"
 
-
    console.log(inputs)
    
    form.append("id_product", id_prodotto)
    inputs.forEach(input => {
      form.append(input.id.replace("-product-" + id_prodotto, ""), input.value)
      //prende sku-product-1, sostituisce a -product-1 il nulla (stringa vuota) e usa il risultato come chiave del campo formdata in questo caso solo "sku"

    });
    const response = await fetch("<?php echo getenvterm("DOMAIN") ?>admin/api/products/update.php", {
      method: "POST",
      body: form
    });

    risposta = await response.json()
    if (risposta) {
      // Aggiorno la tabella con i nuovi valori
      let all_tds = Array.from(tr.querySelectorAll("td"))
      all_tds[1].innerText = inputs[0].value;
      all_tds[2].innerText = inputs[1].value;
      all_tds[3].innerText = inputs[2].value;
      all_tds[4].innerText = inputs[3].value;
      all_tds[5].innerText = inputs[4].value;
      all_tds[6].innerText = inputs[5].value;
      let button_save = tr.querySelector(".button-save");
      button_save.hidden = true;
      let button_reset = tr.querySelector(".button-reset");
      button_reset.hidden = true;
      let button_delete = tr.querySelector(".button-delete");
      button_delete.hidden = false;
      let button_edit = tr.querySelector(".button-edit");
      button_edit.hidden = false;
    } else {
      alert('Il Prodotto non è stato aggiornato per qualche errore');
    }
  }
</script>

</html>