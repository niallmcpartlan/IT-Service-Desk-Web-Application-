<?php
// Load the database connection so we can run SQL queries
require 'dbConnection.php';

// Get the ticket ID from the URL (e.g., reopen_ticket.php?id=5)
$id = $_GET['id'];

// Prepare an SQL statement to update the ticket's status back to "Open"
$stmt = $conn->prepare("UPDATE tickets SET status = 'Open' WHERE id = ?");

// Execute the SQL statement, passing in the ticket ID securely
$stmt->execute([$id]);

// Redirect the admin back to the dashboard after reopening the ticket
header("Location: adminDashboard.php");
?>
