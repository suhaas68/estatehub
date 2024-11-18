<?php
include 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare and execute the delete query
    $stmt = $conn->prepare("DELETE FROM properties WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: index.php?message=Property deleted successfully");
        exit();
    } else {
        echo "Error deleting property: " . $conn->error;
    }
} else {
    header("Location: index.php?error=Invalid request");
    exit();
}
?>
