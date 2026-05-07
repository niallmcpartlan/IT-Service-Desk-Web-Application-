<?php
session_start();                     // Start the session to access logged‑in user data
require 'dbConnection.php';          // Include the database connection

// Restrict access to admins only (role_id = 1)
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 1) {
    die("Unauthorized access");      // Stop execution if user is not an admin
}

// Ensure a guide ID was provided in the URL
if (!isset($_GET['id'])) {
    die("Invalid request");          // Prevent loading the page without a valid ID
}

$guideId = intval($_GET['id']);      // Convert the ID to an integer for safety

// Fetch the guide data from the database
$stmt = $conn->prepare("SELECT * FROM help_guides WHERE id = ?");
$stmt->execute([$guideId]);
$guide = $stmt->fetch(PDO::FETCH_ASSOC);

// If no guide exists with this ID, stop execution
if (!$guide) {
    die("Guide not found");
}
?>

<h1>Edit Guide</h1>

<!-- Form for editing the guide -->
<form action="updateGuide.php" method="POST">

    <!-- Hidden field to pass the guide ID to updateGuide.php -->
    <input type="hidden" name="id" value="<?php echo $guide['id']; ?>">

    <label>Title:</label>
    <!-- Pre-fill the title field with the current guide title -->
    <input type="text" name="title" value="<?php echo htmlspecialchars($guide['title']); ?>" required>

    <label>Description:</label>
    <!-- Pre-fill the description field with the current guide description -->
    <textarea name="description" rows="4"><?php echo htmlspecialchars($guide['description']); ?></textarea>

    <button type="submit">Save Changes</button>
</form>