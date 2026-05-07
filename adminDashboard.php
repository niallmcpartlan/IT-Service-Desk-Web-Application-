
<?php
session_start();   // Start session

// Block users who are NOT logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Block logged-in users who are NOT admins
if ($_SESSION['role_id'] != 1) {
    echo "<script>
            alert('You do not have administrator permissions to access this page.');
            window.location.href = 'index.html';
          </script>";
    exit;
}

// Allow access — define constant so content file knows it's safe
define('ADMIN_DASHBOARD', true);

// Load the admin dashboard content
include 'adminDashboardContent.php';
?>



