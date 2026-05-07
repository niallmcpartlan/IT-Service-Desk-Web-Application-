<?php

session_start(); // start the session so $_SESSION is available


// Optional: simple role fallback to avoid warnings during testing
if (!isset($_SESSION['role_id'])) {
    $_SESSION['role_id'] = '1'; // or 'admin' while I test
}

// include your DB connection
require 'dbConnection.php'; // adjust filename if different

// Fetch all help guides from the database
$sql = "SELECT * FROM help_guides ORDER BY uploaded_at DESC";
$stmt = $conn->prepare($sql);
$stmt->execute();

$guides = $stmt->fetchAll(PDO::FETCH_ASSOC);



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Help Guides – SRC Solutions</title>
    <link rel="stylesheet" href="syles.css">
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



<h1>Help Guides Library</h1>

<!-- ADMIN UPLOAD SECTION (only visible to admins) -->
<?php if (isset($_SESSION['role_id']) && $_SESSION['role_id'] == 1): ?>
<div class="upload-section">
    <h2>Upload a New Help Guide</h2>

    <!-- Form for uploading a new help guide -->
    <form action="processGuideUpload.php" method="POST" enctype="multipart/form-data">

        <!-- Guide title input -->
        <label>Guide Title:</label>
        <input type="text" name="title" required>

        <!-- Optional description field -->
        <label>Description:</label>
        <textarea name="description" rows="4"></textarea>

        <!-- File upload field (PDF, Word, or image formats allowed) -->
        <label>Select File:</label>
        <input type="file" name="guideFile" accept=".pdf,.doc,.docx,.jpg,.png" required>

        <!-- Submit button to upload the guide -->
        <button type="submit">Upload Guide</button>
    </form>
</div>
<?php endif; ?>





<!-- GUIDE LIST (visible to everyone) -->
<div class="guides-container">
    <h2>Available Help Guides</h2>

    <?php if (!empty($guides)): ?> 
        <!-- Loop through each guide and display it -->
        <?php foreach ($guides as $g): ?>
            <div class="guide-card">

                <!-- Display the guide title -->
                <h3><?php echo htmlspecialchars($g['title']); ?></h3>

                <!-- Display the guide description -->
                <p><?php echo htmlspecialchars($g['description']); ?></p>

                <!-- Download link for the guide file -->
                <a href="guides/<?php echo htmlspecialchars($g['filename']); ?>" target="_blank">
                    Download Guide
                </a>

                <!-- Admin-only controls: Edit and Delete buttons -->
                <?php if (isset($_SESSION['role_id']) && $_SESSION['role_id'] == 1): ?>
                    <div class="admin-controls">

                        <!-- Edit button (opens editGuide.php with the guide ID) -->
                        <a class="edit-btn" href="editGuide.php?id=<?php echo $g['id']; ?>">
                            Edit
                        </a>

                        <!-- Delete button with confirmation popup -->
                        <a class="delete-btn"
                           href="deleteGuide.php?id=<?php echo $g['id']; ?>"
                           onclick="return confirm('Are you sure you want to delete this guide?');">
                            Delete
                        </a>

                    </div>
                <?php endif; ?>

            </div> <!-- correct closing tag for guide-card -->
        <?php endforeach; ?>

    <?php else: ?>
        <!-- Message shown when no guides exist -->
        <p>No help guides have been uploaded yet.</p>
    <?php endif; ?>

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
      </section>
    </div>
    
    <!-- Link to JavaScript file for the "navbar__toggle" which is the mobile menu  -->
    <script src="app.js"></script>
  </body>
</html>