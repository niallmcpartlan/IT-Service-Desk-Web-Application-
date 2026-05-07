<?php
session_start();
require 'dbConnection.php';   // Load database connection

// Redirect user if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Ensure a ticket ID was provided
if (!isset($_GET['id'])) {
    echo "No ticket selected.";
    exit;
}

$ticket_id = $_GET['id'];

// Delete all comments linked to this ticket (avoids foreign key issues - retain refferential integrity)
$conn->prepare("DELETE FROM comments WHERE ticket_id = ?")->execute([$ticket_id]);

// Delete the ticket itself
$conn->prepare("DELETE FROM tickets WHERE id = ?")->execute([$ticket_id]);

// Redirect back to the user's ticket list
header("Location: myTickets.php");
exit;
