<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $due_date = $_POST['due_date'];
    $user_id = $_SESSION['user_id'];

    $stmt = $db->prepare('INSERT INTO tasks (title, description, due_date, user_id) VALUES (:title, :description, :due_date, :user_id)');
    $stmt->bindValue(':title', $title);
    $stmt->bindValue(':description', $description);
    $stmt->bindValue(':due_date', $due_date);
    $stmt->bindValue(':user_id', $user_id);
    $stmt->execute();

    header('Location: dashboard.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add New Task</title>
</head>
<body>
    <h2>Add New Task</h2>
    <form method="post">
        <label for="title">Title:</label>
        <input type="text" name="title" required>
        <br>
        <label for="description">Description:</label>
        <textarea name="description" required></textarea>
        <br>
        <label for="due_date">Due Date:</label>
        <input type="date" name="due_date" required>
        <br>
        <button type="submit">Add Task</button>
    </form>
</body>
</html>
