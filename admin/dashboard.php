<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../login.php");
    exit;
}
include '../config.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
    <h1>Admin Dashboard</h1>
    <a href="add_project.php">➕ Add New Project</a> | 
    <a href="../logout.php">🚪 Logout</a>
    <hr>

    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th><th>Title</th><th>Description</th><th>Image</th><th>Link</th><th>Actions</th>
        </tr>
        <?php
        $stmt = $pdo->query("SELECT * FROM projects ORDER BY created_at DESC");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['title']}</td>
                <td>" . substr($row['description'], 0, 50) . "...</td>
                <td><img src='../assets/img/{$row['image']}' width='80'></td>
                <td><a href='{$row['link']}' target='_blank'>Link</a></td>
                <td>
                    <a href='edit_project.php?id={$row['id']}'>✏️ Edit</a> | 
                    <a href='delete_project.php?id={$row['id']}' onclick='return confirm(\"Delete this project?\")'>❌ Delete</a>
                </td>
            </tr>";
        }
        ?>
    </table>
</body>
</html>
