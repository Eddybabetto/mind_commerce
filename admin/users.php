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

require("../db/session.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pagina lista utenti</title>
  <style>
    table {
      border-collapse: collapse;
      border: 2px solid rgb(140 140 140);
      font-family: sans-serif;
      font-size: 0.8rem;
      letter-spacing: 1px;
    }

    thead,
    tfoot {
      background-color: rgb(228 240 245);
    }

    th,
    td {
      border: 1px solid rgb(160 160 160);
      padding: 8px 10px;
      text-align: center;
    }

    tbody>tr:nth-of-type(even) {
      background-color: rgb(237 238 242);
    }

    tfoot th {
      text-align: right;
    }

    tfoot td {
      font-weight: bold;
    }

    .centrato {
      margin: auto;
      justify-self: anchor-center;
      text-align: center;
    }
  </style>

</head>

<body>

  <?php
  include("menu.php");
  ?>

  <table id="tabella" class="centrato">
    <thead>
      <tr>
        <th>ID</th>
        <th>Nome Cognome</th>
        <th>Email</th>
        <th>Azioni</th>
      </tr>
    </thead>
    <tbody>
      <?php

      $mysqli = open_db_connection();

      $results = $mysqli->query("
        SELECT * FROM users ;
        ");
      $array_utenti = $results->fetch_all(MYSQLI_ASSOC);

      for ($n = 0; $n < count($array_utenti); $n++) {

        echo "
          <tr>
            <td>" . $array_utenti[$n]["id"] . "</td>
            <td>" . $array_utenti[$n]["first_name"] . " " . $array_utenti[$n]["last_name"] . "</td>
            <td>" . $array_utenti[$n]["email"] . "</td>
            <td>
              <div class='btn-edit' id-utente='" . $array_utenti[$n]["id"] . "'>edit</div> 
              <a href='/users/edit.php?id=" . $array_utenti[$n]["id"] . "'>edit con a</a>
            </td>
          </tr>
        ";
      }

      close_db_connection($mysqli);

      ?>
    </tbody>
  </table>

</body>
<script>



</script>

</html>