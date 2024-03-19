<?php

$pdo = new PDO('mysql: host=localhost; port=3306; dbname=phones', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$id = $_GET['id'] ?? null;

$statement = $pdo->prepare('SELECT * FROM products WHERE id = :id');
$statement->bindValue(':id', $id);
$statement->execute();

$product = $statement->fetch(PDO::FETCH_ASSOC);

$errors = [];

$name = $product['name'];
$price = $product['price'];
$description = $product['description'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    if (!$name) {
        $errors[] = "You removed this product's name.";
    }

    if (!$price) {
        $errors[] = "You removed $name's price";
    }

    if (!$description) {
        $errors[] = "Add a new description for $name";
    }

    if (!is_dir('images')) {
        mkdir('images');
    }

    if (empty($errors)) {

        $image = $_FILES['image'] ?? null;

        $imagePath = $product['image'];

        if ($image && $image['tmp_name']) {

            if ($product['image']) {
                unlink($product['image']);
            }

            $imagePath = 'images/' . $image['name'] . '-' . randomString(6);
            mkdir(dirname($imagePath));

            move_uploaded_file($image['tmp_name'], $imagePath);
        }

        $statement = $pdo->prepare('UPDATE products SET name = :name, image = :image, price = :price, description = :description WHERE id = :id');
        $statement->bindValue(':name', $name);
        $statement->bindValue(':image', $imagePath);
        $statement->bindValue(':price', $price);
        $statement->bindValue(':description', $description);
        $statement->bindValue(':id', $id);

        $statement->execute();

        header('Location: index.php');
    }
}

function randomString($n)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $str = '';

    for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $str .= $characters[$index];
    }

    return $str;
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phones Store Demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <h3>Change Phone's Details</h3>

    <?php if (!empty($errors)) : ?>
        <div class="alert alert-danger">

            <?php foreach ($errors as $error) : ?>
                <div><?php echo $error ?></div>
            <?php endforeach; ?>

        </div>
    <?php endif; ?>

    <form action="" method="POST" enctype="multipart/form-data">
        <?php if ($product['image']) : ?>
            <img src="<?php echo $product['image'] ?>" alt="<?php echo $name . ' image' ?>">
        <?php endif; ?>
        <div class="mb-3">
            <label class="form-label">Phone Image</label>
            <input type="file" name="image" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Phone Name</label>
            <input type="text" name="name" class="form-control" value="<?php echo $name ?>">
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
        <a href="index.php" class="btn btn-secondary">Cancel</a>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>