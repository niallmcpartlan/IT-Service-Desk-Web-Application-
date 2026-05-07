<?php
session_start();                     // Start the session to access the logged‑in user's role
require 'dbConnection.php';          // Include the database connection

// Only admins are allowed to update guides (role_id = 1)
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 1) {
    die("Unauthorised access");      // Stop execution if the user is not an admin
}

// Retrieve and sanitise form inputs
$id = intval($_POST['id']);          // Convert guide ID to an integer for safety
$title = trim($_POST['title']);      // Remove extra whitespace from the title
$description = trim($_POST['description']); // Clean up the description text

// Update the guide record in the database
$stmt = $conn->prepare("UPDATE help_guides SET title = ?, description = ? WHERE id = ?");
$stmt->execute([$title, $description, $id]); // Execute with safe parameter binding

// Redirect back to the Help Guides page after saving changes
header("Location: helpGuides.php");
exit;                                // Stop script execution after redirect
?>