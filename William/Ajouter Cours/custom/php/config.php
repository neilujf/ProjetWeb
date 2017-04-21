<?php

$host = "localhost";
$db = "g1";
$login = "root";
$pass = "";

    try
    {
        $bdd = new PDO('mysql:host='.$host.';dbname='.$db.';charset=utf8', $login, $pass);
    }
    catch(Exception $e)
    {
        die('Erreur : '.$e->getMessage());
    }

?>