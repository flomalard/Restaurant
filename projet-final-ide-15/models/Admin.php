<?php


namespace models;

use config\Database;

class Admin extends Database
{
    private \PDO $bdd;

    public function __construct()
    {
        $this->bdd = $this->getBdd();
    }


/* normalement à supprimmer, on passe par cette méthode pour hacher les mdp

    public function setAdmin()
    {

        $mail = "flo@mail.com";
        $pass = password_hash("azertyQ2", PASSWORD_DEFAULT);
        $query = $this->bdd->prepare("
                                    INSERT INTO admins(
                                        mail,
                                        pass
                                    )
                                    VALUES (
                                        ?,
                                        ?
                                    )
        ");

        $query->execute([$mail, $pass]);
    }

*/

    public function getAdmin($mail): ?array
    {
        $query = $this->bdd->prepare("
            SELECT
                admin_ID,
                mail,
                pass
            FROM
                admins
            WHERE
                mail = ?
        ");
        $query->execute([$mail]);
        $getAdmin = $query->fetch();

        if (empty($getAdmin)) {
            return null;
        } else {
            return $getAdmin;
        }
    }
}
