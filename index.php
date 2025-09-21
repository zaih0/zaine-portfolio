<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Pixel Portfolio</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <style>
    html {
      scroll-behavior: smooth;
    }
  </style>
</head>
<body class="main-bg">

<header>
  <h1 class="pixel-title">👾 My Legendary Portfolio 👾</h1>
  <nav>
    <a href="#projects">Projects</a>
    <a href="#about">About</a>
    <a href="#contact">Contact</a>
  </nav>
</header>

<!-- Projects Section -->
<section id="projects" class="projects">
  <h2 class="section-title">🔮 Projects</h2>
  <div class="project-grid">
  <?php
  $stmt = $pdo->query("SELECT * FROM projects ORDER BY created_at DESC");
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $projectPath = !empty($row['folder']) ? "projects/{$row['folder']}/index.html" : "#";
      $githubLink = !empty($row['github']) ? $row['github'] : "";
      echo "
      <div class='project-card'>
          <img src='assets/img/{$row['image']}' alt='{$row['title']}'>
          <h3>{$row['title']}</h3>
          <p>{$row['description']}</p>
          <div class='project-buttons'>
              ".(!empty($row['folder']) ? "<a href='$projectPath' target='_blank'>View Project</a>" : "")."
              ".(!empty($githubLink) ? "<a href='$githubLink' target='_blank'>GitHub</a>" : "")."
          </div>
      </div>
      ";
  }
  ?>
  </div>
</section>

<!-- About Section -->
<section id="about" class="quest-box">
  <h2 class="section-title">🧙 About Me</h2>
  <div class="quest-content">
    <img src="assets/img/sample1.jpg" alt="Quest Giver" class="npc-avatar">
    <div class="dialogue">
      <p>“Greetings traveler… I am the keeper of code and builder of digital worlds.  
      Through quests of JavaScript, PHP, Unity, and beyond, I forge projects to challenge and inspire.  
      Should you seek knowledge, browse my works. Should you seek an ally, contact me.”</p>
    </div>
  </div>
</section>

<!-- Contact Section -->
<section id="contact" class="contact-box">
  <h2 class="section-title">📜 Contact Me</h2>
  <form method="POST" action="#contact" class="pixel-form">
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

      $stmt = $pdo->prepare("INSERT INTO messages (name, email, message) VALUES (?, ?, ?)");
      $stmt->execute([$name, $email, $message]);

      $to = "your@email.com"; // CHANGE THIS
      $subject = "New Message from $name";
      $body = "Name: $name\nEmail: $email\n\n$message";
      $headers = "From: $email";

      if (mail($to, $subject, $body, $headers)) {
          echo "<p class='success'>📜 Your message has been sent!</p>";
      } else {
          echo "<p class='error'>⚠️ Message could not be sent.</p>";
      }
  }
  ?>
</section>

<footer>
  <p>&copy; <?= date('Y') ?> My Portfolio | Retro Pixel Edition</p>
</footer>
</body>
</html>
