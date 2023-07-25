<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $db->prepare('DELETE FROM tasks WHERE id = :id');
    $stmt->bindValue(':id', $id);
    $stmt->execute();
}

header('Location: dashboard.php');
exit;
?>
