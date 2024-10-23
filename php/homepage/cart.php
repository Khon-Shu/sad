<?php
session_start();
include('../connect.php');

// Ensure user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: ../index.php");
    exit();
}

// Get user ID from session
$user_id = $_SESSION['user_id'];

// Fetch cart items
$sql = "SELECT c.*, p.name, p.price, p.image FROM cart c
        JOIN products p ON c.product_id = p.id
        WHERE c.user_id = '$user_id'";
$result = $conn->query($sql);
$cartItems = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $cartItems[] = $row;
    }
}

// Handle Remove from Cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_from_cart'])) {
    $cart_id = $_POST['cart_id'];

    // Remove item from cart
    $sql = "DELETE FROM cart WHERE id = '$cart_id' AND user_id = '$user_id'";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Item removed from cart!');</script>";
        // Refresh the page
        header("Location: cart.php");
        exit();
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart - TechNook</title>
    <link rel="stylesheet" href="cart.css"> <!-- Add your CSS file for styling -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    <nav class="navbar">
        <div class="navdiv">
            <div class="logo">
                <a href="home.html"><img src="../../img/logo.png" alt="Logo" class="logo-img"></a> 
            </div>
            <ul class="nav-links">
                <li>
                    <a class="link" href="home.html">Home</a>
                    <a class="link" href="shop.php">Shop</a>
                    <a class="link" href="about.php">About Us</a>
                    <a href="cart.php"><i class="bi bi-cart"></i></a>
                </li>
            </ul>
            <div class="nav-buttons">
                <a href="../logout.php" class="btn">Log out</a>
            </div>
        </div>
    </nav>

    <h1>Your Cart</h1>
    <div class="cart-container">
        <?php if (!empty($cartItems)): ?>
            <table>
                <tr>
                    <th>Product Image</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Action</th>
                </tr>
                <?php foreach ($cartItems as $item): ?>
                    <tr>
                        <td><img src="../admin/uploads/<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>" width="100"></td>
                        <td><?php echo $item['name']; ?></td>
                        <td>$<?php echo number_format($item['price'], 2); ?></td>
                        <td><?php echo $item['quantity']; ?></td>
                        <td>
                            <form method="post" action="">
                                <input type="hidden" name="cart_id" value="<?php echo $item['id']; ?>">
                                <button type="submit" name="remove_from_cart">Remove</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>Your cart is empty!</p>
        <?php endif; ?>
    </div>

</body>
</html>
