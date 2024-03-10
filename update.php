<?php

$pdo = new PDO ('mysql: host=localhost; port=3306; dbname=phones', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$id = $_GET['id'] ?? null;

$statement = $pdo->prepare('SELECT * FROM porducts WHERE id = :id');
$statement->bindValue(':id', $id);

$statement = $pdo->prepare('UPDATE products (name, price, description) SET VALUES (:name, :price, :description');

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>