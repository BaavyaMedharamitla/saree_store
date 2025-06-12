<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<?php
session_start();
include 'db.php';

$result = $conn->query("SELECT * FROM products");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Saree Store</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h1>Saree Store</h1>
<a href="cart.php">🛒 View Cart (<?php echo count($_SESSION['cart'] ?? []); ?>)</a>
<div class="product-list">
<?php while($row = $result->fetch_assoc()): ?>
    <div class="product">
        <img src="<?php echo $row['image']; ?>" alt="">
        <h3><?php echo $row['name']; ?></h3>
        <p>₹<?php echo $row['price']; ?></p>
        <form method="post" action="cart.php">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <input type="submit" name="add" value="Add to Cart">
        </form>
    </div>
<?php endwhile; ?>
</div>
</body>
</html>
