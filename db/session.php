<?php

function open_db_connection()
{
    $mysqli = new mysqli("127.0.0.1", "root", "", "mind_commerce");
    return $mysqli;
}

function close_db_connection($mysqli)
{
    $mysqli->close();
}
