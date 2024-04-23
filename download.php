<?php
// Check if the file parameter is set in the URL
if(isset($_GET['file'])) {
    // Get the file name from the URL
    $file = $_GET['file'];
    
    // Set the path to the file
    $filepath = './uploads' . $file;

    // Check if the file exists
    if(file_exists($filepath)) {
        // Set appropriate headers for file download
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($filepath));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filepath));
        ob_clean();
        flush();
        
        // Read the file and output it to the browser
        readfile($filepath);
        exit;
    } else {
        // If the file doesn't exist, display an error message
        echo 'File not found.';
    }
} else {
    // If the file parameter is not set in the URL, display an error message
    echo 'Invalid request.';
}
?>
