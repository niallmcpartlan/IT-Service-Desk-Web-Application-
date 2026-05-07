<?php
session_start();                     // Start the session to access the logged‑in user's role
require 'dbConnection.php';          // Include the database connection

// Only admins (role_id = 1) are allowed to delete guides
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 1) {
    die("Unauthorized access");      // Stop execution if user is not an admin
}

// Ensure a guide ID was provided in the URL
if (!isset($_GET['id'])) {
    die("Invalid request");          // Prevent deletion without a valid ID
}

$guideId = intval($_GET['id']);      // Convert the ID to an integer for safety

// Fetch the guide's filename so we can delete the associated file
$stmt = $conn->prepare("SELECT filename FROM help_guides WHERE id = ?");
$stmt->execute([$guideId]);
$guide = $stmt->fetch(PDO::FETCH_ASSOC);

// If the guide does not exist, stop execution
if (!$guide) {
    die("Guide not found");
}

// Build the full file path for the guide stored in /guides/
$filePath = __DIR__ . '/guides/' . $guide['filename'];

// If the file exists on the server, delete it
if (file_exists($filePath)) {
    unlink($filePath);               // Remove the file from the filesystem
}

// Delete the guide record from the database
$stmt = $conn->prepare("DELETE FROM help_guides WHERE id = ?");
$stmt->execute([$guideId]);

// Redirect back to the help guides page after deletion
header("Location: helpGuides.php");
exit;                                // Stop script execution after redirect
?>