<?php
session_start();
require 'dbConnection.php'; // Connect to the database using PDO

/* 
---------------------------------------------------------
  SECURITY CHECK — ONLY ADMINS CAN UPLOAD (role_id = 1)
---------------------------------------------------------
*/
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 1) {
    die("Unauthorized access"); // Stop execution if user is not an admin
}

/*
---------------------------------------------------------
  ENSURE THE FORM WAS SUBMITTED USING POST
---------------------------------------------------------
*/
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Invalid request"); // Prevent direct access without form submission
}

/*
---------------------------------------------------------
  COLLECT FORM INPUTS
---------------------------------------------------------
*/
$title = trim($_POST['title']);
$description = trim($_POST['description']);

/*
---------------------------------------------------------
  VALIDATE FILE UPLOAD
---------------------------------------------------------
*/
if (!isset($_FILES['guideFile']) || $_FILES['guideFile']['error'] !== UPLOAD_ERR_OK) {
    die("File upload failed"); // File missing or upload error
}

$file = $_FILES['guideFile'];

/*
---------------------------------------------------------
  ALLOWED FILE TYPES FOR SECURITY
---------------------------------------------------------
*/
$allowedTypes = [
    'application/pdf',
    'application/msword',
    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    'image/jpeg',
    'image/png'
];

if (!in_array($file['type'], $allowedTypes)) {
    die("Invalid file type"); // Prevent uploading dangerous file types
}

/*
---------------------------------------------------------
  ENSURE /guides/ FOLDER EXISTS
---------------------------------------------------------
*/
$uploadDir = __DIR__ . '/guides/';

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true); // Create folder if missing
}

/*
---------------------------------------------------------
  GENERATE A SAFE, UNIQUE FILENAME
---------------------------------------------------------
*/
$extension = pathinfo($file['name'], PATHINFO_EXTENSION);
$filename = uniqid('guide_', true) . '.' . $extension; // Prevent overwriting files

$destination = $uploadDir . $filename;

/*
---------------------------------------------------------
  MOVE FILE TO /guides/ DIRECTORY
---------------------------------------------------------
*/
if (!move_uploaded_file($file['tmp_name'], $destination)) {
    die("Failed to save uploaded file"); // File could not be moved
}

/*
---------------------------------------------------------
  INSERT GUIDE INFORMATION INTO DATABASE
---------------------------------------------------------
*/
$sql = "INSERT INTO help_guides (title, description, filename, uploaded_by) 
        VALUES (:title, :description, :filename, :uploaded_by)";

$stmt = $conn->prepare($sql);

$stmt->execute([
    ':title' => $title,
    ':description' => $description,
    ':filename' => $filename,
    ':uploaded_by' => $_SESSION['username'] // Track who uploaded it
]);

/*
---------------------------------------------------------
  REDIRECT BACK TO HELP GUIDES PAGE
---------------------------------------------------------
*/
header("Location: helpGuides.php");
exit;

?>