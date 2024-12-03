<?php
// Allow CORS
header("Access-Control-Allow-Origin: *"); // Allows all origins; replace * with specific origin if needed
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Handle preflight requests
if ($_SERVER["REQUEST_METHOD"] == "OPTIONS") {
    http_response_code(200);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $comments = isset($_POST['comments']) ? $_POST['comments'] : '';
    $to = isset($_POST['recipient']) ? $_POST['recipient'] : '';

    // Custom 'From' header passed via POST
    $from = isset($_POST['from']) ? $_POST['from'] : 'noreply@yourdomain.com';

    // Validate email addresses
    if (!filter_var($to, FILTER_VALIDATE_EMAIL) || !filter_var($from, FILTER_VALIDATE_EMAIL) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email address in one or more fields.";
        exit;
    }

    $subject = "Feedback from Website";

    // Email content
    $message = "Name: $name\n";
    $message .= "Email: $email\n";
    $message .= "Comments:\n$comments\n";

    // Email headers
    $headers = "From: $from\r\n";
    $headers .= "Reply-To: $email\r\n"; // Automatically sets Reply-To to the user-provided email
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Set the timezone
    date_default_timezone_set('Asia/Singapore'); // Adjust to your timezone

    // Send email
    if (mail($to, $subject, $message, $headers)) {
        echo "Feedback sent!";
    } else {
        echo "Error: Feedback could not be sent.";
    }
}
?>
