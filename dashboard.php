<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $db->prepare('SELECT * FROM tasks WHERE user_id = :user_id');
$stmt->bindValue(':user_id', $_SESSION['user_id'], SQLITE3_INTEGER);
$result = $stmt->execute();


echo '<h2>Task List</h2>';
echo '<ul>';


while ($task = $result->fetchArray(SQLITE3_ASSOC)) {
    echo '<li>';
    echo '<strong>Task Title:</strong> ' . $task['title'] . '<br>';
    echo '<strong>Description:</strong> ' . $task['description'] . '<br>';
    echo '<strong>Due Date:</strong> ' . $task['due_date'] . '<br>';
    echo '</li>';
}
echo '</ul>';

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

$db->close();




