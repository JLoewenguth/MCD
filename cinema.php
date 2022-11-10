<?php
try{
    $mySqlClient = new PDO('mysql:host=localhost;dbname=cinema_V2;charset=utf8','root','');
}
catch (Exception $e)
{
    die('Erreur : ' . $e->getMessage());
}

// recherche des films
$cinemaStatement = $mySqlClient->prepare('SELECT id_film, titre,
    annee_sortie_france AS annee, nom, prenom,
    TIME_FORMAT(SEC_TO_TIME(duree_minutes*60), "%H:%i") as duree_heures
    FROM film f
    INNER JOIN realisateur r ON r.id_realisateur=f.id_realisateur
    INNER JOIN personne p ON p.id_personne=r.id_personne');

$cinemaStatement->execute();
$cinema = $cinemaStatement->fetchAll();

//recherche des réalisateurs
$realStatement = $mySqlClient->prepare('SELECT distinct r.id_realisateur, nom, prenom, sexe, date_naissance
    FROM realisateur r
    INNER JOIN personne p ON p.id_personne=r.id_personne
    INNER JOIN film f ON f.id_realisateur=r.id_realisateur');

$realStatement->execute();
$realisateur = $realStatement->fetchAll();

?>
<link rel="stylesheet" href="style.css">
<!-- tableau des films -->
<h1> liste des films</h1>
<table>
    <thread>
        <tr>
            <th>TITRE</th>
            <th>ANNEE SORTIE</th>
            <th>DUREE</th>
            <th>REALISATEUR</th>
        </tr>
    </thread>
    <tbody>
        <?php
        foreach($cinema as $cinema) { ?>
            <tr>
                <td><a href="detailFilm.php?id=<?= $cinema["id_film"] ?>"><?= $cinema["titre"] ?></a></td>
                <td><?= $cinema["annee"] ?></td>
                <td><?= $cinema["duree_heures"] ?></td>
                <td><?= $cinema["nom"]." ".$cinema["prenom"] ?></td>
            </tr>
    <?php    } ?>
    </tbody>
</table>
        </br>
<!-- tableau des réalisateurs -->
<h1> liste des réalisateurs </h1>
<table>
    <thread>
        <tr>
            <th>NOM</th>
            <th>SEXE</th>
            <th>NAISSANCE</th>
            <th>FILMOGRAPHIE</th>
        </tr>
    </thread>
    <tbody>
        <?php
        foreach($realisateur as $realisateur) { ?>
            <tr>
                <td><?= $realisateur["prenom"]." ".$realisateur["nom"] ?></td>
                <td><?= $realisateur["sexe"] ?></td>
                <td><?= $realisateur["date_naissance"] ?></td>
                <td><a href="realisateur.php?id=<?= $realisateur["id_realisateur"] ?>"><?= "liste" ?></td>
            </tr>
    <?php    } ?>
    </tbody>
</table>
