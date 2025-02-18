<?php
// Start the session to use session variables
session_start();

// Include the header and config files
include 'includes/header.php';
include 'config.php';

// Check if the user is already logged in (on dashboard page)
$user_id = $_SESSION['user_id'] ?? null;

echo '<div class="container mt-5">';
echo '<h2>Dashboard</h2>';

// If the user is not logged in, prompt for login
if (!$user_id) {
    echo '<p>Please <a href="login.php">login</a> to access your dashboard.</p>';
} else {
    // Fetch and display posts from the database
    $result = $conn->query("SELECT * FROM posts WHERE user_id = $user_id");
    echo '<ul class="list-group">';
    while ($row = $result->fetch_assoc()) {
        echo "<li class='list-group-item'>{$row['title']} - {$row['created_at']}</li>";
    }
    echo '</ul>';
}

echo '</div>';

// Include the footer
include 'includes/footer.php';
?>
