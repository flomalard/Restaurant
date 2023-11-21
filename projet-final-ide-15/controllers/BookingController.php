<?php

namespace controllers;

use models\Booking;

use traits\SecurityController;

class BookingController
{
    use SecurityController;

    private Booking $booking;

    public function __construct()
    {
        $this->booking = new Booking();
    }

    public function booking()
    {
        if (!isset($_SESSION["user"])) {
            header("location:index.php?message=Vous n'êtes pas connecté");
            exit();
        } else {
            if (isset($_POST["reservation"])) {
                if (
                    isset($_POST["date"])            && !empty($_POST["date"])            && preg_match("/^[0-9\-]*$/", $_POST["date"])
                    &&  isset($_POST["hour"])            && !empty($_POST["hour"])            && preg_match("/^(12|13|18|19|20|21)$/", $_POST["hour"])
                    &&  isset($_POST["minute"])          && !empty($_POST["minute"])          && preg_match("/^(00|15|30|45)$/", $_POST["minute"])
                    &&  isset($_POST["customersNumber"]) && !empty($_POST["customersNumber"]) && preg_match("/^(?:[0-9]|1[0-9]|20)$/", $_POST["customersNumber"])
                ) {
                    $user_ID = $_SESSION["user"]["id"];
                    $date = htmlspecialchars($_POST["date"] . " " . $_POST["hour"] . ":" . $_POST["minute"] . ":00");
                    $customersNumber = htmlspecialchars($_POST["customersNumber"]);
                    $booking = $this->booking->insertResa($user_ID, $date, $customersNumber);

                    $dateObject = date_create_from_format("Y-m-d", $_POST["date"]);
                    $day = date_format($dateObject, "d");
                    $month = date_format($dateObject, "m");

                    if ($customersNumber === "1") {
                        header("Location:index.php?action=booking&message=Votre réservation pour " . $customersNumber . " personne le " . $day . "/" . $month . " à " . $_POST["hour"] . "h" . $_POST["minute"] . " a bien été prise en compte.");
                        exit();
                    } else {
                        header("Location:index.php?action=booking&message=Votre réservation pour " . $customersNumber . " personnes le " . $day . "/" . $month . " à " . $_POST["hour"] . "h" . $_POST["minute"] . " a bien été prise en compte.");
                        exit();
                    }
                } else {
                    $message = "Une erreur serveur est surevenue";
                }
            }
            $template = "booking/booking";
            require "views/layout.phtml";
        }
    }

    public function getBooking()
    {
        // récupérer les meals 
        $booking = $this->booking->getResa();

        // appel au home en passant par le layout 
        $template = "booking/displayBooking";
        require "views/layout.phtml";
    }
}