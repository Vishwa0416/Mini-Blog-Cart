<?php
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $price = $_POST["price"];
    $image = $_POST["image"];

    $stmt = $conn->prepare("INSERT INTO products (name, price, image) VALUES (?, ?, ?)");
    $stmt->bind_param("sds", $name, $price, $image);
    $stmt->execute();
}
?>
<form method="post">
    <input type="text" name="name" placeholder="Product Name" required><br>
    <input type="number" name="price" step="0.01" placeholder="Price" required><br>
    <input type="text" name="image" placeholder="Image URL" required><br>
    <button type="submit">Add Product</button>
</form>