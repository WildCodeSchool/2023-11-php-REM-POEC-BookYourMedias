<?php

namespace App\Model;

use PDO;

class CategorieManager extends AbstractManager
{
    public function getAll(): array|bool
    {
        $statement = $this->pdo->query('SELECT id, name_categorie FROM categorie ORDER BY id DESC');
        $medias = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $medias;
    }


    public const TABLE = 'categorie';

    public function insert(array $categorie): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . "(name_categorie) VALUES (:name_categorie)");
        $statement->bindValue(':name_categorie', $categorie['name_categorie'], PDO::PARAM_STR);
        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }

    /**
     * Get all row from database.
     */
    public function selectAll(string $orderBy = '', string $direction = 'ASC'): array
    {
        $query = 'SELECT * FROM ' . static::TABLE;
        if ($orderBy) {
            $query .= ' ORDER BY ' . $orderBy . ' ' . $direction;
        }

        return $this->pdo->query($query)->fetchAll();
    }
}
