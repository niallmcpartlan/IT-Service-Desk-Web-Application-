<?php
session_start();
require 'dbConnection.php';  // Load database connection

// Redirect user if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Ensure a ticket ID was provided in the URL
if (!isset($_GET['id'])) {
    echo "No ticket selected.";
    exit;
}

//URL contains valid ticket
$ticket_id = $_GET['id'];

// Fetch ticket details from database
$stmt = $conn->prepare("SELECT * FROM tickets WHERE id = ?");
$stmt->execute([$ticket_id]);
$ticket = $stmt->fetch(PDO::FETCH_ASSOC);

// Stop if ticket does not exist
if (!$ticket) {
    echo "Ticket not found.";
    exit;
}

// Fetch all comments linked to this ticket
$commentsStmt = $conn->prepare("
    SELECT comments.*, users.username
    FROM comments
    JOIN users ON comments.user_id = users.id
    WHERE ticket_id = ?
    ORDER BY created_at ASC
");

$commentsStmt->execute([$ticket_id]);
$comments = $commentsStmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Ticket</title>
    <style>
        /* Basic page styling */
        body { font-family: Arial; background: #f4f4f4; padding: 20px; }

        /* Styling for ticket, comments, and form boxes */
        .ticket-box, .comment-box, .add-comment {
            background: #fff; padding: 20px; margin-bottom: 20px;
            border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        /* Individual comment styling */
        .comment { margin-bottom: 15px; padding-bottom: 10px; border-bottom: 1px solid #ddd; }

        /* Username formatting */
        .username { font-weight: bold; }

        /* Comment input box */
        textarea { width: 100%; height: 120px; padding: 10px; }

        /* Submit button styling */
        button { padding: 10px 15px; background: #007bff; color: #fff; border: none; border-radius: 5px; }

        /* Back link styling */
        a { text-decoration: none; color: #007bff; }
    </style>
</head>
<body>

<!-- Ticket details are output -->
<div class="ticket-box">
    <h2><?php echo htmlspecialchars($ticket['title']); ?></h2>
    <p><strong>Description:</strong> <?php echo nl2br(htmlspecialchars($ticket['description'])); ?></p>
    <p><strong>Status:</strong> <?php echo $ticket['status']; ?></p>
    <p><strong>Priority:</strong> <?php echo $ticket['priority']; ?></p>
    <p><strong>Category:</strong> <?php echo $ticket['category']; ?></p>
    <p><strong>Created:</strong> <?php echo $ticket['created_at']; ?></p>




    <!-- Edit and Delete buttons -->
<div style="margin-top: 20px;">
    
<a href="USERedit_ticket.php?id=<?php echo $ticket_id; ?>" 
   style="margin-right: 15px; color: green;">Edit Ticket</a>

<a href="USERdelete_ticket.php?id=<?php echo $ticket_id; ?>" 
   style="color: red;"
   onclick="return confirm('Are you sure you want to delete this ticket?');">
   Delete Ticket
</a>

    </a>
</div>





</div>

<!-- Comments section -->
<div class="comment-box">
    <h3>Comments</h3>

    <!-- If no comments exist -->
    <?php if (count($comments) === 0): ?>
        <p>No comments yet.</p>

    <!-- Loop through and display each comment -->
    <?php else: ?>
        <?php foreach ($comments as $c): ?>
            <div class="comment">
                <div class="username"><?php echo htmlspecialchars($c['username']); ?></div>
                <div><?php echo nl2br(htmlspecialchars($c['comment_text'])); ?></div>
                <small><?php echo $c['created_at']; ?></small>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>




<!-- Add new comment form -->
<div class="add-comment">
    <h3>Add a Comment</h3>

    <!-- Submit comment to backend handler -->
    <form action="submitComment.php" method="POST">
        <!-- Hidden field to link comment to the correct ticket -->
        <input type="hidden" name="ticket_id" value="<?php echo $ticket_id; ?>">

        <!-- Comment text input -->
        <textarea name="comment_text" required></textarea>

        <!-- Submit button -->
        <button type="submit">Post Comment</button>

</form>
</div>

<!-- Back navigation -->
<a href="myTickets.php">← Back to My Tickets</a>

</body>
</html>
