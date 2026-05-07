<?php
// Load the database connection so we can run SQL queries
require 'dbConnection.php';

// Get the ticket ID from the URL (e.g., close_ticket.php?id=5)
$id = $_GET['id'];

// Prepare an SQL statement to update the ticket's status to "Closed"
$stmt = $conn->prepare("UPDATE tickets SET status = 'Closed' WHERE id = ?");

// Execute the SQL statement, passing in the ticket ID securely
$stmt->execute([$id]);

// Redirect the admin back to the dashboard after closing the ticket
header("Location: adminDashboard.php");
?>