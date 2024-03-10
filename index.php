<?php

$pdo = new PDO('mysql: host=localhost; port=3306; dbname=phones', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$statement = $pdo->prepare('SELECT * FROM products ORDER BY id ASC');

$statement->execute();
$products = $statement->fetchAll(PDO::FETCH_ASSOC);

?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
    <h1>Available Phones</h1>

    <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Product Name</th>
      <th scope="col">Product Image</th>
      <th scope="col">Product Price (USD)</th>
      <th scope="col">Date Added</th>
    </tr>
  </thead>
  <tbody>

  <?php foreach ($products as $i=>$product) : ?>
    <tr>
      <th scope="row"><?php echo $i+1 ?></th>
      <td><?php echo $product['name'] ?></td>
      <td><?php echo $product['image'] ?></td>
      <td><?php echo $product['price'] ?></td>
      <td><?php echo date('jS F, Y', strtotime($product['date'])) ?></td>

    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>