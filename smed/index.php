<?php
// Set the file path
$file = 'D:/Surge/uploads/' . $_GET['url'];

// Check if the file exists
if (file_exists($file)) {
    // Determine the MIME type based on the file extension
    $extension = pathinfo($file, PATHINFO_EXTENSION);
    $mime_type = '';
    switch (strtolower($extension)) {
        case 'mp4':
            $mime_type = 'video/mp4';
            break;
        case 'jpg':
        case 'jpeg':
            $mime_type = 'image/jpeg';
            break;
        case 'png':
            $mime_type = 'image/png';
            break;
        // Add more cases for other file types if necessary
        default:
            // Unsupported file type
            die('Unsupported file type');
    }

    // Set the appropriate Content-Type header
    header('Content-Type: ' . $mime_type);

    // Output the file
    readfile($file);
} else {
    // File not found
    http_response_code(404);
    die('File not found');
}
?>
