<?php

namespace App\Model;

use PDO;

class AdminManager extends AbstractManager
{
    public function getAll(): array|bool
    {
        $statement = $this->pdo->query('SELECT m.id, m.titre, m.published_date, 
        m.id_auteur, m.disponible, a.name, c.name_categorie 
        FROM medias m LEFT JOIN auteur a ON m.id_auteur = a.id LEFT JOIN categorie c ON m.id_categorie = c.id');
        $medias = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $medias;
    }

    public function getById(int $id): array|bool
    {
        $query = 'SELECT titre, description, id FROM medias WHERE id=:id';
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':id', $id, \PDO::PARAM_INT);
        $statement->execute();

        $medias = $statement->fetch(\PDO::FETCH_ASSOC);

        return $medias;
    }

    public function getLastMediaAdded(): array|bool
    {
        $statement = $this->pdo->query('select * from medias ORDER BY id DESC LIMIT 1;');
        $lastMedia = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $lastMedia;
    }

    public function save(array $medias): void
    {
        $query = 'INSERT INTO medias(titre, description) VALUES (:titre, :description)';
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':titre', $medias['titre'], \PDO::PARAM_STR);
        $statement->bindValue(':description', $medias['description'], \PDO::PARAM_STR);
        $statement->execute();
    }

    public function delete(int $id): void
    {
        $query = 'DELETE FROM emprunt WHERE medias_id=:id';
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':id', $id, \PDO::PARAM_INT);
        $statement->execute();

        $query = 'DELETE FROM medias WHERE id=:id';
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }

    public function isBack(int $id): void
    {
        $query = 'UPDATE medias SET disponible=1 WHERE id=:id';
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }

    public function update(array $medias, $id): void
    {
        $query = 'UPDATE medias SET titre=:titre, description=:description WHERE id=:id';
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':titre', $medias['titre'], \PDO::PARAM_STR);
        $statement->bindValue(':description', $medias['description'], \PDO::PARAM_STR);
        $statement->bindValue(':id', $id, \PDO::PARAM_STR);
        $statement->execute();
    }

    public const TABLE = 'medias';

    public function insert(array $medias): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . "(titre, published_date, description_media,
        image_couverture, lien_extrait, id_auteur, id_categorie) 
        VALUES (:titre, :published_date, :description_media, :image_couverture, 
        :lien_extrait, :id_auteur, :id_categorie)");
        $statement->bindValue(':titre', $medias['titre'], PDO::PARAM_STR);
        $statement->bindValue(':published_date', $medias['published_date'], PDO::PARAM_STR);
        $statement->bindValue(':description_media', $medias['description_media'], PDO::PARAM_STR);
        $statement->bindValue(':image_couverture', $medias['image_couverture'], PDO::PARAM_STR);
        $statement->bindValue(':lien_extrait', $medias['lien_extrait'], PDO::PARAM_STR);
        $statement->bindValue(':id_auteur', $medias['id_auteur'], PDO::PARAM_STR);
        $statement->bindValue(':id_categorie', $medias['id_categorie'], PDO::PARAM_STR);
        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }
}
