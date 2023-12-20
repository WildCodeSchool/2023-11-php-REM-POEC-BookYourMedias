<?php

require 'vendor/autoload.php';
if (file_exists('config/db.php')) {
    require 'config/db.php';
} else {
    require 'config/db.php.dist';
}

require 'config/config.php';

try {
    $pdo = new PDO(
        'mysql:host=' . DB_HOST . '; charset=utf8',
        DB_USER,
        DB_PASSWORD
    );

    $pdo->exec('DROP DATABASE IF EXISTS ' . DB_NAME);
    $pdo->exec('CREATE DATABASE ' . DB_NAME);
    $pdo->exec('USE ' . DB_NAME);
    $pdo->exec('CREATE TABLE user (id INT PRIMARY KEY AUTO_INCREMENT, 
    adresse_email VARCHAR(255) NOT NULL, 
    mot_de_passe VARCHAR(255), 
    pseudo VARCHAR(45)  NOT NULL, 
    role BOOLEAN NULL)');
    $pdo->exec('CREATE TABLE emprunt (id INT PRIMARY KEY AUTO_INCREMENT,
    date_emprunt DATE,
    date_retour DATE,
    FOREIGN KEY (id) REFERENCES user(id))');

    $pdo->exec('CREATE TABLE auteur(id INT PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR (150),
    last_name VARCHAR(150),
    FOREIGN KEY (id) REFERENCES medias(id))');
    $pdo->exec('CREATE TABLE medias (id INT PRIMARY KEY AUTO_INCREMENT,
    titre VARCHAR(150) NOT NULL,
    date DATE,
    description VARCHAR(5000) NOT NULL,
    image_couverture VARCHAR(5000) NOT NULL,
    lien_extrait VARCHAR(5000)NOT NULL,
    disponible BOOLEAN NULL,
    auteur_id INT NOT NULL,
    FOREIGN KEY (id) REFERENCES categorie(id),
    FOREIGN KEY (id) REFERENCES emprunt(id),
    FOREIGN KEY (id) REFERENCES user(id))');

    $pdo->exec('CREATE TABLE categorie (id INT PRIMARY KEY AUTO_INCREMENT,
    name_categorie VARCHAR(100),
    FOREIGN KEY (id) REFERENCES medias(id))');

    if (is_file(DB_DUMP_PATH) && is_readable(DB_DUMP_PATH)) {
        $sql = file_get_contents(DB_DUMP_PATH);
        $statement = $pdo->prepare($sql);
        $statement->execute();
    } else {
        echo DB_DUMP_PATH . ' file does not exist';
    }
} catch (PDOException $exception) {
    echo $exception->getMessage();
}
