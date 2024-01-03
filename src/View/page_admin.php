<?php
require 'livre.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/admin.css">
    <title>Page admin</title>
</head>

<body>
    <header>
        <img class="logo" src="./assets/images/logo-book-your-medias.png" alt="logo">
    </header>

    <h1>
        <button action="" type="submit">Ajouter un média</button>
    </h1>

    <table class="table">
        <tr>
            <th>ID</th>
            <th>Titre</th>
            <th>Auteur</th>
            <th>Actions</th>
            <th>Disponibilité</th>
        </tr>

        <?php
        $livres = [
            $livre1 = ["id" => "003", "titre" => "La vie est un roman", "auteur" => "Guillaume Musso", "actions" => "Notifier son retour en médiathèque ", "Disponibilité" => "Disponible"],
            $livre2 = ["id" => "005", "titre" => "Rien ne t'efface", "auteur" => "Michel Bussi", "actions" => "Notifier son retour en médiathèque ", "Disponibilité" => "Non disponible"],
            $livre3 = ["id" => "125", "titre" => "Le tourbillon de la vie", "auteur" => "Aurélie Valognes", "actions" => "Notifier son retour en médiathèque ", "Disponibilité" => "Disponible"],
            $livre4 = ["id" => "391", "titre" => "Harry Potter et le prisonnier d'Azkaban", "auteur" => "J.K Rowling", "actions" => "Notifier son retour en médiathèque ", "Disponibilité" => "Disponible"],
            $livre5 = ["id" => "655", "titre" => "Dans les brumes de Capelans", "auteur" => "Olivier Norek", "actions" => "Notifier son retour en médiathèque ", "Disponibilité" => "Non disponible"],
            $livre6 = ["id" => "091", "titre" => "L'Étoile du désert", "auteur" => "Michael Connelly", "actions" => "Notifier son retour en médiathèque ", "Disponibilité" => "Disponible"],
        ];
        foreach ($livres as $livre) {
            echo
            '<tr>
            
            <th>' . $livre["id"] . '</th>
            <th>' . $livre["titre"] . '</th>
            <th>' . $livre["auteur"] . '</th>
            <th>' . $livre["actions"] . '<img class="corbeil" src="assets/images/img.png" alt="corbeil"></th>
            <th>' . $livre["Disponibilité"] . '</th>
            </tr>';
        }

        ?>


    </table>


</body>