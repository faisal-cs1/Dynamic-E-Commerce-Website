<?php
session_start();
require_once '../PHP/connectdb.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["cart"])) {
    // Check if user is logged in
    if (!isset($_SESSION['userId'])) {
        header("Location: ../HTML/login_page.html");
        exit();
    }
    
    $userId = (int)$_SESSION['userId'];
    $productId = (int)$_POST['productId'];
    $quantity = (int)$_POST['quantity'] ?? 1; // Ensure quantity is at least 1
    
    // Verify product exists
    $productQuery = "SELECT * FROM products WHERE productId = $productId";
    $productResult = mysqli_query($conn, $productQuery);
    
    if (mysqli_num_rows($productResult) == 0) {
        die("Product not found");
    }
    
    // Check if product already exists in cart
    $checkQuery = "SELECT * FROM cart_products WHERE customerId = $userId AND productId = $productId";
    $checkResult = mysqli_query($conn, $checkQuery);
    
    if (mysqli_num_rows($checkResult) > 0) {
        // Update quantity if product exists
        $updateQuery = "UPDATE cart_products 
                       SET productQuantity = productQuantity + $quantity 
                       WHERE customerId = $userId AND productId = $productId";
        
        if (!mysqli_query($conn, $updateQuery)) {
            die("Error updating cart: " . mysqli_error($conn));
        }
    } else {
        // Insert new cart item
        $product = mysqli_fetch_assoc($productResult);
        $userQuery = "SELECT fullName, email FROM users WHERE userId = $userId";
        $userResult = mysqli_query($conn, $userQuery);
        $user = mysqli_fetch_assoc($userResult);
        
        // Escape all string values
        $customerName = mysqli_real_escape_string($conn, $user['fullName']);
        $customerEmail = mysqli_real_escape_string($conn, $user['email']);
        $productName = mysqli_real_escape_string($conn, $product['name']);
        $productCategory = mysqli_real_escape_string($conn, $product['category']);
        $productImage = mysqli_real_escape_string($conn, $product['image']);
        
        $insertQuery = "INSERT INTO cart_products 
                       (customerId, customerName, customerEmail, productId, 
                        productName, productCategory, productPrice, productQuantity, productImage)
                       VALUES (
                           $userId,
                           '$customerName',
                           '$customerEmail',
                           $productId,
                           '$productName',
                           '$productCategory',
                           {$product['price']},
                           $quantity,
                           '$productImage'
                       )";
        
        if (!mysqli_query($conn, $insertQuery)) {
            die("Error adding to cart: " . mysqli_error($conn));
        }
    }
    
    // Success - redirect back
    header("Location: ".$_SERVER['HTTP_REFERER']);
    exit();

} else if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["wishlist"])) {
    // Check if user is logged in
    if (!isset($_SESSION['userId'])) {
        header("Location: ../HTML/login_page.html");
        exit();
    }
    
    $userId = (int)$_SESSION['userId'];
    $productId = (int)$_POST['productId'];
    $quantity = (int)$_POST['quantity'] ?? 1; // Ensure quantity is at least 1
    
    // Verify product exists
    $productQuery = "SELECT * FROM products WHERE productId = $productId";
    $productResult = mysqli_query($conn, $productQuery);
    
    if (mysqli_num_rows($productResult) == 0) {
        die("Product not found");
    }
    
    // Check if product already exists in cart
    $checkQuery = "SELECT * FROM wishlist_products WHERE customerId = $userId AND productId = $productId";
    $checkResult = mysqli_query($conn, $checkQuery);
    
    if (mysqli_num_rows($checkResult) == 0) {{
        $product = mysqli_fetch_assoc($productResult);
        $userQuery = "SELECT fullName, email FROM users WHERE userId = $userId";
        $userResult = mysqli_query($conn, $userQuery);
        $user = mysqli_fetch_assoc($userResult);
        
        // Escape all string values
        $customerName = mysqli_real_escape_string($conn, $user['fullName']);
        $customerEmail = mysqli_real_escape_string($conn, $user['email']);
        $productName = mysqli_real_escape_string($conn, $product['name']);
        $productCategory = mysqli_real_escape_string($conn, $product['category']);
        $productPrice = $product['price'];
        $productImage = mysqli_real_escape_string($conn, $product['image']);
        
        $insertQuery = "INSERT INTO wishlist_products 
                       (customerId, customerName, customerEmail, productId, 
                        productName, productCategory, productPrice, productImage)
                       VALUES (
                           $userId,
                           '$customerName',
                           '$customerEmail',
                           $productId,
                           '$productName',
                           '$productCategory',
                           $productPrice,
                           '$productImage'
                       )";

        if (!mysqli_query($conn, $insertQuery)) {
            die("Error adding to cart: " . mysqli_error($conn));
        }
    }
    
    // Success - redirect back
    header("Location: ".$_SERVER['HTTP_REFERER']);
    exit();
    }
}
?>