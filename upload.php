<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $price = $_POST['price'];
    
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        $stmt = $conn->prepare("INSERT INTO products (name, price, image) VALUES (?, ?, ?)");
        $stmt->bind_param("sds", $name, $price, $target_file);
        $stmt->execute();
        $stmt->close();
        
        echo "Product uploaded successfully!";
    } else {
        echo "Error uploading image.";
    }
}
?>
