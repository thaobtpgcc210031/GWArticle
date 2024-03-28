<?php
include_once("connection.php");

$sql = "SELECT FileP FROM contributions ORDER BY ContributionID DESC LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of the last uploaded image
    $row = $result->fetch_assoc();
    $file = $row["FileP"];

    // Send the appropriate headers for image download
    header("Content-Disposition: attachment; filename=" . basename($file));
    header("Content-Type: application/octet-stream");
    header("Content-Length: " . filesize($file));

    // Output the image content
    readfile($file);
} else {
    echo "Image not found.";
}

// Close database connection
$conn->close();
?>
