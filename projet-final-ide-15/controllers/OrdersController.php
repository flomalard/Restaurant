<?php

namespace controllers;

use models\Meals;
use models\Orders;
use traits\SecurityController;

class OrdersController
{

    use SecurityController;


    private Meals $meals;
    private Orders $orders;

    public function __construct()
    {
        $this->meals = new Meals();
        $this->orders = new Orders();
    }

    public function orderAjax()
    {
        if (!isset($_SESSION["user"])) {
            header("location:index.php?message=Vous n'êtes pas connecté");
            exit();
        } else {
            if (isset($_POST['mealID']) && !empty($_POST['mealID'])) {
                $select = htmlspecialchars($_POST['mealID']);
                $mealDetails = $this->meals->getMealDetailsByID($select);
                header('Content-type: application/json');
                echo json_encode($mealDetails);
            } else {
                $meals = $this->meals->getMeals();
                $template = "orders/orders";
                require "views/layout.phtml";
            }
        }
    }

    public function postLocalStorage()
    {
        if (!isset($_SESSION["user"])) {
            header("location:index.php?message=Vous n'êtes pas connecté");
            exit();
        } else {
            if (
                isset($_POST['orderData']) && !empty($_POST['orderData']) &&
                isset($_POST['totalPrice']) && !empty($_POST['totalPrice'])
            ) {
                $orderData = json_decode($_POST['orderData']);
                $totalPrice = htmlspecialchars($_POST['totalPrice']);
                $idUser = $_SESSION["user"]["id"];

                $order_id = $this->orders->InsertOrders($idUser, $totalPrice);

                foreach ($orderData as $data) {
                    $test = $this->orders->InsertOrdersdetails($order_id, $data->IDMeal,  $data->priceUnitaire, $data->quantity);
                }
                echo $test;
            }
        }
    }

    
    
}
