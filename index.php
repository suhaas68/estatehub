<?php
include 'config.php';

// Fetch all properties from the database
$result = $conn->query("SELECT * FROM properties ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Estate Agency</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Available Properties</h1>
    </header>
    <div class="container">
        <a href="add_property.php" class="add-btn">Add New Property</a>
        <hr>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($property = $result->fetch_assoc()): ?>
            <div class="property-card">
                <h2><?php echo htmlspecialchars($property['title']); ?></h2>
                <p><?php echo htmlspecialchars(substr($property['description'], 0, 100)); ?>...</p>
                <p class="price">Price: $<?php echo number_format($property['price'], 2); ?></p>
                
                <?php 
                // Handle image display logic
                $image_url = $property['image_url'];

                // Check if image URL is an external link or a local file path
                if (!empty($image_url)) {
                    if (filter_var($image_url, FILTER_VALIDATE_URL)) { 
                        // External image URL
                        echo '<img src="' . htmlspecialchars($image_url) . '" alt="Property Image" width="200">';
                    } elseif (file_exists($image_url)) { 
                        // Local image file
                        echo '<img src="' . htmlspecialchars($image_url) . '" alt="Property Image" width="200">';
                    } else {
                        echo".";
                    }
                } else {
                    echo".";
                }
                ?>
                
                <br>
                <a href="view_property.php?id=<?php echo $property['id']; ?>" class="view-btn">View Details</a>
                <a href="delete_property.php?id=<?php echo $property['id']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this property?');">Delete</a>
            </div>
            <hr>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No properties found. Add a new property using the link above.</p>
        <?php endif; ?>
    </div>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Estate Agency. All rights reserved.</p>
    </footer>
</body>
</html>
