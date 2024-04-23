<?php
// Include database connection file
include_once("connection.php");

// Function to create ZIP file from attachments for a specific academic year (acaClosure)
function createZipFile($acaClosureID) {
    global $conn;

    // Initialize ZipArchive
    $zip = new ZipArchive();
    $zipFileName = "approved_contributions_$acaClosureID.zip";

    if ($zip->open($zipFileName, ZipArchive::CREATE) === TRUE) {
        // Query to select approved contributions for the given academic year ID
        $sql = "SELECT * FROM contributions WHERE YearID = $acaClosureID AND Status = 'Approve'";
        $result = mysqli_query($conn, $sql);

        // Check if there are any approved contributions found
        if (mysqli_num_rows($result) > 0) {
            // Loop through the results and add attachments of each contribution to the ZIP archive
            while ($row = mysqli_fetch_assoc($result)) {
                $attachmentFile = './uploads/' . $row['FileP'];
                if (file_exists($attachmentFile)) {
                    $zip->addFile($attachmentFile, basename($attachmentFile));
                }
            }

            // Close the ZIP archive
            $zip->close();

            // Set appropriate headers for file download
            header('Content-Type: application/zip');
            header('Content-Disposition: attachment; filename="' . $zipFileName . '"');
            header('Content-Length: ' . filesize($zipFileName));

            // Read and output the ZIP file
            readfile($zipFileName);

            // Delete the temporary ZIP file
            unlink($zipFileName);
        } else {
            // If no approved contributions found, display an error message
            echo 'No approved contributions found for this academic year.';
        }
    } else {
        echo 'Failed to create ZIP archive.';
    }
}

// Check if academic year ID is provided via GET parameter
if (isset($_GET['YearID'])) {
    $acaClosureID = $_GET['YearID'];
    // Call the function to create ZIP file for the specified academic year
    createZipFile($acaClosureID);
} else {
    // If academic year ID is not provided, display an error message
    echo 'Academic year ID not provided.';
}
?>
