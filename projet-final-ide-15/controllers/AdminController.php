<?php

namespace controllers;

use models\Admin;
use traits\SecurityController;


class AdminController
{

    use SecurityController;

    private Admin $Admin;

    public function __construct()
    {
        $this->Admin = new Admin();
    }

    // Création admin
    public function createAdmin()
    {
        $newAdmin = $this->Admin->setAdmin();
    }

    // Home admin
    public function admin()
    {
        $template = "admin/homeAdmin";
        require "views/layout.phtml";
    }
    
    // Connexion admin  
    public function loginAdmin(): void
    {
        if (isset($_SESSION["admin"])) {
            $this -> admin();
        } else {
            if (isset($_POST['login'])) {
                if (
                    isset($_POST["mail"])    && !empty($_POST["mail"]) && preg_match("/^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$/", $_POST["mail"])
                    && isset($_POST["pass"]) && !empty($_POST["pass"]) && preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/", $_POST["pass"])
                ) {
                    $mail = htmlspecialchars($_POST["mail"]);
                    $pass = htmlspecialchars($_POST["pass"]);
                    $admin = $this->Admin->getAdmin($mail);

                    if ($admin) {
                        $verifyPass = password_verify($pass, $admin["pass"]);

                        if ($verifyPass) {
                            $_SESSION["admin"]["ID"] = $admin["admin_ID"];
                            $_SESSION["admin"]["mail"] = $admin["mail"];
                            $_SESSION["admin"]["pass"] = $admin["pass"];

                            $this -> admin();
                            return;
                        } else {
                            $message = "Votre mot de passe est incorrect";
                        }
                    } else {
                        $message = "Il n'existe pas de compte lié au mail $mail.";
                    }
                }
            }
            $template = "admin/login";
            require "views/layout.phtml";
        }
    }

    // Déconnexion admin
    public function disconnect()
    {
        if ($this->is_connectAdmin()) {
            session_unset();
            session_destroy();

            header("location:index.php");
            exit();
        }
    }
}