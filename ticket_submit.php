<?php
session_start();   // Access session data
require 'dbConnection.php';  // Database connection
require 'emailService.php';  // PHPMailer

// Redirect if user is NOT logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Ensure form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get form values safely
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $priority = trim($_POST['priority']);
    $category = trim($_POST['category']);
    $user_id = $_SESSION['user_id'];

    // Fetch user info for email notifications
    $stmtUser = $conn->prepare("SELECT username, email FROM users WHERE id = ?");
    $stmtUser->execute([$user_id]);
    $user = $stmtUser->fetch(PDO::FETCH_ASSOC);

    // Insert ticket into database - Only user supplied data
    $stmt = $conn->prepare("
        INSERT INTO tickets (user_id, title, description, status, priority, category, created_at, updated_at)
        VALUES (?, ?, ?, 'Open', ?, ?, NOW(), NOW())
    ");
    $stmt->execute([$user_id, $title, $description, $priority, $category]);

    // -------------------------
    // BUILD EMAILS
    // -------------------------

    // Email to user
    $userSubject = "Your Support Ticket Has Been Received";
    $userBody = "
        <h2>Thank you for contacting support</h2>
        <p>Your ticket has been submitted successfully.</p>
        <p><strong>Title:</strong> {$title}</p>
        <p><strong>Description:</strong> {$description}</p>
    ";

    // Email to admin
    $adminSubject = "New Support Ticket Submitted";
    $adminBody = "
        <h2>New Ticket Submitted</h2>
        <p><strong>User:</strong> {$user['username']}</p>
        <p><strong>Title:</strong> {$title}</p>
        <p><strong>Description:</strong> {$description}</p>
        <p><a href='http://localhost/SRC_Website/adminDashboard.php'>View Ticket</a></p>
    ";

    // Send emails BEFORE redirect
    sendEmail($user['email'], $userSubject, $userBody);
    sendEmail("niallmcpartlan123@gmail.com", $adminSubject, $adminBody);

    // Redirect AFTER sending emails
    echo "<script>
            alert('Your ticket has been submitted successfully.');
            window.location.href = 'myTickets.php';
          </script>";
    exit;
}
?>
