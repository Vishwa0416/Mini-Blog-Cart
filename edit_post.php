<?php
session_start();
include 'includes/header.php';
include 'config.php';

$user_id = $_SESSION['user_id'] ?? null;

if (!isset($_GET['id'])) {
    echo '<p class="alert alert-danger">Post ID is missing.</p>';
    exit();
}

$post_id = $_GET['id'];

$result = $conn->query("SELECT * FROM posts WHERE id = '$post_id' AND user_id = '$user_id'");

if ($result->num_rows == 0) {
    echo '<p class="alert alert-danger">Post not found or you are not the owner of this post.</p>';
    exit();
}

$post = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_post'])) {
    $title = $conn->real_escape_string($_POST['title']);
    $content = $conn->real_escape_string($_POST['content']);

    $conn->query("UPDATE posts SET title = '$title', content = '$content' WHERE id = '$post_id' AND user_id = '$user_id'");

    echo '<div class="alert alert-success">Post updated successfully.</div>';
    header('Location: blog.php');
    exit();
}

?>

<div class="container mt-5">
    <h2>Edit Blog Post</h2>

    <form method="POST" class="mb-4">
        <input type="text" name="title" class="form-control mb-2" value="<?= htmlspecialchars($post['title']) ?>"
            required>
        <textarea name="content" class="form-control mb-2" required
            style="height: 200px;"><?= htmlspecialchars($post['content']) ?></textarea>
        <button type="submit" name="update_post" class="btn btn-primary">Update Post</button>
    </form>

    <a href="blog.php" class="btn btn-secondary">Back to Blog</a>
</div>

<?php
include 'includes/footer.php';
?>