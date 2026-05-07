<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

// Loads PHPMailer classes via Composer's autoloader
require __DIR__ . '/vendor/autoload.php';

function sendEmail($to, $subject, $body) {
    // Create a new PHPMailer instance with exception handling enabled
    $mail = new PHPMailer(true);

    try {
        // --- SMTP CONFIGURATION ---

        $mail->isSMTP();                        // Use SMTP instead of PHP's mail()
        $mail->Host       = 'smtp.gmail.com';   // Gmail SMTP server
        $mail->SMTPAuth   = true;               // Enable SMTP authentication
        $mail->Username   = 'niallmcpartlan93@gmail.com'; // Gmail address used to send emails
        $mail->Password   = 'vptyexsdptzetild'; // Gmail App Password (16 chars, no spaces)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // TLS encryption required by Gmail
        $mail->Port       = 587;                // TLS port for Gmail SMTP

        // --- EMAIL HEADERS ---

        $mail->setFrom('niallmcpartlan93@gmail.com', 'SRC Support'); // Sender email + display name
        $mail->addAddress($to);                                      // Recipient email

        // --- EMAIL CONTENT ---

        $mail->isHTML(true);                // Enable HTML formatting
        $mail->Subject = $subject;          // Email subject line
        $mail->Body    = $body;             // HTML email body

        // Attempt to send the email
        $mail->send();
        return true;                         // Success

    } catch (Exception $e) {
        return false;                        // Failure (you can log $e->getMessage() if needed)
    }
}
