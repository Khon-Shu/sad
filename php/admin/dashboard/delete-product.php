<?php
session_start();
include('../connect.php');


// Check if an ID is provided
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Delete the product
    $deleteSql = "DELETE FROM products WHERE id = $id";

    if ($conn->query($deleteSql) === TRUE) {
        echo "<script>alert('Product deleted successfully!'); window.location.href='update-products.php';</script>";
    } else {
        echo "<script>alert('Error deleting product: " . $conn->error . "'); window.location.href='update-products.php';</script>";
    }
} else {
    header("Location:update-products.php"); // Redirect if no ID is provided
    exit();
}

$conn->close(); // Close the database connection
?>
