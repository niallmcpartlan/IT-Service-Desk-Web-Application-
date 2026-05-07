<?php
session_start();
require 'dbConnection.php'; // Connect to database

// User must be logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "Invalid request.";
    exit;
}

// Ensure required fields exist - ticket id and comment text are present
if (!isset($_POST['ticket_id'], $_POST['comment_text'])) {
    echo "Missing comment data.";
    exit;
}

//extracts relevent information
$ticket_id    = $_POST['ticket_id'];
$comment_text = trim($_POST['comment_text']);
$user_id      = $_SESSION['user_id'];

// Prevent empty comments
if ($comment_text === '') {
    echo "Comment cannot be empty.";
    exit;
}

try {
    // Insert comment into database
    $stmt = $conn->prepare("
        INSERT INTO comments (ticket_id, user_id, comment_text, created_at)
        VALUES (?, ?, ?, NOW())
    ");
    $stmt->execute([$ticket_id, $user_id, $comment_text]);

    // Redirect back to the ticket view page
    header("Location: ticket_view.php?id=" . $ticket_id);
    exit;

//DB Error handling - prevents crashing or leak sensitive data
} catch (PDOException $e) {
    echo "Error saving comment.";
    exit;
}