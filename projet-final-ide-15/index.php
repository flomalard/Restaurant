<?php
session_start();

use controllers\BookingController;
use controllers\MealsController;
use controllers\UsersController;
use controllers\OrdersController;
use controllers\AdminController;
use controllers\OrderDetailsController;



//autoload
function chargerClasse($classe)
{
    $classe = str_replace('\\', '/', $classe);
    require $classe . '.php';
}

spl_autoload_register('chargerClasse'); //fin Autoload


// appel aux différents controllers 

$mealsController = new MealsController();
$usersController = new UsersController();
$bookingController = new BookingController();
$orders = new OrdersController();
$admins = new AdminController();
$orderDetails = new OrderDetailsController();


// si j'ai le param action via l'url 
if (array_key_exists('action', $_GET)) {
    switch ($_GET['action']) {
        case "createAccount":
            $usersController->createAccount();
            // appel à la méthode qui me permet la création d'un compte 
            break;
        case "login":
            $usersController->login();
            // appel à la méthode qui me permet de faire la connexion client 
            break;
        case "disconnect":
            $usersController->disconnect();
            // appel à la méthode qui me permet de faire la déconnexion client 
            break;
        case "disconnectAdmin":
            $admins->disconnect();
            // appel à la méthode qui me permet de faire la déconnexion client 
            break;
        case "booking":
            $bookingController->booking();
            // appel à la méthode qui me permet d'afficher la page reservation
            break;
        case "Meals":
            $orders->orderAjax();
            // appel à la méthode qui me permet d'afficher la page de commande
            break;
        case "valideOrder":
            $orders->postLocalStorage();
            // appel à la méthode qui me permet d'afficher la page de commande
            break;
        case "adminCreate":
            $admins->createAdmin();
            // appel à la méthode qui va créer un admin
            break;
        case "admin":
            $admins->loginAdmin();
            // appel à la méthode qui me permet d'afficher le home admin ou faire la connexion admin
            break;
        case "displayMeals":
            // affiche la liste des produits
            $mealsController->displayMeals();
            break;
        case "displayBooking":
            // affiche la liste des Reservations
            $bookingController->getBooking();
            break;
        case "displayOrders":
            // affiche la liste des Commandes
            $orderDetails->getOrders();
            break;
        case "displayOrder":
            // affiche les details de la Commande
            $orderDetails->getOrder();
            break;
        case "deleteMeal":
            // supprime un produit
            $mealsController->deleteMeal();
            break;
        case "updateMeal":
            // modifier un produit
            $mealsController->updateMeal();
            break;
        case "newMeal":
            // ajoute un produit
            $mealsController->addMeal();
            break;

        default:
            header('location:index.php');
            // créer une page not found 
            break;
    }
} else {
    // pour afficher la home page 
    $mealsController->home();
}
