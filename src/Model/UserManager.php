<?php

namespace App\Model;

class UserManager extends AbstractManager
{
    public const TABLE = 'user';
    public function selectOneByEmail(string $adresseEmail): array
    {
        $statement = $this->pdo->prepare("SELECT * FROM " . static::TABLE . " WHERE adresse_email=:adresse_email");
        $statement->bindValue('adresse_email', $adresseEmail, \PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetch();
    }

    public function insert(array $credentials): int
    {
        $query = "INSERT INTO "  . static::TABLE . "(adresse_email, mot_de_passe, pseudo, role) 
        VALUES (:adresse_email, :mot_de_passe, :pseudo, 0)";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':adresse_email', $credentials['adresse_email']);
        $statement->bindValue(':mot_de_passe', password_hash($credentials['mot_de_passe'], PASSWORD_DEFAULT));
        $statement->bindValue(':pseudo', $credentials['pseudo']);
        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }
}
