<?php

$id = isset($_GET["id"]) ? $_GET["id"] : "";

$host = "mysql:host=127.0.0.1;port=3306";
$dbname = "cinema_V2";
$dbuser = "root";
$dbpass = "";

$pdo = new PDO(
    $host.';dbname='.$dbname,
    $dbuser,
    $dbpass,
    array(
        \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'",
        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
    )
);

$sql = "SELECT id_film, titre, annee_sortie_france FROM film where id_film = :id";
//:id  - on ne passe pas par query mais par prepare/execute
$cinemaStatement = $pdo->prepare($sql);
//execute associe le nom du champ param avec l'id de l'URL (ligne 3)
$cinemaStatement->execute(["id"->$id]);
$cinema = $cinemaStatement->fetchAll();
?>

<h1><?= $cinema["titre"]; ?></h1>
<p>Année de sortie : <?= $cinema["annee_sortie_france"] ?></p>