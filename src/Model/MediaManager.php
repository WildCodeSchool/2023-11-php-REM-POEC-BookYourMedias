<?php

namespace App\Model;

use PDO;

class MediaManager extends AbstractManager
{
    public const TABLE = 'medias';

    /**
     * Insert new item in database
     */
    public function insert(array $medias): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (`title`, `date`, `description`, `cover_image`, `extract_link`, `isAvailable`) VALUES (:title, :date, :description, :cover_image, :extract_link, :isAvailable)");
        $statement->bindValue(':title', $medias['title'], PDO::PARAM_STR);
        $statement->bindValue(':date', $medias['date'], PDO::PARAM_STR);
        $statement->bindValue(':description', $medias['description'], PDO::PARAM_STR);
        $statement->bindValue(':cover_image', $medias['cover_image'], PDO::PARAM_STR);
        $statement->bindValue(':extract_link', $medias['extract_link'], PDO::PARAM_STR);
        $statement->bindValue(':isAvailable', $medias['isAvailable'], PDO::PARAM_STR);
        $statement->execute();

        return (int)$this->pdo->lastInsertId();
    }

    /**
     * Update item in database
     */
    public function update(array $medias): bool
    {
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " SET 
        `title` = :title, 
        `date` = :date, 
        `description` = :description, 
        `cover_image` = :cover_image, 
        `extract_link` = :extract_link, 
        `isAvailable` = :isAvailable 
        WHERE id=:id");

        $statement->bindValue(':id', $medias['id'], PDO::PARAM_INT);
        $statement->bindValue(':title', $medias['title'], PDO::PARAM_STR);
        $statement->bindValue(':date', $medias['date'], PDO::PARAM_STR);
        $statement->bindValue(':description', $medias['description'], PDO::PARAM_STR);
        $statement->bindValue(':cover_image', $medias['cover_image'], PDO::PARAM_STR);
        $statement->bindValue(':extract_link', $medias['extract_link'], PDO::PARAM_STR);
        $statement->bindValue(':isAvailable', $medias['isAvailable'], PDO::PARAM_STR);

        return $statement->execute();
    }
}
