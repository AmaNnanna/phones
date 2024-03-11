<?php

$pdo = new PDO ('mysql: host=localhost; port=3306; dbname=phones', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$id = $_GET['id'] ?? null;

$statement = $pdo->prepare('SELECT * FROM porducts WHERE id = :id');
$statement->bindValue(':id', $id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $statement = $pdo->prepare('UPDATE products (name, price, description) SET VALUES (:name, :price, :description');

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
            <input type="text" name="name" class="form-control" value="<?php echo $title ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Phone Image</label>
            <input type="file" name="image" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Phone Price</label>
            <input type="number" name="price" step=".01" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Phone Description</label>
            <textarea name="description" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</body>
</html>