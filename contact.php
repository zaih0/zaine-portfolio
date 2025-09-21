<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Me</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="contact-page">

    <div class="container">
        <h1 class="pixel-title">Contact the Developer</h1>
        <p class="pixel-subtitle">Send your message through the quest scroll below</p>

        <form method="POST" action="contact.php" class="pixel-form">
            <label>Name:</label>
            <input type="text" name="name" required>

            <label>Email:</label>
            <input type="email" name="email" required>

            <label>Message:</label>
            <textarea name="message" rows="5" required></textarea>

            <button type="submit" name="send">Send Message</button>
        </form>

        <?php
        if (isset($_POST['send'])) {
            $name = htmlspecialchars($_POST['name']);
            $email = htmlspecialchars($_POST['email']);
            $message = htmlspecialchars($_POST['message']);

            // Save to database
            $stmt = $pdo->prepare("INSERT INTO messages (name, email, message) VALUES (?, ?, ?)");
            $stmt->execute([$name, $email, $message]);

            // Send email (make sure mail() is configured on Plesk)
            $to = "your@email.com";  // CHANGE THIS
            $subject = "New Message from $name";
            $body = "Name: $name\nEmail: $email\n\n$message";
            $headers = "From: $email";

            if (mail($to, $subject, $body, $headers)) {
                echo "<p class='success'>📜 Your message has been sent!</p>";
            } else {
                echo "<p class='error'>⚠️ Message could not be sent. Try again later.</p>";
            }
        }
        ?>
    </div>

</body>
</html>
