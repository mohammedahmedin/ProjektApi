<?php
    require_once "../../config/db.php";
    require_once "../../objects/User.php";

    if(isset($_GET["username"]) || isset($_GET["email"]) || isset($_GET["password"])) {
        if(!isset($_GET["user_id"])) {
            echo "Please specify a user Id to update";
            exit;
        }

        $username = false;
        $email = false;
        $password = false;
        $query = "";

        if(isset($_GET["username"])){
            $username = true;
            $query = $query . " UserName = :username, ";
        }
        
        if(isset($_GET["email"])){
            $email = true;
            $query = $query . " Useremail = :email, ";
        }
        
        if(isset($_GET["password"])){
            $password = true;
            $query = $query . " UserPassword = :password, ";
        }

        $newQuery = rtrim($query, ", ");

        if($username) {
            $username = $_GET["username"];
        }

        if($email) {
            $email = $_GET["email"];
        }

        if($password) {
            $password = $_GET["password"];
        }

        $user = new User($pdo);
        $user->updateUser($newQuery, $username, $email, $password, $_GET["user_id"]);

    } else {
        echo "All fields cannot be empty";
    }
