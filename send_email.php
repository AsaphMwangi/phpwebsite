<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer files manually
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = htmlspecialchars($_POST['first-name']);
    $lastName  = htmlspecialchars($_POST['last-name']);
    $email     = htmlspecialchars($_POST['email']);
    $phone     = htmlspecialchars($_POST['phone-number']);
    $subject   = htmlspecialchars($_POST['_subject']);
    $message   = htmlspecialchars($_POST['message']);

    $mail = new PHPMailer(true);

    try {
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host       = 'smtp-relay.brevo.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = '9aeb9d001@smtp-brevo.com'; 
        $mail->Password   = 'pcTBLxXEaYkNzrC4';           
        $mail->SMTPSecure = 'tls';                        
        $mail->Port       = 587;                            

        // Sender and recipient settings
        $mail->setFrom('asaphmwangi1973@gmail.com>', 'Website Contact Form');
        $mail->addAddress('asaphmwangi1973@gmail.com', 'Admin'); // Recipient
        $mail->addReplyTo($email, "$firstName $lastName");   // Reply to sender

        // Email content
        $mail->isHTML(true);
        $mail->Subject = "📩 New Message: " . $subject;
        $mail->Body    = "
            <h2>New Contact Form Submission</h2>
            <p><strong>First Name:</strong> $firstName</p>
            <p><strong>Last Name:</strong> $lastName</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Phone:</strong> $phone</p>
            <p><strong>Message:</strong><br>$message</p>
        ";

        // Send the email
        $mail->send();
        echo "✅ Message sent successfully!";
    } catch (Exception $e) {
        echo "❌ Message could not be sent. Error: {$mail->ErrorInfo}";
    }
}
?>
