<?php

$mysqli = new mysqli("127.0.0.1", "root", "", "mind_commerce");

$result = $mysqli->query("
SELECT * FROM products;
");

$mysqli->close();
header("Content-Type: application/json");
if ($result == false) {
    echo json_encode(["read" => "error"]);
} else {
    echo json_encode($result->fetch_assoc());
}




//altri esempi 
/*

$rows = $result->fetch_all(MYSQLI_ASSOC);
foreach ($rows as $row) {
$row diventa il singolo record (riga)
    printf("%s (%s)\n", $row["Name"], $row["CountryCode"]);
}

simile, ma l'indice di $row è numerico
while ($row = $result->fetch_row()) {
    printf("%s (%s)\n", $row[0], $row[1]);
}

    */
die();
