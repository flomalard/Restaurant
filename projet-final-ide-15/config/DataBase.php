<?php

// Lance la connexion à la BDD 
namespace config;

class DataBase
{
    private const SERVER = "db.3wa.io";
    private const DB = "florentmalard_exercice_restaurant";
    private const USER = "florentmalard";
    private const MDP = "601bf9a529d0a4b44d52ad7df5a28861";
    
    
    private \PDO $bdd; 
    
    public function getBdd(): ? \PDO
    {
        try
        {
            $this -> bdd = new \PDO('mysql:host='.self::SERVER.';dbname='.self::DB.';charset=utf8',self::USER,self::MDP);
        }
        catch(\Exception $message)
        {
            die('Le message d\'erreur de connexion BDD : '.$message -> getMessage());
        }
        return $this -> bdd;
    }
}