<?php
$pdo = null;

// Connection à la base de données
try{
    $pdo = new PDO('sqlite:/usr/share/nginx/databases/database.sqlite');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = "";
} catch (PDOException $e) {
    header("Location: 404.php");
}
?>