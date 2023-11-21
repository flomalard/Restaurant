<?php

namespace models;

use config\DataBase;

class OrderDetails extends DataBase
{
    private \PDO $bdd;

    public function __construct()
    {
        $this->bdd = $this->getBdd();
    }
    
    public function displayOrders()
    {
        $query = $this->bdd->prepare("
                                        SELECT
                                            O.orders_ID AS order_ID,
                                            U.user_ID,
                                            U.firstName,
                                            U.lastName,
                                            O.total,
                                            DATE(O.dateOrder) AS dateOrder
                                        FROM
                                            orders AS O
                                        JOIN
                                            users AS U ON O.user_ID = U.user_ID;
    
    ");

        $query->execute();
        $getOrders = $query->fetchAll();
        return $getOrders;
    }


    public function displayOrder($orderID)
    {
        $query = $this->bdd->prepare("
                                SELECT
                                    users.firstName,
                                    users.lastName,
                                    users.address,
                                    users.city,
                                    users.postalCode,
                                    users.phone,
                                    users.mail,
                                    orderDetails.meal_ID,
                                    orderDetails.priceEach,
                                    orderDetails.quantity,
                                    meals.nameMeal,
                                    (
                                        orderDetails.priceEach * orderDetails.quantity
                                    ) AS total
                                FROM
                                    orderDetails
                                JOIN meals ON orderDetails.meal_ID = meals.meal_ID
                                JOIN orders ON orderDetails.orders_ID = orders.orders_ID
                                JOIN users ON orders.user_ID = users.user_id
                                WHERE
                                    orderDetails.orders_ID = ?

        ");
        
        $query->execute([$orderID]);
        $getOrder = $query->fetchAll();
        return $getOrder;
    }
}