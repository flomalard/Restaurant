<?php

namespace models;

use config\Database;

class Booking extends Database
{
    private \PDO $bdd;

    public function __construct()
    {
        $this->bdd = $this->getBdd();
    }

    public function insertResa(
        $user_ID,
        $date,
        $customersNumber
    ) {

        $query = $this->bdd->prepare("
            INSERT INTO reservations (
                user_ID,
                date,
                customersNumber
            )
            VALUES (?, ?, ?)
        ");

        $booking = $query->execute([
            $user_ID,
            $date,
            $customersNumber
        ]);

        return $booking;
    }

    public function getResa()
    {

        $query = $this->bdd->prepare("
                                        SELECT
                                            U.firstName,
                                            U.lastName,
                                            R.user_ID,
                                            R.customersNumber,
                                            R.date
                                        FROM
                                            reservations AS R
                                        JOIN
                                            users AS U ON R.user_ID = U.user_id;

                                        
        ");
        $query->execute();
        $getResa = $query->fetchAll();

        return $getResa;
    }
}
