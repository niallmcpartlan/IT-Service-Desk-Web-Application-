<?php
session_start();   // Start the session so we can access stored login data
require 'dbConnection.php';  // Include your database connection file

// If the user is NOT logged in, redirect them to the login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;  // Stop the script after redirect
}

// Prepare a query to fetch the logged-in user's details
// Removed full_name from the SELECT list
$stmt = $conn->prepare("SELECT username, email, role_id, created_at FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);  // Execute the query using the session user ID
$user = $stmt->fetch(PDO::FETCH_ASSOC);  // Fetch the user record as an associative array

// Convert role_id into a readable role name
$roleName = ($user['role_id'] == 1) ? "Administrator" : "Standard User";

// Load the HTML profile page into a variable
$html = file_get_contents("profilePage.html");

// Replace placeholder tags in the HTML with real user data
$html = str_replace("{{USERNAME}}", htmlspecialchars($user['username']), $html);
$html = str_replace("{{EMAIL}}", htmlspecialchars($user['email']), $html);
$html = str_replace("{{ROLE}}", $roleName, $html);
$html = str_replace("{{CREATED_AT}}", htmlspecialchars($user['created_at']), $html);

// Output the final HTML page with user data inserted
echo $html;
?>

