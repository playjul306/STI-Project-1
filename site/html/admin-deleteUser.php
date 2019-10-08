<?php
session_start();

if(!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === false){
    header("location: login.php");
    exit;
}
if (isset($_SESSION["isNotAdmin"]) && $_SESSION["isNotAdmin"] === 1){
    header("location: index.php");
    exit;
}

require_once("connection.php");

if (isset($_GET['delete_id_login'])) {
    try{
        $strSQLRequest = "DELETE FROM Utilisateur WHERE id_login = ".$_GET['delete_id_login'];
        $pdo->exec($strSQLRequest);
        if ($_GET['delete_id_login'] === $_SESSION['id']){
            header("Location: logout.php");
            //echo $_GET['delete_id_login']." ".$_SESSION['id'];
        } else {
            header('Location: admin.php');
        }
    } catch(PDOException $e){
        header("Location: 404.php");
    }
} else {
    header("Location: 404.php");
}
?>