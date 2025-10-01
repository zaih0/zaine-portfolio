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
  <h1 class="pixel-title">
  <span id="typed-text"></span><span id="cursor">▋</span>
</h1>
  <nav>
    <a href="#projects">Projects</a>
    <a href="#about">About</a>
    <a href="#skills">Skills</a>
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
    <div class="npc-container">
      <img src="assets/img/link-pixel-art-unscreen.gif" alt="Quest Giver" class="npc-avatar">
      <div class="quest-icon">!</div>
    </div>
    <div class="dialogue hidden" id="dialogueBox">
      <p>“Greetings traveler… I am the keeper of code and builder of digital worlds.  
      Through quests of JavaScript, PHP, Unity, and beyond, I forge projects to challenge and inspire.  
      Should you seek knowledge, browse my works. Should you seek an ally, contact me.”</p>
    </div>
  </div>
</section>


<script>
document.addEventListener("DOMContentLoaded", function() {
  const icon = document.querySelector(".quest-icon");
  const dialogue = document.getElementById("dialogueBox");
  icon.addEventListener("click", function() {
    dialogue.classList.toggle("hidden");
  });
});
</script>
<script>
document.addEventListener("DOMContentLoaded", () => {
  const bars = document.querySelectorAll(".exp-fill");

  function animateBars() {
    bars.forEach(bar => {
      const width = bar.getAttribute("style").match(/width:\s*(\d+)%/)[1];
      bar.style.width = "0%"; // reset
      setTimeout(() => {
        bar.style.width = width + "%";
      }, 200);
    });
  }

  // Trigger when section enters viewport
  const observer = new IntersectionObserver(entries => {
    if (entries[0].isIntersecting) {
      animateBars();
    }
  }, { threshold: 0.5 });

  observer.observe(document.querySelector("#skills"));
});
</script>


<!-- Skills -->
<section id="skills" class="skills-section">
  <h2 class="section-title">📜 Skills & Languages</h2>
  <div class="skills-container">

    <div class="skill">
      <span class="skill-name">⚔️ JavaScript</span>
      <div class="exp-bar">
        <div class="exp-fill" style="width: 50%;"></div>
      </div>
    </div>

    <div class="skill">
      <span class="skill-name">🛡️ PHP</span>
      <div class="exp-bar">
        <div class="exp-fill" style="width: 70%;"></div>
      </div>
    </div>

    <div class="skill">
      <span class="skill-name">🧙 Python</span>
      <div class="exp-bar">
        <div class="exp-fill" style="width: 96%;"></div>
      </div>
    </div>

    <div class="skill">
      <span class="skill-name">🏰 HTML/CSS</span>
      <div class="exp-bar">
        <div class="exp-fill" style="width: 95%;"></div>
      </div>
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

      $to = "zaine.horn100@gmail.com"; // CHANGE THIS
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
  <p>&copy; <?= date('Y') ?> Zaine Dev | Project Portfolio</p>
</footer>

<script>
document.addEventListener("DOMContentLoaded", function() {
  const text = "👾 Zaine Dev Portfolio 👾"; // your title
  const typedText = document.getElementById("typed-text");
  const cursor = document.getElementById("cursor");
  let index = 0;

  function type() {
    if (index < text.length) {
      typedText.textContent += text.charAt(index);
      index++;
      setTimeout(type, 100); // adjust typing speed
    } else {
      cursor.style.display = "inline-block"; // keep cursor blinking
    }
  }

  type();
});
</script>


</body>
</html>
