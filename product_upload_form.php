<?php
session_start(); 
if ($_SESSION['role'] !== 'admin') { 
    header('Location: login.php');
    exit(); 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Product</title>
</head>
<body>

<h2>Add New Product</h2>
<form action="upload.php" method="post" enctype="multipart/form-data">
    <label for="name">Product Name:</label>
    <input type="text" name="name" id="name" required><br><br>

    <label for="price">Product Price (LKR):</label>
    <input type="number" name="price" id="price" required><br><br>

    <label for="image">Product Image:</label>
    <input type="file" name="image" id="image" required><br><br>

    <button type="submit">Upload Product</button>
</form>

</body>
</html>
