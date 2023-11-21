<?php


namespace models;

use config\DataBase;

class Users extends DataBase
{

    private \PDO $bdd;

    public function __construct()
    {
        $this->bdd = $this->getBdd();
    }

    public function getUser($mail): ?array
    {
        $query = $this->bdd->prepare("
            SELECT
                user_id,
                firstName,
                lastName,
                birthdate,
                address,
                city,
                postalCode,
                phone,
                mail,
                pass
            FROM
                users
            WHERE
                mail = ?
        ");
        $query->execute([$mail]);
        $getUser = $query->fetchAll();

        if (empty($getUser)) 
        {
            return null;
        }
        else {
            return $getUser[0];
        }
    
    }



    public function setUser(
        $firstName,
        $lastName,
        $birthdate,
        $address,
        $city,
        $postalCode,
        $phone,
        $mail,
        $pass
    ) {
        $query = $this->bdd->prepare("
            INSERT INTO users (
                firstName,
                lastName,
                birthdate,
                address,
                city,
                postalCode,
                phone,
                mail,
                pass
            )
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $users = $query->execute([
            $firstName,
            $lastName,
            $birthdate,
            $address,
            $city,
            $postalCode,
            $phone,
            $mail,
            $pass
        ]);

        return $users;
    }
}
