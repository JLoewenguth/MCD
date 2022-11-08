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

$sql = "SELECT id_film, titre, annee_sortie_france FROM film WHERE id_film = :id";
//:id  - on ne passe pas par query mais par prepare/execute
$cinemaStatement = $pdo->prepare($sql);
//execute associe le nom du champ param avec l'id de l'URL (ligne 3)
$cinemaStatement->execute(["id"=>$id]);
$cinema = $cinemaStatement->fetch();
?>

<h1><?= $cinema["titre"]; ?></h1>
<p>Année de sortie : <?= $cinema["annee_sortie_france"] ?></p>

<?php
$sqlCasting = "SELECT concat(prenom,' ',nom) as acteur, nom_role
                FROM personne p
                inner join acteur a on p.id_personne = a.id_personne
                inner join jouer j on j.id_acteur = a.id_acteur
                inner join role r on j.id_role = r.id_role
                WHERE j.id_film = :id";

$castingStatement = $pdo->prepare($sqlCasting);
$casting = $castingStatement->fetch();
?>

<h3>Casting</h3>
<ul>
<?php
    foreach($casting as $casting){ ?>
        <li><?= $casting["acteur"] ?> (<?= $casting["nom_role"] ?>)</li>
<?php } ?>
</ul>