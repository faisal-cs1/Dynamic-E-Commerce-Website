<?php
session_start();
require_once '../PHP/connectdb.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if user is logged in
    if (!isset($_SESSION['userId'])) {
        header("Location: ../HTML/login_page.html");
        exit();
    }
    
    $userId = (int)$_SESSION['userId'];
    
    if (!isset($_POST['productId'])) {
        die("Product ID not provided");
    }
    
    $productId = (int)$_POST['productId'];
    
    // Verify product exists in user's wishlist
    $checkQuery = "SELECT * FROM wishlist_products WHERE customerId = $userId AND productId = $productId";
    $checkResult = mysqli_query($conn, $checkQuery);
    
    if (mysqli_num_rows($checkResult) == 0) {
        die("Product not found in your wishlist");
    }
    
    // Delete the product from wishlist
    $deleteQuery = "DELETE FROM wishlist_products WHERE customerId = $userId AND productId = $productId";
    
    if (mysqli_query($conn, $deleteQuery)) {
        // Success - redirect back
        header("Location: ".$_SERVER['HTTP_REFERER']);
        exit();
    } else {
        die("Error removing product: " . mysqli_error($conn));
    }
} else {
    header("Location: ../PHP/wishlist.php");
    exit();
}
?>