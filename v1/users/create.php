<?php
    require_once "../../config/db.php";
    require_once "../../objects/User.php";

if(isset($_GET["username"]) && isset($_GET["email"]) && isset($_GET["password"])) {
    $user = new User($pdo);
    $user->CreateUser($_GET["username"], $_GET["email"], $_GET["password"]);

} else {
    echo "All fields required";
}