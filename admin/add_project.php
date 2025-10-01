<?php


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit;
}
include '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $desc  = $_POST['description'];
    $link  = $_POST['link'];
    $image = $_FILES['image']['name'];
    $target = "../assets/img/" . basename($image);

    if ($image) move_uploaded_file($_FILES['image']['tmp_name'], $target);

    $stmt = $pdo->prepare("INSERT INTO projects (title, description, image, link) VALUES (?, ?, ?, ?)");
    $stmt->execute([$title, $desc, $image, $link]);

    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Project</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
    <h1>Add Project</h1>
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="Title" required><br>
        <textarea name="description" placeholder="Description"></textarea><br>
        <input type="file" name="image"><br>
        <input type="text" name="folder" placeholder="Project Folder Name (e.g., project1)">
        <input type="text" name="link" placeholder="Project Link (optional)">

        <input type="text" name="github" placeholder="GitHub Repo URL (optional)">

        <button type="submit">Save</button>
    </form>
</body>
</html>
