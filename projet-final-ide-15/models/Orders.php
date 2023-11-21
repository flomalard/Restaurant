<?php

namespace models;

use config\DataBase;

class Orders extends DataBase
{
    private \PDO $bdd;

    public function __construct()
    {
        $this->bdd = $this->getBdd();
    }

    public function InsertOrders($user_id, $total)
    {

        $query = $this->bdd->prepare("
        INSERT INTO orders (user_id, dateOrder, status, total)
        VALUES (?, NOW(), ?, ?)");

        $orders = $query->execute([
            $user_id,
            'en cours',
            $total

        ]);

        return $this->bdd->lastInsertId();
    }
    public function InsertOrdersdetails($order_id, $meal_ID, $PriceEach, $quantity)
    {

        $query = $this->bdd->prepare("
        INSERT INTO orderDetails (orders_ID,meal_ID, priceEach, quantity)
        VALUES (?, ?, ?,?)");

        $ordersdetail = $query->execute([
            $order_id,
            $meal_ID,
            $PriceEach,
            $quantity
        ]);

        return $ordersdetail;
    }


    
    
}
