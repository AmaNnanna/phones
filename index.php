<?php

$pdo = new PDO('mysql: host=localhost; port=3306; dbname=phones', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$search = $_GET['search'] ?? null;

if ($search) {
  $statement = $pdo->prepare('SELECT * FROM products WHERE name LIKE :name ORDER BY id DESC');
  $statement->bindValue(':name', "%$search%");
} else {
  $statement = $pdo->prepare('SELECT * FROM products ORDER BY id ASC');
}

$statement->execute();
$products = $statement->fetchAll(PDO::FETCH_ASSOC);

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
  <h1>Available Phones</h1>

  <p>
    <a href="create.php" class="btn btn-primary btn-small">Add a Product</a>
  </p>

  <form action="" method="GET">
    <div class="input-group mb-3">
      <input type="text" name="search" class="form-control" placeholder="search products" value="<?php echo $search ?>">
      <div class="input-group-append">
        <button class="btn btn-outline-secondary" type="submit">Search</button>
      </div>
    </div>
  </form>

  <table class="table">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Product Name</th>
        <th scope="col">Product Image</th>
        <th scope="col">Product Price (USD)</th>
        <th scope="col">Date Added</th>
        <th scope="col">Option</th>
      </tr>
    </thead>
    <tbody>

      <?php foreach ($products as $i => $product) : ?>
        <tr>
          <th scope="row"><?php echo $i + 1 ?></th>
          <td><a href="details.php"><?php echo $product['name'] ?></a></td>
          <td><img src="<?php echo $product['image'] ?>" alt="<?php echo $product['name'] . ' image' ?>"></td>
          <td><?php echo $product['price'] ?></td>
          <td><?php echo date('jS F, Y', strtotime($product['date'])) ?></td>
          <td>
            <a href="update.php?id=<?php echo $product['id'] ?>" type="btn" class="btn btn-small btn-outline-primary">Update Product</a>
            <form action="delete.php" method="POST" style="display: inline-block;">
              <input type="hidden" name="id" value="<?php echo $product['id'] ?>">
              <button type="submit" class="btn btn-small btn-outline-danger">Delete product</button>
            </form>
          </td>

        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>