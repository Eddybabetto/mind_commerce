<?php

$mysqli = new mysqli("127.0.0.1", "root", "", "mind_commerce", 3306);

$result = $mysqli->query("
UPDATE carts
SET qty='".$_POST["qty"]."'
WHERE 
    id_user='".$_POST["id_user"]."' 
    AND id_product='".$_POST["id_product"]."'
");

//il where di un'istruzione UPDATE in sql DOVREBBE sempre 
//fare riferimento alle chiavi primarie della tabella (singole, come id, o composte come in questo caso)


$mysqli->close();
header("Content-Type: application/json");
if ($result == false) {
    echo json_encode(["read" => "error"]);
} else {
    echo $result;
}

die();
