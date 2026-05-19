<?php
session_start();
require_once "connectdb.php";

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['productId'])) {
    $productId = $data['productId'];

    $sql = "SELECT * FROM cart_products WHERE productId = $productId";
    $result = mysqli_query($conn, $sql);
    $productData = mysqli_fetch_assoc($result);
    
    if ($productData) {
        $deleteProduct = "DELETE FROM cart_products WHERE productId = $productId";

        if (mysqli_query($conn, $deleteProduct)) {
            echo "<script>alert('Product deleted successfully'); window.location.reload();</script>";
        }
    } else {
        echo "Product not found";
    }
}
