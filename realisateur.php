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

$sqlRealisateur = "SELECT titre, annee_sortie_france
                FROM film f
                inner join realisateur r on r.id_realisateur=f.id_realisateur
                inner join personne p on p.id_personne=r.id_personne
                WHERE r.id_personne = :id";

$realStatement = $pdo->prepare($sqlRealisateur);
$realStatement->execute(["id"=>$id]);
$realisateur = $realStatement->fetchAll();
?>

<h3>Filmographie</h3>
<ul>
<?php
    foreach($realisateur as $r){ ?>
        <li><?= $r["titre"] ?> (<?= $r["annee_sortie_france"] ?>)</li>
<?php } ?>
</ul>