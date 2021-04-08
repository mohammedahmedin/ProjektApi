<?php
    require_once "../../config/db.php";
    require_once "../../objects/User.php";

    if(isset($_GET["user_id"])) {

        $user = new User($pdo);
        $user->deleteUser($_GET["user_id"]);

    } else {
        echo "Please specify a user Id to delete";
    }