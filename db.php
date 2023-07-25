<?php

$databaseFile = 'db/database.sqlite';

try {
    // Connect to the SQLite database using PDO with DSN
    $db = new PDO('sqlite:' . $databaseFile);
    
    // Enable PDO to throw exceptions on errors
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create the users table if it doesn't exist
    $db->exec('CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY,
        username VARCHAR(50) UNIQUE,
        password VARCHAR(255)
    )');

    // Create the tasks table if it doesn't exist
    $db->exec('CREATE TABLE IF NOT EXISTS tasks (
        id INTEGER PRIMARY KEY,
        user_id INTEGER,
        title VARCHAR(100),
        description TEXT,
        due_date DATE,
        status VARCHAR(20) DEFAULT "pending",
        priority VARCHAR(20) DEFAULT "medium",
        FOREIGN KEY (user_id) REFERENCES users (id)
    )');

    // Add any additional table creation or database initialization code here if needed.
} catch (PDOException $e) {
    // If an exception occurs, display the error message
    die('Database connection failed: ' . $e->getMessage());
}
