<?php
require_once '../PHP/connectdb.php'; // Ensures that the database is connected using the connectdb.php which has already created a connection with the database.

if ($_SERVER["REQUEST_METHOD"] == "POST") { // Checks if the HTTP request method for the form submitted is POST.
    if (isset($_POST["signup"])) {
        $name = $_POST['name'];
        $category = $_POST['category'];
        $brand = $_POST['brand'];
        $description = $_POST['description'];
        $price = $_POST['price'];

        $file = $_FILES['image'];
        $fileName = $_FILES['image']['name'];
        $fileTmpName = $_FILES['image']['tmp_name'];
        $fileSize = $_FILES['image']['size'];
        $fileType = $_FILES['image']['type'];
        $checkFile = getimagesize($fileTmpName);

        if ($checkFile !== false) {
            $image = file_get_contents($fileTmpName);
            $image = mysqli_real_escape_string($conn, $image); 

            $sql = "INSERT INTO products (name, category, brand, description, price, image) VALUES ('$name', '$category', '$brand', '$description', '$price', '$image')";

            if (mysqli_query($conn, $sql)) {
                echo '<script>alert("Product added successfully!");</script>';
                echo '<script>window.location.href = "../PHP/products.php";</script>';
            } else { 
                echo "Error adding user: " . mysqli_error($conn); 
            } 
        }
    }
}
?>