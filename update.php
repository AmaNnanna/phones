<?php

$pdo = new PDO ('mysql: host=localhost; port=3306; dbname=phones', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$id = $_GET['id'] ?? null;

$statement = $pdo->prepare('SELECT * FROM products WHERE id = :id');
$statement->bindValue(':id', $id);
$statement->execute();

$product = $statement->fetch(PDO::FETCH_ASSOC);

$name = $product['name'];
$price = $product['price'];
$description = $product['description'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    
    $statement = $pdo->prepare('UPDATE products SET name = :name, price = :price, description = :description WHERE id = :id');
    $statement->bindValue(':name', $name);
    $statement->bindValue(':price', $price);
    $statement->bindValue(':description', $description);
    $statement->bindValue(':id', $id);

    $statement->execute();

    header('Location: index.php');
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="POST">
        <div class="mb-3">
            <label class="form-label">Phone Name</label>
            <input type="text" name="name" class="form-control" value="<?php echo $name ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Phone Image</label>
            <input type="file" name="image" class="form-control" value="<?php echo $image ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Phone Price</label>
            <input type="number" name="price" step=".01" class="form-control" value="<?php echo $price ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Phone Description</label>
            <textarea name="description" class="form-control"><?php echo $description ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</body>
</html>