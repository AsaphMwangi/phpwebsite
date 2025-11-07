<?php
require_once 'vendor/autoload.php'; // include Brevo SDK

use Brevo\Client\Api\TransactionalEmailsApi;
use Brevo\Client\Configuration;
use Brevo\Client\Model\SendSmtpEmail;

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = htmlspecialchars($_POST['first-name']);
    $lastName  = htmlspecialchars($_POST['last-name']);
    $email     = htmlspecialchars($_POST['email']);
    $phone     = htmlspecialchars($_POST['phone-number']);
    $subject   = htmlspecialchars($_POST['_subject']);
    $message   = htmlspecialchars($_POST['message']);

    // Configure Brevo client with your API key
    $config = Configuration::getDefaultConfiguration()->setApiKey('api-key', 'pcTBLxXEaYkNzrC4');
    $apiInstance = new TransactionalEmailsApi(new GuzzleHttp\Client(), $config);

    // Create email object
    $sendSmtpEmail = new SendSmtpEmail([
        'subject' => "📩 New Message: $subject",
        'sender' => [
            'name' => 'Website Contact Form',
            'email' => 'asaphmwangi1973@gmail.com' // must be verified in Brevo
        ],
        'to' => [
            ['email' => 'asaphmwangi1973@gmail.com', 'name' => 'Asaph Maina']
        ],
        'replyTo' => [
            'email' => $email,
            'name' => "$firstName $lastName"
        ],
        'htmlContent' => "
            <h2>New Contact Form Submission</h2>
            <p><strong>First Name:</strong> $firstName</p>
            <p><strong>Last Name:</strong> $lastName</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Phone:</strong> $phone</p>
            <p><strong>Message:</strong><br>$message</p>
        ",
        'textContent' => "From: $firstName $lastName ($email)\nPhone: $phone\n\n$message"
    ]);

    try {
        $result = $apiInstance->sendTransacEmail($sendSmtpEmail);
        echo "✅ Message sent successfully!";
    } catch (Exception $e) {
        echo '❌ Email could not be sent. Error: ', $e->getMessage();
    }
}
?>
