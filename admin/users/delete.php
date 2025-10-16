<?php

include("../admin_session.php");

require("../../db/session.php");

$id_utente = $_GET["id"];
$soft_delete = $_GET["soft_delete"] || false; //questo sarà true o false e deciderà il tipo di delete


$mysqli = open_db_connection();

if ($soft_delete) {
    // soft delete

    try {
        $query_preparata = "UPDATE users SET delete_at=? WHERE id=? ";
        $now = date("Y-m-d H:i:s");
        $results = $mysqli->execute_query($query_preparata, [$now, $id_utente]);
    } catch (Exception $e) {
        header("Location: " . getenvterm("DOMAIN") . "admin/users?error=" . urlencode("utente non eliminato a causa di un errore"));
        die();
    }

    header("Location: " . getenvterm("DOMAIN")."admin/users");
    die();
} else {
    // hard delete classico
    try {
        $query_preparata = "DELETE FROM users WHERE id=? ";

        $results = $mysqli->execute_query($query_preparata, [$id_utente]);
    } catch (Exception $e) {
        header("Location: ". getenvterm("DOMAIN") . "admin/users?error=" . urlencode("utente non eliminato a causa di un errore"));
        die();
    }

    header("Location: " .getenvterm("DOMAIN") . "admin/users");
    die();
}


die();
