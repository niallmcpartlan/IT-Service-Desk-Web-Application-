<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require __DIR__ . '/vendor/autoload.php';   // Loads PHPMailer classes via Composer

$mail = new PHPMailer(true);                // Creates a new PHPMailer instance with exceptions enabled

try {
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;  // Enables detailed SMTP output for debugging

    $mail->isSMTP();                        // Tells PHPMailer to use SMTP instead of mail()
    $mail->Host       = 'smtp.gmail.com';   // Gmail SMTP server
    $mail->SMTPAuth   = true;               // Enables SMTP authentication
    $mail->Username   = 'niallmcpartlan93@gmail.com';  // Your Gmail address
    $mail->Password   = 'vptyexsdptzetild';            // Gmail App Password (no spaces)
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // TLS encryption for Gmail
    $mail->Port       = 587;                // TLS port for Gmail SMTP

    $mail->setFrom('niallmcpartlan93@gmail.com', 'PHPMailer Test'); // Sender email + name
    $mail->addAddress('niallmcpartlan123@gmail.com');               // Recipient email

    $mail->isHTML(true);                    // Enables HTML email formatting
    $mail->Subject = 'PHPMailer Test Email'; // Email subject line
    $mail->Body    = '<h2>If you received this, PHPMailer works!</h2>'; // Email body (HTML)

    $mail->send();                          // Attempts to send the email
    echo "Email sent successfully.";        // Success message

} catch (Exception $e) {
    echo "Email failed: {$mail->ErrorInfo}"; // Displays error message if sending fails
}
