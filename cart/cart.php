<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<?php
session_start();
include 'db.php';

// Add item
if (isset($_POST['add'])) {
    $id = $_POST['id'];
    $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + 1;
}

// Remove item
if (isset($_POST['remove'])) {
    unset($_SESSION['cart'][$_POST['id']]);
}

$cart = $_SESSION['cart'] ?? [];
$items = [];

if ($cart) {
    $ids = implode(",", array_keys($cart));
    $result = $conn->query("SELECT * FROM products WHERE id IN ($ids)");
    while ($row = $result->fetch_assoc()) {
        $row['qty'] = $cart[$row['id']];
        $items[] = $row;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Cart</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h1>Your Cart</h1>
<a href="index.php">← Back to Shop</a>
<?php if ($items): ?>
    <ul>
    <?php $total = 0; foreach ($items as $item): 
        $subtotal = $item['price'] * $item['qty'];
        $total += $subtotal;
    ?>
        <li>
            <?php echo $item['name']; ?> x <?php echo $item['qty']; ?> = ₹<?php echo $subtotal; ?>
            <form method="post" style="display:inline;">
                <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                <input type="submit" name="remove" value="Remove">
            </form>
        </li>
    <?php endforeach; ?>
    </ul>
    <p><strong>Total:</strong> ₹<?php echo $total; ?></p>
    <a href="checkout.php"><button>Proceed to Checkout</button></a>
<?php else: ?>
    <p>Your cart is empty.</p>
<?php endif; ?>
</body>
</html>
