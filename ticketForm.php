<?php
session_start();   // Start session to access user data

// Redirect if user is NOT logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Load the HTML form
$html = file_get_contents("ticket_form.html");

// Output the form
echo $html;
?>