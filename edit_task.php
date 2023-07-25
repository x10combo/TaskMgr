<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $due_date = $_POST['due_date'];

    $stmt = $db->prepare('UPDATE tasks SET title = :title, description = :description, due_date = :due_date WHERE id = :id');
    $stmt->bindValue(':id', $id);
    $stmt->bindValue(':title', $title);
    $stmt->bindValue(':description', $description);
    $stmt->bindValue(':due_date', $due_date);
    $stmt->execute();

    header('Location: dashboard.php');
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $db->prepare('SELECT * FROM tasks WHERE id = :id');
    $stmt->bindValue(':id', $id);
    $result = $stmt->execute();
    $task = $result->fetchArray(SQLITE3_ASSOC);
} else {
    header('Location: dashboard.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Task</title>
</head>
<body>
    <h2>Edit Task</h2>
    <form method="post">
        <input type="hidden" name="id" value="<?php echo $task['id']; ?>">
        <label for="title">Title:</label>
        <input type="text" name="title" value="<?php echo $task['title']; ?>" required>
        <br>
        <label for="description">Description:</label>
        <textarea name="description" required><?php echo $task['description']; ?></textarea>
        <br>
        <label for="due_date">Due Date:</label>
        <input type="date" name="due_date" value="<?php echo $task['due_date']; ?>" required>
        <br>
        <button type="submit">Save Changes</button>
    </form>
</body>
</html>
