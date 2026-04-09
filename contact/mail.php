<?php

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Get and sanitize form data
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $phone = isset($_POST['telephone']) ? trim($_POST['telephone']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $subject = isset($_POST['subject']) ? trim($_POST['subject']) : '';
    $message = isset($_POST['message']) ? trim($_POST['message']) : '';
    
    // Validate required fields
    if (empty($name)) {
        die(json_encode(array('type' => 'error', 'field' => 'name', 'message' => 'Please enter your name')));
    }
    
    if (empty($email)) {
        die(json_encode(array('type' => 'error', 'field' => 'email', 'message' => 'Please enter your email')));
    }
    
    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die(json_encode(array('type' => 'error', 'field' => 'email', 'message' => 'Please enter a valid email address')));
    }
    
    if (empty($message)) {
        die(json_encode(array('type' => 'error', 'field' => 'message', 'message' => 'Please enter your message')));
    }
    
    // Prepare email
    $to = 'info@zeeqtech.com';
    $email_subject = !empty($subject) ? 'New Contact: ' . htmlspecialchars($subject) : 'New Contact Form Submission';
    
    // Build email body
    $email_body = "You have received a new contact form submission.\n\n";
    $email_body .= "Name: " . htmlspecialchars($name) . "\n";
    $email_body .= "Email: " . htmlspecialchars($email) . "\n";
    if (!empty($phone)) {
        $email_body .= "Phone: " . htmlspecialchars($phone) . "\n";
    }
    if (!empty($subject)) {
        $email_body .= "Subject: " . htmlspecialchars($subject) . "\n";
    }
    $email_body .= "\nMessage:\n";
    $email_body .= htmlspecialchars($message) . "\n\n";
    $email_body .= "---\n";
    $email_body .= "This email was sent from your website contact form at " . date('Y-m-d H:i:s');
    
    // Set headers
    $headers = "From: " . htmlspecialchars($email) . "\r\n";
    $headers .= "Reply-To: " . htmlspecialchars($email) . "\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    
    // Send email
    $mail_sent = mail($to, $email_subject, $email_body, $headers);
    
    if ($mail_sent) {
        return die(json_encode(array('type' => 'success', 'message' => 'Your message has been sent successfully. We will get back to you as soon as possible.')));
    }
    return die(json_encode(array('type' => 'error', 'field' => '', 'message' => 'Sorry, there was an error sending your message. Please try again.')));
    
} 
return die(json_encode(array('type' => 'error', 'field' => '', 'message' => 'Invalid request')));

