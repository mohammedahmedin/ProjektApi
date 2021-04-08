<?php
    require_once "../../config/db.php";
    require_once "../../objects/User.php";

    $user = new User($pdo);
    $user->GetAllUsers();