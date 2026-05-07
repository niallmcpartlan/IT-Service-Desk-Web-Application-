<?php
session_start();
require 'dbConnection.php';  // Database connection

// Redirect if user is NOT logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch all tickets for this user
$stmt = $conn->prepare("
    SELECT id, title, status, priority, category, created_at
    FROM tickets
    WHERE user_id = ?
    ORDER BY created_at DESC
");
$stmt->execute([$user_id]);
$tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Load the HTML template
$html = file_get_contents("myTickets.html");

// Build the ticket rows dynamically
$ticketRows = "";

if (count($tickets) === 0) {
    $ticketRows = "<tr><td colspan='5'>You have not submitted any tickets yet.</td></tr>";
} else {
    foreach ($tickets as $t) {
        $ticketRows .= "
            <tr>
                <td>" . htmlspecialchars($t['title']) . "</td>
                <td>" . htmlspecialchars($t['status']) . "</td>
                <td>" . htmlspecialchars($t['priority']) . "</td>
                <td>" . htmlspecialchars($t['category']) . "</td>
                <td>" . htmlspecialchars($t['created_at']) . "</td>
                <td><a href='ticket_view.php?id=" . $t['id'] . "'>View</a></td>
            </tr>
        ";
    }
}

// Replace placeholder in HTML
$html = str_replace("{{TICKET_ROWS}}", $ticketRows, $html);

// Output final page
echo $html;
?>
