<?php
    session_start();
    unset($_SESSION["id_login"]);
    session_destroy();

    require_once "connection.php";

    // Fermeture du statement
    unset($stmt);

    // Fermeture de connection
    unset($pdo);

    header("Location:login.php");
?>