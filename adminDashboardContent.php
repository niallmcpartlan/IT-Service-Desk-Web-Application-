<?php
// Prevent direct access
if (!defined('ADMIN_DASHBOARD')) {
    die("Access denied.");
}

require 'dbConnection.php';

// Read search and filter values
$search = $_GET['search'] ?? '';
$status = $_GET['status'] ?? '';

// Base query
$query = "
    SELECT tickets.id, tickets.title, tickets.status, users.username
    FROM tickets
    JOIN users ON tickets.user_id = users.id
    WHERE 1=1
";

$params = [];

// Search filter
if ($search !== '') {
    $query .= " AND (tickets.title LIKE ? OR users.username LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

// Status filter
if ($status !== '') {
    $query .= " AND tickets.status = ?";
    $params[] = $status;
}

$query .= " ORDER BY tickets.created_at DESC";

// Execute query
$stmt = $conn->prepare($query);
$stmt->execute($params);
$tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>




<!DOCTYPE html>
<html lang="en">
  <head>
    
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Administrators Dashboard</title>
    <link rel="stylesheet" href="syles.css" />
    
  </head>
 
 
  <body>
    <!-- Navbar for both mobile and desktop versions -->
    <nav class="navbar">
      <div class="navbar__container">
        <a href="index.html" id="navbar__logo"><i class="fas fa-gem"></i>SRC Solutions</a>
        <div class="navbar__toggle" id="mobile-menu">
          <span class="bar"></span> <span class="bar"></span>
          <span class="bar"></span>
        </div>
        <ul class="navbar__menu">
          <li class="navbar__item">
            <a href="index.html" class="navbar__links">Home</a>
          </li>
          <li class="navbar__item">
            <a href="ticket_form.html" class="navbar__links">Submit a ticket</a>
          </li>
          <li class="navbar__item">
            <a href="profile.php" class="navbar__links">Profile Settings</a>
          </li>
          
          <li class="navbar__item">
            <a href="adminDashboard.php" class="navbar__links">Administrators Dashboard</a>
          </li>
          
        </ul>
      </div>
    </nav>


    <div style="padding: 40px;">



    <!-- Page heading -->
<h2>All Submitted Tickets</h2>

<!-- Search + filter form (uses GET so filters appear in the URL) -->
<form method="GET" class="admin-filter-bar">

    <!-- Search box: keeps previous search term using GET value -->
    <input type="text" name="search" placeholder="Search tickets..."
           value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">

    <!-- Status dropdown: auto-selects the current filter -->
    <select name="status">
        <option value="">All Statuses</option>
        <option value="Open" <?php if(isset($_GET['status']) && $_GET['status']=="Open") echo "selected"; ?>>Open</option>
        <option value="Closed" <?php if(isset($_GET['status']) && $_GET['status']=="Closed") echo "selected"; ?>>Closed</option>
    </select>

    <!-- Submit button for applying filters -->
    <button type="submit">Apply</button>
</form>


<!-- Table wrapper for styling + responsive layout -->
<div class="table-container">

    <!-- Main ticket table -->
    <table class="ticket-table">
        <thead>
            <tr>
                <!-- Column headers -->
                <th>Ticket ID</th>
                <th>Ticket Title</th>
                <th>Created By</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            <!-- Loop through all tickets returned from the database -->
            <?php foreach ($tickets as $t): ?>
            <tr>
                <!-- Ticket ID -->
                <td><?php echo $t['id']; ?></td>

                <!-- Ticket title (escaped for safety) -->
                <td><?php echo htmlspecialchars($t['title']); ?></td>

                <!-- Username of the person who created the ticket -->
                <td><?php echo htmlspecialchars($t['username']); ?></td>

                <!-- Status badge with color-coded styling -->
                <td>
                    <?php if ($t['status'] === 'Open'): ?>
                        <span class="status-open">Open</span>
                    <?php elseif ($t['status'] === 'Closed'): ?>
                        <span class="status-closed">Closed</span>
                    <?php else: ?>
                        <span class="status-pending"><?php echo htmlspecialchars($t['status']); ?></span>
                    <?php endif; ?>
                </td>

                <!-- Action buttons: View + Close/Reopen depending on status -->
                <td>
                  <div class="ticket-actions">


                      <!-- View ticket details -->
                       <a class="view-btn" href="ticket_view.php?id=<?php echo $t['id']; ?>">View</a>

                      <!-- Show Close or Reopen depending on current status -->
                       <?php if ($t['status'] === 'Open'): ?>
                       <a class="action-btn close-btn" href="close_ticket.php?id=<?php echo $t['id']; ?>">Close</a>
                     <?php else: ?>
           
                      <a class="action-btn reopen-btn" href="reopen_ticket.php?id=<?php echo $t['id']; ?>">Reopen</a>
       
                      <?php endif; ?>
   
                    </div>       
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>





    



     <!-- Footer Section -->
    <div class="footer__container">
      <div class="footer__links">
        <div class="footer__link--wrapper">
          <div class="footer__link--items">
            <h2>About Us</h2>
            <a href="/sign__up">How it works</a> <a href="/">Testimonials</a>
            <a href="/">Careers</a> <a href="/">Investments</a>
            <a href="/">Terms of Service</a>
          </div>
          <div class="footer__link--items">
            <h2>Contact Us</h2>
            <a href="/">Contact</a> <a href="/">Support</a>
            <a href="/">Destinations</a> <a href="/">Sponsorships</a>
          </div>
        </div>
        <div class="footer__link--wrapper">
          <div class="footer__link--items">
            <h2>Videos</h2>
            <a href="/">Submit Video</a> <a href="/">Ambassadors</a>
            <a href="/">Agency</a> <a href="/">Influencer</a>
          </div>
          <div class="footer__link--items">
            <h2>Social Media</h2>
            <a href="/">Instagram</a> <a href="/">Facebook</a>
            <a href="/">Youtube</a> <a href="/">Twitter</a>
          </div>
        </div>
      </div>
      
      

          <div class="footer__logo">
            <a href="/" id="footer__logo"><i class="fas fa-gem"></i>SRC Solutions</a>
          </div>
          <p class="website__rights">© SRC Solutions 2025. All rights reserved</p>
         
      
        </div>
      
    </div>
    
    <!-- Link to JavaScript file for the "navbar__toggle" which is the mobile menu  -->
    <script src="app.js"></script>
  </body>
</html>