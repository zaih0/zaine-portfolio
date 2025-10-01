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
  <a href="logout.php">Logout</a> | 
  <a href="add_project.php">Add New Project</a>

  <h2>Projects</h2>
  <table border="1" cellpadding="10">
    <tr>
      <th>Title</th>
      <th>Description</th>
      <th>Image</th>
      <th>Link</th>
      <th>Actions</th>
    </tr>
    <?php
      include '../config.php';
      $stmt = $pdo->query("SELECT * FROM projects ORDER BY id DESC");
      while ($project = $stmt->fetch()):
    ?>
      <tr>
        <td><?= htmlspecialchars($project['title']) ?></td>
        <td><?= htmlspecialchars($project['description']) ?></td>
        <td>
          <?php if ($project['image']): ?>
            <img src="../assets/img/<?= $project['image'] ?>" width="100">
          <?php else: ?>
            No image
          <?php endif; ?>
        </td>
        <td><a href="<?= htmlspecialchars($project['link']) ?>" target="_blank">View</a></td>
        <td>
          <a href="edit_project.php?id=<?= $project['id'] ?>">Edit</a> |
          <a href="delete.php?id=<?= $project['id'] ?>" onclick="return confirm('Are you sure you want to delete this project?');">Delete</a>
        </td>
      </tr>
    <?php endwhile; ?>
  </table>
</div>

</body>
</html>
