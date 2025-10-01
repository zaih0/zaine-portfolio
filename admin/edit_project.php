<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit;
}
include '../config.php';

$id = $_GET['id'] ?? null;
if (!$id) { header("Location: dashboard.php"); exit; }

$stmt = $pdo->prepare("SELECT * FROM projects WHERE id = ?");
$stmt->execute([$id]);
$project = $stmt->fetch();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $desc  = $_POST['description'];
    $link  = $_POST['link'];
    $image = $project['image'];

    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "../assets/img/" . $image);
    }

    $stmt = $pdo->prepare("UPDATE projects SET title=?, description=?, image=?, link=? WHERE id=?");
    $stmt->execute([$title, $desc, $image, $link, $id]);

    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Project</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
    <h1>Edit Project</h1>
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="title" value="<?= htmlspecialchars($project['title']) ?>" required><br>
        <textarea name="description"><?= htmlspecialchars($project['description']) ?></textarea><br>
        <input type="text" name="link" value="<?= htmlspecialchars($project['link']) ?>"><br>
        <p>Current Image: <img src="../assets/img/<?= $project['image'] ?>" width="100"></p>
        <input type="file" name="image"><br>
        <button type="submit">Update</button>
    </form>
</body>
</html>
