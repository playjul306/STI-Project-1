<?php
$pdo = null;
try{
    // Create (connect to) SQLite database in file
    $pdo = new PDO('sqlite:/usr/share/nginx/databases/database.sqlite');
    // Set errormode to exceptions
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = "";
} catch (PDOException $e) {
    header("Location: 404.php");
}
?>