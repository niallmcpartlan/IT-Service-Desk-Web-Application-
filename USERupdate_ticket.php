<?php
session_start();
require 'dbConnection.php';   // Load database connection

// Redirect user if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Only allow POST requests (prevents direct URL access)
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "Invalid request.";
    exit;
}

// Retrieve submitted form values
$ticket_id   = $_POST['ticket_id'];
$title       = trim($_POST['title']);
$description = trim($_POST['description']);
$priority    = $_POST['priority'];
$category    = $_POST['category'];

// Update ticket details in the database
$stmt = $conn->prepare("
    UPDATE tickets
    SET title = ?, description = ?, priority = ?, category = ?, updated_at = NOW()
    WHERE id = ?
");
$stmt->execute([$title, $description, $priority, $category, $ticket_id]);

// Redirect back to the ticket view page
header("Location: ticket_view.php?id=" . $ticket_id);
exit;
