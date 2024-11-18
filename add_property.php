<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    
    // Handle image upload
    $image_path = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image_path = 'uploads/' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $image_path);
    }

    // Save to database
    $stmt = $conn->prepare("INSERT INTO properties (title, description, price, image_url) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssds", $title, $description, $price, $image_path);
    $stmt->execute();

    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Property</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Add New Property</h1>
    <form method="POST" enctype="multipart/form-data">
    <label>Title:</label><br>
    <input type="text" name="title" required><br><br>
    <label>Description:</label><br>
    <textarea name="description" required></textarea><br><br>
    <label>Price:</label><br>
    <input type="number" name="price" step="0.01" required><br><br>
    <label>Image:</label><br>
    <input type="file" name="image" accept="image/*"><br><br>
    <button type="submit">Add Property</button>
</form>
</body>
</html>
