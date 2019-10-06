<?php
session_start();

if(empty($_SESSION["loggedin"]) && $_SESSION["loggedin"] === false){
    header("location: login.php");
    exit;
}

require_once "connection.php";


$sql = "DELETE FROM Message WHERE Message.id_message = " . $_GET["id"];

$stmt = $pdo->query($sql);

header("location: index.php");
?>