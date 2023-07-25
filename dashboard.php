<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

try {
    $stmt = $db->prepare('SELECT * FROM tasks WHERE user_id = :user_id');
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $result = $stmt->execute();

    // Fetch the tasks if the query was successful
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die('Database error: ' . $e->getMessage());
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
    <h2>Welcome to the Dashboard</h2>
    <a href="add_task.php">Add New Task</a>
    <ul>
        <?php foreach ($tasks as $task) { ?>
            <li>
                <strong><?php echo $task['title']; ?></strong>
                <p><?php echo $task['description']; ?></p>
                <p>Due Date: <?php echo $task['due_date']; ?></p>
                <a href="edit_task.php?id=<?php echo $task['id']; ?>">Edit</a>
                <a href="delete_task.php?id=<?php echo $task['id']; ?>">Delete</a>
            </li>
        <?php } ?>
    </ul>
</body>
</html>
