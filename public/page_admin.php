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