<?php
include("../admin_session.php");
include("../header.php");
if (isset($_GET["error"])) {
  echo '<div class="alert alert-success" role="alert">'. urldecode($_GET["error"]) .'  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
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
        <th>Nome Cognome</th>
        <th>Email</th>
        <th>Indirizzi</th>
        <th>Azioni</th>
      </tr>
    </thead>
    <tbody>
      <?php

      $mysqli = open_db_connection();

      $results = $mysqli->query("
        SELECT 
          u.id as id_utente, 
          u.first_name as nome, 
          u.last_name as cognome, 
          u.email, 
          u.delete_at, 
          indirizzi.* 
        FROM users as u LEFT JOIN address as indirizzi 
          ON u.id=indirizzi.id_user 
        WHERE u.delete_at IS NULL;
        ");
      $array_utenti = $results->fetch_all(MYSQLI_ASSOC); // lunghezza 3

      // [
        // [id => ...
        // nome=> ...
        // cognome => ....
        // via=>...
        // ....
        //   ],
        // [id => ...
        // nome=> ...
        // cognome => ....
        // via=>...
        // ....
        // ]
      // ]


// [
      //"id_utente"=> [id => id utente,
          // nome=> nome utente
          // indirizzi => [
                // [id_indirizzo,
                // via,
                // comune], 
                // [id_indirizzo,
                // via,
                // comune]
          // ]
        // ]
// ]




      function funzione_che_ordina_gli_utenti($acc, $item)
      {

        $indirizzi_vecchi = $acc[$item["id_utente"]]["indirizzi"] ?? [];

        $array_indirizzo = [
          "id" => $item["id"],
          "via" => $item["via"],
          "numero_civico" => $item["numero_civico"],
          "città" => $item["città"],
          "provincia" => $item["provincia"],
          "cap" => $item["cap"],
          "regione" => $item["regione"],
          "paese" => $item["paese"]
        ];

        array_push($indirizzi_vecchi, $array_indirizzo);
        
        $acc[$item["id_utente"]] = [
          "id_utente" => $item["id_utente"],
          "nome" => $item["nome"],
          "cognome" => $item["cognome"],
          "email" => $item["email"],
          "indirizzi" => $indirizzi_vecchi
        ];

        return $acc;
      }

      $array_pulito = array_reduce($array_utenti, "funzione_che_ordina_gli_utenti", []);

      ?>

      <?php foreach ($array_pulito as $utente): ?>
        <tr>
          <td><?= $utente["id_utente"] ?></td>
          <td><?= $utente["nome"] ?>&nbsp;<?= $utente["cognome"] ?></td>
          <td><?= $utente["email"] ?></td>
          <td>
            <ul>
              <?php foreach ($utente["indirizzi"] as $indirizzo): ?>
                <li> <?= $indirizzo["via"] ?> <?= $indirizzo["città"] ?> <?= $indirizzo["cap"] ?></li>
              <?php endforeach; ?>
            </ul>
          </td>
          <td>
            <a href="delete.php?id=<?= $utente["id_utente"] ?>&soft_delete=true"><button>Elimina utente</button></a>
            <a href="update.php?id_user=<?= $utente["id_utente"] ?>"><button>Edita utente</button></a>
            <a href="address?id_user=<?= $utente["id_utente"] ?>"><button>Gestisci Indirizzi</button></a>
          </td>
        </tr>

      <?php endforeach;

      close_db_connection($mysqli);

      ?>
    </tbody>
  </table>
  <br />
  <div class="centrato">UTENTI ELIMINATI</div>
  <table id="tabella" class="centrato">
    <thead>

      <tr>
        <th>ID</th>
        <th>Nome Cognome</th>
        <th>Email</th>
        <th>Indirizzi</th>
        <th>Azioni</th>
      </tr>
    </thead>
    <tbody>
      <?php
      error_reporting(E_ALL);
      $mysqli = open_db_connection();

      $results = $mysqli->query("
        SELECT * FROM users WHERE delete_at IS NOT NULL;
        ");
      $array_utenti = $results->fetch_all(MYSQLI_ASSOC);

      for ($n = 0; $n < count($array_utenti); $n++) {

        echo "
          <tr>
            <td>" . $array_utenti[$n]["id"] . "</td>
            <td>" . $array_utenti[$n]["first_name"] . " " . $array_utenti[$n]["last_name"] . "</td>
            <td>" . $array_utenti[$n]["email"] . "</td>
            <td>
              <ul>";

        $results_indirizzi = $mysqli->query("
        SELECT * FROM address WHERE id_user='" . $array_utenti[$n]["id"] . "' ;
        ");
        $array_indirizzi = $results_indirizzi->fetch_all(MYSQLI_ASSOC);

        foreach ($array_indirizzi as $indirizzo_utente) {
          echo "<li>" . $indirizzo_utente["via"] . " " . $indirizzo_utente["città"] . " " . $indirizzo_utente["cap"] . "</li> ";
        }
        echo "
              </ul>
            </td>
            <td>
               <a href=\"undelete.php?id=" . $array_utenti[$n]["id"] . "\"><button>Ripristina utente</button></a>
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
    <a href="create.php"><button>Aggiungi utente</button></a>
  </div>

</body>
<script>



</script>

</html>