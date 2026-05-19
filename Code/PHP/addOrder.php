<?php
session_start();
require_once '../PHP/connectdb.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["proceed-button"])) {
    if (!isset($_SESSION['userId'])) {
        header("Location: ../HTML/login_page.html");
        exit();
    }
    
    $userId = $_SESSION['userId'];

    $cartData = "SELECT * FROM cart_products WHERE customerId = $userId";
    $cartResult = mysqli_query($conn, $cartData);

    if ($cartResult && mysqli_num_rows($cartResult) > 0) {
        $cartItem = mysqli_fetch_assoc($cartResult);
        $customerName = mysqli_real_escape_string($conn, $cartItem['customerName']);
        $customerEmail = mysqli_real_escape_string($conn, $cartItem['customerEmail']);
        $productId = $cartItem['productId'];
        $productName = mysqli_real_escape_string($conn, $cartItem['productName']);
        $productCategory = mysqli_real_escape_string($conn, $cartItem['productCategory']);
        $productPrice = $cartItem['productPrice'];
        $productQuantity = $cartItem['productQuantity'];
        $productImage = mysqli_real_escape_string($conn, $cartItem['productImage']);        
    }

    $doorNumber = mysqli_real_escape_string($conn, $_POST['door-number']);
    $street = mysqli_real_escape_string($conn, $_POST['street']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $postcode = mysqli_real_escape_string($conn, $_POST['postcode']);
    $address = "$doorNumber $street, $city, $postcode";

    $insertOrder = "INSERT INTO orders
                       (customerId, customerName, customerEmail, productId, 
                        productName, productCategory, productPrice, productQuantity, productImage, address)
                       VALUES (
                           $userId,
                           '$customerName',
                           '$customerEmail',
                           $productId,
                           '$productName',
                           '$productCategory',
                           $productPrice,
                           $productQuantity,
                           '$productImage',
                           '$address'
                       )";
        
    if (mysqli_query($conn, $insertOrder)) {
        $deleteCart = "DELETE FROM cart_products WHERE customerId = $userId";
        if (!mysqli_query($conn, $deleteCart)) {
            // Handle error if cart clearing fails
            header("Location: order_success.php");
            exit();
        }
    }
    
    header("Location: ../PHP/cart.php");
    exit();
}
?>