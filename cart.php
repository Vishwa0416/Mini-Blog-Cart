<?php
session_start();
include 'includes/header.php';
include 'config.php';

$user_id = $_SESSION['user_id'] ?? null;

echo '<div class="container mt-5">';

if (!$user_id) {
    echo '<script>
            alert("Please log in to access your cart.");
            window.location.href = "login.php";
          </script>';
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'], $_POST['quantity'])) {
    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);

    $stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?) 
                            ON DUPLICATE KEY UPDATE quantity = quantity + VALUES(quantity)");
    $stmt->bind_param("iii", $user_id, $product_id, $quantity);
    $stmt->execute();
    $stmt->close();

    echo '<div class="alert alert-success">Product added to cart!</div>';
}

if (isset($_GET['remove'])) {
    $remove_id = intval($_GET['remove']);
    $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ? AND product_id = ?");
    $stmt->bind_param("ii", $user_id, $remove_id);
    $stmt->execute();
    $stmt->close();

    echo '<div class="alert alert-danger">Product removed from cart!</div>';
}

echo '<h3>Product Listing</h3>';
$result = $conn->query("SELECT * FROM products");
if ($result->num_rows > 0) {
    echo '<div class="row">';
    while ($product = $result->fetch_assoc()) {
        echo "<div class='col-md-4'>
                <div class='card mb-3'>
                    <div class='card-body'>
                        <h5 class='card-title'>{$product['name']}</h5>
                        <p class='card-text'>Price: Rs. {$product['price']}</p>
                        <form method='post' action=''>
                            <input type='hidden' name='product_id' value='{$product['id']}'>
                            <input type='number' name='quantity' value='1' min='1' class='form-control mb-2' required>
                            <button type='submit' class='btn btn-primary w-100'>Add to Cart</button>
                        </form>
                    </div>
                </div>
              </div>";
    }
    echo '</div>';
} else {
    echo '<p class="alert alert-info">No products available.</p>';
}

$result = $conn->query("
    SELECT products.id, products.name, products.price, cart.quantity 
    FROM cart 
    JOIN products ON cart.product_id = products.id 
    WHERE cart.user_id = $user_id
");

if ($result->num_rows > 0) {
    echo '<h3 class="mt-4">Your Cart</h3>';
    echo '<table class="table table-bordered">';
    echo '<thead class="table-dark">
            <tr>
                <th>Product</th>
                <th>Price (LKR)</th>
                <th>Quantity</th>
                <th>Total (LKR)</th>
                <th>Action</th>
            </tr>
          </thead><tbody>';

    $grand_total = 0;
    while ($row = $result->fetch_assoc()) {
        $item_total = $row['price'] * $row['quantity'];
        $grand_total += $item_total;
        echo "<tr>
                <td>{$row['name']}</td>
                <td>Rs. {$row['price']}</td>
                <td>{$row['quantity']}</td>
                <td>Rs. {$item_total}</td>
                <td>
                    <a href='?remove={$row['id']}' class='btn btn-danger btn-sm' 
                       onclick=\"return confirm('Remove this item?')\">Remove</a>
                </td>
              </tr>";
    }

    echo "<tr>
            <td colspan='3' class='text-end'><strong>Grand Total:</strong></td>
            <td><strong>Rs. {$grand_total}</strong></td>
            <td></td>
          </tr>";
    echo '</tbody></table>';
} else {
    echo '<p class="alert alert-info">Your cart is empty.</p>';
}

echo '<a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>';
echo '</div>';

include 'includes/footer.php';
?>
