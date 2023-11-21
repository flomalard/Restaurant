<?php

namespace models;

use config\DataBase;

class Meals extends DataBase
{
    private \PDO $bdd;

    public function __construct()
    {
        $this->bdd = $this->getBdd();
    }

    public function getMeals(): ?array
    {
        $query = $this->bdd->prepare("
                                            SELECT
                                                meal_ID,
                                                nameMeal,
                                                description,
                                                image,
                                                price
                                            FROM
                                                meals

                                         ");
        $query->execute();
        $meals = $query->fetchAll();

        return $meals;
    }

    public function getMealDetailsByID($meal_ID)
    {
        $query = $this->bdd->prepare("
                                        SELECT
                                            meal_ID,
                                            nameMeal,
                                            description,
                                            image,
                                            price
                                        FROM
                                            meals
                                        WHERE 
                                            meal_ID = ?
        ");
        $query->execute([$meal_ID]);
        $mealDetails = $query->fetch();
        return $mealDetails;
    }
    
    public function existingMeal($name)
    {
        $query = $this->bdd->prepare("
                                SELECT nameMeal
                                FROM meals
                                WHERE nameMeal = ?
    ");

    $query->execute([$name]);
    $existingMeal = $query->fetch();

    return $existingMeal;
    }
    
    public function addMeal(
        $name,
        $description,
        $image,
        $price
    ) {
        $query = $this->bdd->prepare("
                                INSERT INTO meals (
                                    nameMeal,
                                    description,
                                    image,
                                    price
                                )
                                VALUES (?, ?, ?, ?)
        ");

        $newMeal = $query->execute([
            $name,
            $description,
            $image,
            $price
        ]);

        return $newMeal;
    }
    
    public function deleteMeal($meal_ID)
    {
        $query = $this -> bdd -> prepare("
                                    DELETE
                                    FROM
                                        meals
                                    WHERE
                                        meal_ID = ?
                                ");
        
        $delete = $query -> execute([$meal_ID]);
        return $delete;
    }
    
    public function updateMeal($nameMeal,$description,$image,$price,$meal_ID)
    {
        $query = $this -> bdd -> prepare("  
                            UPDATE
                                meals
                            SET
                                nameMeal = ?,
                                description = ?,
                                image = ?,
                                price = ?
                            WHERE
                                meal_ID = ?  
                        ");
                        
        $update = $query -> execute([$nameMeal,$description,$image,$price,$meal_ID]);
        return $update;
    }
}