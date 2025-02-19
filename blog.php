<?php
session_start();
include 'includes/header.php';
include 'config.php';

$user_id = $_SESSION['user_id'] ?? null;

echo '<div class="container mt-5">';
echo '<h2>All Blog Posts</h2>';

if ($user_id) {
    echo '<form method="POST" class="mb-4">
            <input type="text" name="title" class="form-control mb-2" placeholder="Post Title" required>
            <textarea name="content" class="form-control mb-2" placeholder="Post Content" required style="height: 200px;"></textarea>
            <button type="submit" name="create_post" class="btn btn-primary">Create Post</button>
          </form>';
}

$result = $conn->query("SELECT posts.*, users.name FROM posts JOIN users ON posts.user_id = users.id");

echo '<div class="row">';
while ($row = $result->fetch_assoc()) {
    $is_owner = ($user_id == $row['user_id']);
    
    echo "<div class='col-md-6 mb-4'>
            <div class='card' style='min-height: 350px;'>
                <div class='card-body'>
                    <h5 class='card-title'>{$row['title']}</h5>
                    <p class='card-text'>{$row['content']}</p>
                    <p class='text-muted'>By: {$row['name']} on {$row['created_at']}</p>";

    if ($is_owner) {
        echo "<a href='edit_post.php?id={$row['id']}' class='btn btn-warning btn-sm'>Edit</a>
              <a href='?delete_id={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure?\");'>Delete</a>";
    } else {
        echo "<p class='text-muted'>You are not the owner of this post.</p>";
    }

    echo "</div></div></div>";
}

echo '</div></div>';

include 'includes/footer.php';
?>
