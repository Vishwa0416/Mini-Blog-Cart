<?php
session_start();
include 'includes/header.php';
include 'config.php';

$user_id = $_SESSION['user_id'] ?? null;

echo '<div class="container mt-5">';
echo '<h2>Dashboard</h2>';

if (!$user_id) {
    echo '<p>Please <a href="login.php">login</a> to access your dashboard.</p>';
} else {
    $user_result = $conn->query("SELECT name, email FROM users WHERE id = $user_id");
    $user = $user_result->fetch_assoc();

    $post_result = $conn->query("SELECT * FROM posts WHERE user_id = $user_id ORDER BY created_at DESC");
    $total_posts = $post_result->num_rows;

    echo "<div class='card p-3 mb-4'>
            <h4>Welcome, {$user['name']}!</h4>
            <p>Email: {$user['email']}</p>
            <p>Total Posts: <strong>{$total_posts}</strong></p>
          </div>";

    echo '<div class="card p-3 mb-4">
            <h5>Create a New Post</h5>
            <form method="POST" action="create_post.php">
                <input type="text" name="title" class="form-control mb-2" placeholder="Post Title" required>
                <textarea name="content" class="form-control mb-2" placeholder="Post Content" required style="height: 100px;"></textarea>
                <button type="submit" name="create_post" class="btn btn-primary">Post</button>
            </form>
          </div>';

    if ($total_posts > 0) {
        echo '<h5>Your Posts</h5><ul class="list-group">';
        while ($row = $post_result->fetch_assoc()) {
            echo "<li class='list-group-item d-flex justify-content-between align-items-center'>
                    <div>
                        <strong>{$row['title']}</strong>
                        <small class='text-muted'> - {$row['created_at']}</small>
                    </div>
                    <div>
                        <a href='edit_post.php?id={$row['id']}' class='btn btn-warning btn-sm'>Edit</a>
                        <a href='delete_post.php?id={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure?\");'>Delete</a>
                    </div>
                  </li>";
        }
        echo '</ul>';
    } else {
        echo '<p>No posts yet. Start writing!</p>';
    }
}

echo '</div>';
include 'includes/footer.php';
?>
