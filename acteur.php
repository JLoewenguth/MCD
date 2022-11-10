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

//recherche de la filmographie
$sqlActeur = "SELECT titre, annee_sortie_france, nom_role
            FROM film f
            INNER JOIN jouer j ON j.id_film=f.id_film
            INNER JOIN role r ON r.id_role = j.id_role
            WHERE j.id_acteur = :id";

$acteurStatement = $pdo->prepare($sqlActeur);
$acteurStatement->execute(["id"=>$id]);
$acteur = $acteurStatement->fetchAll();
?>


<!-- tableau des films d'un acteur -->
<h3>Films et rôles</h3>
<ul>
<?php
    foreach($acteur as $a){ ?>
        <li><?= $a["titre"] ?> (<?= $a["annee_sortie_france"] ?>) : <?= $a["nom_role"] ?></li>
<?php } ?>
</ul>

<a href="cinema.php"?><?= "retour" ?>