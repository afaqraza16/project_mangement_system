<?php
try {
    $host = "db";
    $username = "db";
    $password = "db";
    $database = "db";
    $charset = "utf8";
    $dsn = "mysql:host=$host;dbname=$database;charset=$charset";
    $pdo = new PDO($dsn, $username, $password);
   $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
   $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}