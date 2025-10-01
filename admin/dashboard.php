<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="admin.css">
</head>
<body>
  <div class="dashboard">
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['admin']); ?>!</h1>
    <p>You are logged into the admin dashboard.</p>
    <a href="logout.php">Logout</a>
  </div>
</body>
</html>
