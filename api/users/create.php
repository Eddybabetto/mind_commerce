<?php

$mysqli = new mysqli("127.0.0.1", "root", "", "mind_commerce", 3306);
// $mysqli = new mysqli("127.0.0.1", "user", "password", "database"); 127.0.0.1 rappresenta il mio pc, "localhost"


// "" []
// '' ()


// [insert into .... values (].$_post.[)]
$result = $mysqli->query("
INSERT INTO 
users(
    email,
    pass,
    first_name,
    last_name,
    cf,
    tel,
    administrator
    ) 
VALUES (
    '" . $_POST['email'] . "',
    '" . $_POST['password'] . "',
    '" . $_POST['nome'] . "',
    '" . $_POST['cognome'] . "',
    '" . $_POST['cf'] . "',
    '" . $_POST['telefono'] . "',
     0 )"
);



//INSERT INTO users(email, pass) VALUES ('eddy.babetto@gmail.com', 'password')

$mysqli->close();
header("Content-Type: application/json");
if ($result == false) {

    echo json_encode(["insert" => "error"]);
} else {
    echo json_encode(["insert" => "true"]);
}

die();
