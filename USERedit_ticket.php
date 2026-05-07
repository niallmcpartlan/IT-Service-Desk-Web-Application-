<?php
session_start();
require 'dbConnection.php';   // Load database connection

// User must be logged in to edit a ticket
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Ensure a ticket ID was provided in the URL
if (!isset($_GET['id'])) {
    echo "No ticket selected.";
    exit;
}

$ticket_id = $_GET['id'];

// Fetch the ticket data from the database
$stmt = $conn->prepare("SELECT * FROM tickets WHERE id = ?");
$stmt->execute([$ticket_id]);
$ticket = $stmt->fetch(PDO::FETCH_ASSOC);

// Stop if the ticket does not exist
if (!$ticket) {
    echo "Ticket not found.";
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Ticket</title>
</head>
<body>

<h2>Edit Ticket</h2>

<!-- Form to update ticket details -->
<form action="USERupdate_ticket.php" method="POST">

    <!-- Hidden field, knows which ticket to modify (cannot be changed by user) -->
    <input type="hidden" name="ticket_id" value="<?php echo $ticket_id; ?>">

    <!-- Title field -->
    <label>Title</label>
    <input type="text" name="title" value="<?php echo htmlspecialchars($ticket['title']); ?>" required>

    <!-- Description field -->
    <label>Description</label>
    <textarea name="description" required><?php echo htmlspecialchars($ticket['description']); ?></textarea>

    <!-- Priority dropdown, automatically selects current state -->
    <label>Priority</label>
    <select name="priority">
        <option <?php if($ticket['priority']=="Low") echo "selected"; ?>>Low</option>
        <option <?php if($ticket['priority']=="Medium") echo "selected"; ?>>Medium</option>
        <option <?php if($ticket['priority']=="High") echo "selected"; ?>>High</option>
    </select>

    <!-- Category dropdown, automatically selects current state -->
    <label>Category</label>
    <select name="category">
        <option <?php if($ticket['category']=="Hardware") echo "selected"; ?>>Hardware</option>
        <option <?php if($ticket['category']=="Software") echo "selected"; ?>>Software</option>
        <option <?php if($ticket['category']=="Other") echo "selected"; ?>>Other</option>
    </select>

    <!-- Submit button -->
    <button type="submit">Save Changes</button>
</form>

</body>
</html>
