<?php

namespace controllers;

use models\Users;

//On passe is_connect() en trait pour pouvoir l'appeller facilement dans tous les controleurs.
use traits\SecurityController;

class UsersController
{
    use SecurityController;

    private Users $users;

    public function __construct()
    {
        $this->users = new Users();
    }

    public function createAccount(): void
    {
        if (isset($_SESSION["user"])) {
            header("location:index.php?message=Vous etes déjà connecté");
            exit();
        } else {
            if (isset($_POST['createAccount'])) {
                if (isset($_POST["mail"]) && !empty($_POST["mail"]) && preg_match("/^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$/", $_POST["mail"])) {
                    $mail = htmlspecialchars($_POST["mail"]);
                    $user = $this->users->getUser($mail);

                    if ($user) {
                        $template = "user/existingAccount";
                        require "views/layout.phtml";
                        return;
                    } else {

                        if (
                            isset($_POST["firstName"])      && !empty($_POST["firstName"])  && preg_match("/^[a-zA-ZÀ-ÿ\s\-]*$/", $_POST["firstName"])
                            &&  isset($_POST["lastName"])   && !empty($_POST["lastName"])   && preg_match("/^[a-zA-ZÀ-ÿ\s\-]*$/", $_POST["lastName"])
                            &&  isset($_POST["birthdate"])  && !empty($_POST["birthdate"])  && preg_match("/^[0-9\-]*$/", $_POST["birthdate"])
                            &&  isset($_POST["address"])    && !empty($_POST["address"])    && preg_match("/^[a-zA-Z0-9À-ÿ\s\-]*$/", $_POST["address"])
                            &&  isset($_POST["city"])       && !empty($_POST["city"])       && preg_match("/^[a-zA-ZÀ-ÿ\s\-]*$/", $_POST["city"])
                            &&  isset($_POST["postalCode"]) && !empty($_POST["postalCode"]) && preg_match("/^\d{5}$/", $_POST["postalCode"])
                            &&  isset($_POST["phone"])      && !empty($_POST["phone"])      && preg_match("/^(?:(?:\+|00)33|0)\s*[1-9](?:[\s.-]*\d{2}){4}$/", $_POST["phone"])
                            //phone passé en varchar sur bdd pour accepter les espaces entre les numéros. Sinon, il faudra définir une saisie de nombres strict
                            &&  isset($_POST["mail"])       && !empty($_POST["mail"])       && preg_match("/^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$/", $_POST["mail"])
                            &&  isset($_POST["pass"])       && !empty($_POST["pass"])       && preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/", $_POST["pass"])
                        ) {
                            $firstName  = htmlspecialchars($_POST["firstName"]);
                            $lastName   = htmlspecialchars($_POST["lastName"]);
                            $birthdate  = htmlspecialchars($_POST["birthdate"]);
                            $address    = htmlspecialchars($_POST["address"]);
                            $city       = htmlspecialchars($_POST["city"]);
                            $postalCode = htmlspecialchars($_POST["postalCode"]);
                            $phone      = htmlspecialchars($_POST["phone"]);
                            $mail       = htmlspecialchars($_POST["mail"]);
                            $pass       = htmlspecialchars(password_hash($_POST['pass'], PASSWORD_DEFAULT));


                            $users = $this->users->setUser(
                                $firstName,
                                $lastName,
                                $birthdate,
                                $address,
                                $city,
                                $postalCode,
                                $phone,
                                $mail,
                                $pass
                            );

                            if ($users) {
                                header("location:index.php?action=login&message=Votre compte à bien été crée");
                                exit();
                            } else {
                                $message = "Une erreur serveur est surevenue";
                            }
                        }
                    }
                }
            }
            $template = "user/createAccount";
            require "views/layout.phtml";
        }
    }

    public function login(): void
    {
        if (isset($_SESSION["user"])) {
            header("location:index.php?message=Vous etes déjà connecté");
            exit();
        } else {
            if (isset($_POST['login'])) {
                if (
                    isset($_POST["mail"])    && !empty($_POST["mail"]) && preg_match("/^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$/", $_POST["mail"])
                    && isset($_POST["pass"]) && !empty($_POST["pass"]) && preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/", $_POST["pass"])
                ) {
                    $mail = htmlspecialchars($_POST["mail"]);
                    $pass = htmlspecialchars($_POST["pass"]);

                    $user = $this->users->getUser($mail);

                    if ($user) {
                        $verifyPass = password_verify($pass, $user["pass"]);

                        if ($verifyPass) {
                            $_SESSION["user"]["id"] = $user["user_id"];
                            $_SESSION["user"]["firstName"] = $user["firstName"];
                            $_SESSION["user"]["lastName"] = $user["lastName"];

                            header("Location:index.php?message=Vous etes bien connecté");
                            exit();
                        } else {
                            $message = "Votre mot de passe est incorrect";
                        }
                    } else {
                        $message = "Il n'existe pas de compte lié au mail $mail.";
                    }
                }
            }
            $template = "user/login";
            require "views/layout.phtml";
        }
    }
    public function disconnect()
    {
        if ($this->is_connect()) {
            session_unset();
            session_destroy();

            header("location:index.php");
            exit();
        }
    }
}
