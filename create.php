<?php

$pdo = new PDO('mysql: host=localhost; port=3306; dbname=phones', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$errors = [];
$name = '';
$price = '';
$description = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $date = date('Y-m-d H:i:s');

    if (!$name) {
        $errors[] = "Name must be filled.";
    }

    if (!$price) {
        $errors[] = "Price must be provided.";
    }

    if (!$description) {
        $errors[] = "You must write a product description.";
    }

    if (!is_dir('images')) {
        mkdir('images');
    }

    if (empty($errors)) {

        $image = $_FILES['image'] ?? null;

        $imagePath = '';

        if ($image && $image['tmp_name']) {
            $imagePath = ('images/' . $image['name'] . '-' . randomString(6));
            mkdir(dirname($imagePath));

            move_uploaded_file($image['tmp_name'], $imagePath);
        }

        $statement = $pdo->prepare("INSERT INTO products (name, image, price, description, date) VALUES (:name, :image, :price, :description, :date)");

        $statement->bindValue(':name', $name);
        $statement->bindValue(':image', $imagePath);
        $statement->bindValue(':price', $price);
        $statement->bindValue(':description', $description);
        $statement->bindValue(':date', $date);

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

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Phones Store Demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <h1>Add a New Phone!</h1>

    <?php if (!empty($errors)) : ?>

        <div class="alert alert-danger">
            <?php foreach ($errors as $error) : ?>

                <div><?php echo $error ?></div>

            <?php endforeach; ?>
        </div>

    <?php endif; ?>

    <form action="" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Phone Name</label>
            <input type="text" name="name" class="form-control" value="<?php echo $name ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Phone Image</label>
            <input type="file" name="image" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Phone Price</label>
            <input type="number" name="price" step=".01" class="form-control" value="<?php echo $price ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Phone Description</label>
            <textarea name="description" class="form-control"><?php echo $description ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        <a href="index.php" class="btn btn-secondary">Cancel</a>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>