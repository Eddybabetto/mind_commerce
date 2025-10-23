<?php
include("../admin_session.php");
require("../../db/session.php");
$id_utente = $_GET["id"];

$mysqli = open_db_connection();


    // soft delete

    try {
        $query_preparata = "UPDATE users SET deleted_at=? WHERE id=? ";
        $delete_at = NULL;
        $results = $mysqli->execute_query($query_preparata, [$delete_at, $id_utente]);
    } catch (Exception $e) {
        header("Location: " . getenvterm("DOMAIN")."?error=" . urlencode("utente non eliminato a causa di un errore"));
        die();
    }

        header("Location: " . getenvterm("DOMAIN")."admin/users");
    die();



die();
