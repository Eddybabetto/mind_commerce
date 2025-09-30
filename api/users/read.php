<?php

$mysqli = new mysqli("127.0.0.1", "root", "", "mind_commerce", 3306);

$result = $mysqli->query("
SELECT * FROM users;
");


$mysqli->close();
header("Content-Type: application/json");
if ($result == false) {

    echo json_encode(["read" => "error"]);
} else {
    echo json_encode($result->fetch_all(MYSQLI_ASSOC));
}

die();
