<?php
require 'livre.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin.css">
    <title>Page admin</title>
</head>

<body>
    <header>
        <img class="logo" src="logo-book-your-medias.png" alt="logo">
    </header>

    <h1>Ajouter un média</h1>

    <table class="table">
        <?php


        foreach ($livres as $livre) {
        
            echo '<tr>
            
            <th>' . $livre["id"] . '</th>
            <th>' . $livre["titre"] . '</th>
            <th>' . $livre["auteur"] . '</th>
            <th>' . $livre["actions"] . '<img class="corbeil" src="img.png" alt="corbeil"></th>
            
            <th>' . $livre["Disponibilité"] . '</th>
            
            
        </tr>';
        }

        ?>


    </table>


</body>