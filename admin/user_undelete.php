<?php
session_start();
if (!isset($_SESSION["utente"])) {
    echo "non loggato";
    die();
}

$utente = json_decode($_SESSION["utente"], true);
if ($utente["administrator"] == 0) {
    header("Location: /index.php");
    die();
}

require("../db/session.php");
$id_utente = $_GET["id"];

$mysqli = open_db_connection();


    // soft delete

    try {
        $query_preparata = "UPDATE users SET delete_at=? WHERE id=? ";
        $delete_at = NULL;
        $results = $mysqli->execute_query($query_preparata, [$delete_at, $id_utente]);
    } catch (Exception $e) {
        header("Location: users.php?error=" . urlencode("utente non eliminato a causa di un errore"));
        die();
    }

    header("Location: users.php");
    die();



die();
