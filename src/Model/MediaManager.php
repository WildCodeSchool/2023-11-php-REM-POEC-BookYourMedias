<?php

namespace App\Model;

use DateTime;
use PDO;

class MediaManager extends AbstractManager
{
    public const TABLE = 'medias';

    /**
     * Insert new item in database
     */
    public function insert(array $medias): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " 
        (`titre`, `published_date`, `description_media`, `image_couverture`, `lien_extrait`, `disponible`) 
        VALUES (:titre, :published_date, :description_media, :image_couverture, :lien_extrait, :disponible)");
        $statement->bindValue(':titre', $medias['titre'], PDO::PARAM_STR);
        $statement->bindValue(':published_date', $medias['published_date'], PDO::PARAM_STR);
        $statement->bindValue(':description_media', $medias['description_media'], PDO::PARAM_STR);
        $statement->bindValue(':image_couverture', $medias['image_couverture'], PDO::PARAM_STR);
        $statement->bindValue(':lien_extrait', $medias['lien_extrait'], PDO::PARAM_STR);
        $statement->bindValue(':disponible', $medias['disponible'], PDO::PARAM_STR);
        $statement->execute();

        return (int)$this->pdo->lastInsertId();
    }

    /**
     * Uppublished_date item in database
     */
    public function update(array $medias): bool
    {
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " SET 
        `titre` = :titre, 
        `published_date` = :published_date, 
        `description_media` = :description_media, 
        `image_couverture` = :image_couverture, 
        `lien_extrait` = :lien_extrait, 
        `disponible` = :disponible 
        WHERE id=:id");

        $statement->bindValue(':id', $medias['id'], PDO::PARAM_INT);
        $statement->bindValue(':titre', $medias['titre'], PDO::PARAM_STR);
        $statement->bindValue(':published_date', $medias['published_date'], PDO::PARAM_STR);
        $statement->bindValue(':description_media', $medias['description_media'], PDO::PARAM_STR);
        $statement->bindValue(':image_couverture', $medias['image_couverture'], PDO::PARAM_STR);
        $statement->bindValue(':lien_extrait', $medias['lien_extrait'], PDO::PARAM_STR);
        $statement->bindValue(':disponible', $medias['disponible'], PDO::PARAM_STR);

        return $statement->execute();
    }

    public function book(int $id, int $user)
    {
        $statement = $this->pdo->prepare("INSERT INTO emprunt (date_emprunt, medias_id, user_id) 
        VALUES (:date_emprunt, :medias_id, :user_id)");
        $statement->bindValue(':medias_id', $id, PDO::PARAM_INT);
        $statement->bindValue(':user_id', $user, PDO::PARAM_INT);
        $today = new DateTime('now');
        $statement->bindValue(':date_emprunt', $today->format('Y-m-d'));

        $statement->execute();

        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " SET 
        `disponible` = :disponible
        WHERE id=:id");
        $statement->bindValue(':disponible', 0, PDO::PARAM_BOOL);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);

        return $statement->execute();
    }

    public function selectOneById(int $id): array|false
    {
        // prepared request
        $query = 'SELECT m.*, a.name FROM medias m INNER JOIN auteur a ON m.id_auteur=a.id WHERE m.id=:id';
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch();
    }
}
