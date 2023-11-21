<?php

namespace controllers;

use models\Meals;
use traits\SecurityController;

class MealsController
{
    use SecurityController;
    
    private Meals $meals;
    
    public function __construct()
    {
        $this -> meals = new Meals();
    }
    
    public function home():void
    {
        // récupérer les meals 
        $meals = $this -> meals -> getMeals();
        
        // appel au home en passant par le layout 
        $template = "home";
        require "views/layout.phtml";
    }
    
    public function displayMeals()
    {
        if (!isset($_SESSION["admin"])) {
            header("location:index.php?message=Vous n'êtes pas connecté");
            exit();
        }
        else
        {
        $meals = $this -> meals -> getMeals();
        
        $template = "meals/displayMeals";
        require "views/layout.phtml";
        }
    }
    
    public function deleteMeal()
    {
        if (array_key_exists("meal_id",$_GET) && is_numeric($_GET["meal_id"]))
        {
            $meal_ID = htmlspecialchars($_GET["meal_id"]);
            
            $meals = $this -> meals -> deleteMeal($meal_ID);
            
            if($meals)
            {
                header("location:index.php?action=displayMeals&message=Le produit à bien été supprimé");
                exit();
            }
        }
    }
    
    public function addMeal()
    {
        if (!isset($_SESSION["admin"])) {
            header("location:index.php?message=Vous n'êtes pas connecté");
            exit();
        } 
        else {
            if(isset($_POST['name']) && !empty($_POST['name']) && preg_match("/^[A-Za-z0-9\s\-',.!?À-ÖØ-öø-ÿ]+$/u", $_POST['name']))
            {
                $mealName = htmlspecialchars($_POST['name']);
                
                $existingMeal = $this -> meals -> existingMeal($mealName);
                
                if ($existingMeal)
                {   
                    header("location:index.php?action=newMeal&message=Un produit portant le nom $mealName existe déjà");
                    exit();
                }
                else
                {
                    if (isset($_POST['description']) && !empty($_POST['description']) && preg_match("/^[A-Za-z0-9\s\-',.!?À-ÖØ-öø-ÿ]+$/u", $_POST['description']) &&
                        isset($_POST['price'])       && !empty($_POST['price'] && is_numeric($_POST['price']) && preg_match("/^\d+(\.\d{1,2})?$/", $_POST['price']))
                    ) {
                        $description = htmlspecialchars($_POST['description']);
                        $price = htmlspecialchars(floatval($_POST['price']));
                        
                        if (!empty($_FILES["image"]["name"]))
                        {
                            $uploads_dir = "public/images/meals";
                            
                            $tmp_name = $_FILES["image"]["tmp_name"];
                            $name = $_FILES["image"]["name"];
                            move_uploaded_file($tmp_name, "$uploads_dir/$name");
                            
                            $newMeal = $this -> meals ->  addMeal($mealName, $description,$name, $price);
                        }
                        
                        else
                        {
                            $name = "no-photo.png";
                            $newMeal = $this -> meals ->  addMeal($mealName, $description,$name, $price);
                        }
                        
                        header("location:index.php?action=newMeal&message=Le produit $mealName a bien été ajouté.");
                        exit();
                    }
                }
            }
           
            $template = "meals/newMeal";
            require "views/layout.phtml";    
        }
    }
    
    public function updateMeal()
    {
        if (!isset($_SESSION["admin"]))
        {
            header("location:index.php?message=Vous n'êtes pas connecté");
            exit();
        }
        else
        {
            if (array_key_exists("meal_id",$_GET) && is_numeric($_GET["meal_id"]))
            {
                $meal_ID = $_GET["meal_id"];
                
                $meals = $this -> meals -> getMealDetailsByID($meal_ID);
                
                if (isset($_POST['name']) && !empty($_POST['name']) && preg_match("/^[A-Za-z0-9\s\-',.!?À-ÖØ-öø-ÿ]+$/u", $_POST['name']))
                {
                    $mealName = htmlspecialchars($_POST['name']);
                
                    $existingMeal = $this -> meals -> existingMeal($mealName);

                    if($existingMeal && $mealName !== $meals["nameMeal"] )
                    {
                        header("Location: index.php?action=updateMeal&meal_id=" . urlencode($meal_ID) . "&message=Un produit portant le nom $mealName existe déjà.");
                        exit();

                    }
                    else
                    {
                        if (isset($_POST['description']) && !empty($_POST['description']) && preg_match("/^[A-Za-z0-9\s\-',.!?À-ÖØ-öø-ÿ]+$/u", $_POST['description']) &&
                            isset($_POST['price'])       && !empty($_POST['price'] && is_numeric($_POST['price']) && preg_match("/^\d+(\.\d{1,2})?$/", $_POST['price']))
                        )
                        {
                            $description = htmlspecialchars($_POST['description']);
                            $price = htmlspecialchars(floatval($_POST['price']));
                            
                            
                            if (isset($_POST['oldImage']))
                            {
                                $image = htmlspecialchars($meals["image"]);
                            }
                            else if(!empty($_FILES["image"]["name"]))
                            {
                                $uploads_dir = "public/images/meals";
                                
                                $tmp_name = $_FILES["image"]["tmp_name"];
                                $name = $_FILES["image"]["name"];
                                move_uploaded_file($tmp_name, "$uploads_dir/$name");
                                
                                $image = $name;
                            }
                            else{
                                $image = "no-photo.png";
                            }
                            
                            $mealUpdate = $this -> meals -> updateMeal($mealName,$description,$image,$price,$meal_ID);
                            
                            header("Location: index.php?action=updateMeal&meal_id=" . urlencode($meal_ID) . "&message=Le produit a bien été modifié.");
                            exit();
                        }
                    }
                }
            }
            $template = "meals/updateMeal";
            require "views/layout.phtml";
        }
    }
}