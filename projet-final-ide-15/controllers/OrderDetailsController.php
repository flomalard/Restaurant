<?php

namespace controllers;

use models\OrderDetails;
use traits\SecurityController;

class OrderDetailsController
{
    use SecurityController;
    private OrderDetails $orderDetails;
    
    public function __construct()
    {
        $this->orderDetails = new OrderDetails();
    }
    
    public function getOrders()
    {
        $orders = $this->orderDetails->displayOrders();
        $template = "orders/displayOrders";
        require "views/layout.phtml";
    }

    public function getOrder()
    {
        if (isset($_GET['order_id'])) {
            $orderID = $_GET['order_id'];
            $getOrder = $this->orderDetails->displayOrder($orderID); // Passer l'ID de commande ici
    
            if (empty($getOrder)) {
                // Gérez le cas où la commande est introuvable
                echo "Commande introuvable.";
                return; // Arrêtez le script ici pour éviter les erreurs ultérieures
            }
    
            $template = "orderDetails/displayOrder";
            require "views/layout.phtml";
        } else {
            // Gérez le cas où l'ID de commande n'est pas spécifié
            echo "ID de commande non spécifié.";
        }
    }
}