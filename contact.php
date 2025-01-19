<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

// Function to sanitize input
function sanitize_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate inputs
    $name = sanitize_input($_POST['name']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $subject = sanitize_input($_POST['subject']);
    $message = sanitize_input($_POST['message']);
    $gRecaptchaResponse = $_POST['g-recaptcha-response'];

    $errors = [];

    // Validate inputs
    if (empty($name)) $errors[] = "Name is required";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required";
    if (empty($subject)) $errors[] = "Subject is required";
    if (empty($message)) $errors[] = "Message is required";
    if (empty($gRecaptchaResponse)) $errors[] = "Robot verification is required";

    $secretKey = "6Lf_k7sqAAAAANoTWrOmMBCEfiEneTgDFNSHE8M8";
    $url = "https://www.google.com/recaptcha/api/siteverify";
    $data = array(
        'secret' => $secretKey,
        'response' => $gRecaptchaResponse
    );
    $options = array(
        'http' => array(
            'method' => 'POST',
            'header' => 'Content-Type: application/x-www-form-urlencoded',
            'content' => http_build_query($data)
        )
    );
    $context  = stream_context_create($options);
    $verifyResponse = file_get_contents($url, false, $context);
    $responseData = json_decode($verifyResponse);

    if ($responseData->success) {
        // Send email using PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host       = 'box5306.bluehost.com ';  // Your SMTP server
            $mail->SMTPAuth   = true;
            $mail->Username   = 'contact@whiteridgetechnologies.com';  // SMTP username
            $mail->Password   = 'X+*3YDJ(J5,e';     // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;

            // Recipients
            $mail->setFrom($email, $name);
            $mail->addAddress('contact@whiteridgetechnologies.com', 'Whiteridge Technologies');
            $mail->addReplyTo($email, $name);

            // Content
            $mail->isHTML(true);
            $mail->Subject = "Contact Form: $subject";
            $mail->Body    = "
                <h2>New Contact Form Submission</h2>
                <p><strong>Name:</strong> $name</p>
                <p><strong>Email:</strong> $email</p>
                <p><strong>Subject:</strong> $subject</p>
                <p><strong>Message:</strong><br>$message</p>
            ";
            $mail->AltBody = "Name: $name\nEmail: $email\nSubject: $subject\nMessage: $message";

            $mail->send();
            echo json_encode(['status' => 'success', 'message' => 'Message sent successfully!']);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"]);
        }
        exit;
    } else {
        echo json_encode(['status' => 'error', 'message' => "Robot verification failed. Please try again."]);
        exit;
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Whiteridge Technologies | Contact Us</title>
    <link href="styles/main.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Kumbh+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.24/sweetalert2.min.css" integrity="sha512-3UtHvf5eL6JL5TyhntJ3rJrGtjXKBhZ7BGGNMXH4XaS6yv0eC9xrCO7pThD2IvYVKE8A2uY5pNprEFKlDKGZWw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    <script src="https://www.google.com/recaptcha/api.js"></script>
</head>

<body>
    <?php include 'components/Navbar.php' ?>
    <section class="about-hero">
        <div class="about-hero-container">
            <h1>Contact Us</h1>
            <nav class="breadcrumb">
                <a href="index.php">Home</a> | <span>Contact Us</span>
            </nav>
        </div>
    </section>

    <section id="contact" class="contact-section" data-sr="fade-up">
        <div class="contact-container">
            <div class="contact-content">
                <h2>Have a Question? Contact Us!</h2>
                <p>Have a question or want to work with us? We'd love to hear from you! <br> Fill out the form below and let's connect.</p>
            </div>
        </div>
    </section>
    <section class="contact-cards">

        <div class="contact-cards-container">
            <div class="pattern-dots"></div>
            <div class="pattern-lines"></div>
            <div class="contact-card">
                <i class="fas fa-phone"></i>
                <h3>Phone</h3>
                <p>+234 814 866 2637</p>
                <p>+234 815 848 9200</p>
            </div>
            <div class="contact-card">
                <i class="fas fa-envelope"></i>
                <h3>Email</h3>
                <p>contact@whiteridgetechnologies.com</p>
            </div>
            <div class="contact-card">
                <i class="fas fa-map-marker-alt"></i>
                <h3>Address</h3>
                <p>Lagos, Nigeria
                    54B, Adeniyi Jones Avenue, Ikeja.
                </p>
            </div>
        </div>
    </section>
    <section class="map-section">

        <div class="map-container">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.125914511341!2d3.3435349999999997!3d6.596444!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x103b8e5a3b7e2e69%3A0x6b3c4b9b2e5d9b54!2s54B%2C%20Adeniyi%20Jones%20Ave%2C%20Ikeja!5e0!3m2!1sen!2sus!4v1606956153438!5m2!1sen!2sus" width="100%" height="400" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
        </div>
    </section>
    <section class="contact-form-section">
        <div class="contact-form-container">
            <div class="pattern-dots"></div>
            <div class="pattern-lines"></div>
            <div class="contact-form">
                <h2>Get in Touch</h2>
                <form id="contactForm">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" placeholder="Your Name">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Your Email">
                    </div>
                    <div class="form-group">
                        <label for="subject">Subject</label>
                        <input type="text" id="subject" name="subject" placeholder="Subject">
                    </div>
                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea id="message" name="message" placeholder="Your Message"></textarea>
                    </div>
                    <div class="form-group">
                        <div class="g-recaptcha" data-sitekey="6Lf_k7sqAAAAAAWmjGW91OSQJ7jDQEq0e04iCv6p"></div>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <span class="btn-text">Send Message</span>
                    </button>
                </form>
            </div>
        </div>
    </section>
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#contactForm').on('submit', function(e) {
                e.preventDefault();

                // Add loading state to button
                var $submitBtn = $(this).find('button[type="submit"]');
                $submitBtn.addClass('btn-loading');
                $submitBtn.prop('disabled', true);

                // Collect form data
                var formData = $(this).serialize();

                $.ajax({
                    type: 'POST',
                    url: 'contact.php',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Message Sent!',
                                text: response.message
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: response.message
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An unexpected error occurred.'
                        });
                    },
                    complete: function() {
                        // Remove loading state from button
                        $submitBtn.removeClass('btn-loading');
                        $submitBtn.prop('disabled', false);
                    }
                });
            });
        });
    </script>
    <?php include 'components/Footer.php'; ?>

</body>

</html>