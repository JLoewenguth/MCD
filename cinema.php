<?php
try{
    $mySqlClient = new PDO('mysql:host=localhost;dbname=cinema_V2;charset=utf8','root','');
}
catch (Exception $e)
{
    die('Erreur : ' . $e->getMessage());
}

$cinemaStatement = $mySqlClient->prepare('SELECT id_film, titre,
annee_sortie_france AS annee, nom, prenom,
TIME_FORMAT(SEC_TO_TIME(duree_minutes*60), "%H:%i") as duree_heures
FROM film f
INNER JOIN realisateur r ON r.id_realisateur=f.id_realisateur
INNER JOIN personne p ON p.id_personne=r.id_personne');

$cinemaStatement->execute();
$cinema = $cinemaStatement->fetchAll();

?>
<table>
    <thread>
        <tr>
            <th>TITRE</th>
            <th>ANNEE SORTIE</th>
            <th>DUREE</th>
            <th>REAL</th>
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
