<?php
$mobile = false;
if (isset($_SERVER['HTTP_HOST'])) {
    $host = $_SERVER['HTTP_HOST'];
    $subdomain = explode('.', $host)[0];

    if ($subdomain === 'm') {
        $mobile = true;
    }
}

// Check if the request has the necessary parameters
if (isset($_GET['user']) && isset($_GET['width']) && isset($_GET['height']) && isset($_GET['type']) && isset($_GET['quality'])) {

    // Get the parameters from the URL
    $imgName = $_GET['user'].'/pfp.png';
    if($_GET['user']=='removeduser'){
        $imgName = 'gone.png';
    }
    $width = $_GET['width'];
    $height = $_GET['height'];
    $type = $_GET['type'];
    $quality = $_GET['quality'];

    // Check if the crop parameter is set
    $crop = isset($_GET['crop']);

    // Define the path to your custom folder
    $customFolder = 'C:/xampp/htdocs/userv2/';

    // Check if the file exists
    if (file_exists($customFolder . $imgName)) {

        // Load the original image with alpha channel support
        $originalImage = imagecreatefrompng($customFolder . $imgName);
        imagesavealpha($originalImage, true);

        // Create a blank image with the specified width and height and alpha channel support
        $resizedImage = imagecreatetruecolor($width, $height);
        imagesavealpha($resizedImage, true);

        // Set the alpha channel for the resized image
        $transparentColor = imagecolorallocatealpha($resizedImage, 0, 0, 0, 127);
        imagefill($resizedImage, 0, 0, $transparentColor);

        if ($crop) {
            // Crop the original image to the center
            $cropX = max(0, (imagesx($originalImage) - $width) / 2);
            $cropY = max(0, (imagesy($originalImage) - $height) / 2);
            imagecopyresampled($resizedImage, $originalImage, 0, 0, $cropX, $cropY, $width, $height, $width, $height);
        } else {
            // Resize the original image to the specified dimensions without cropping
            imagecopyresampled($resizedImage, $originalImage, 0, 0, 0, 0, $width, $height, imagesx($originalImage), imagesy($originalImage));
        }

        // Output the image in the desired type and quality
        header('Content-Type: image/' . $type);
        switch ($type) {
            case 'jpeg':
                imagejpeg($resizedImage, null, $quality);
                break;
            case 'png':
                imagepng($resizedImage, null, $quality / 100 * 9);
                break;
            case 'webp':
                imagewebp($resizedImage, null, $quality);
                break;
            default:
                // Invalid image type
                header("HTTP/1.1 400 Bad Request");
                echo "<error>Invalid image type</error>";
                exit;
        }

        // Free up memory
        imagedestroy($originalImage);
        imagedestroy($resizedImage);

    } else {

        // Load the original image with alpha channel support
        $originalImage = imagecreatefrompng('C:/xampp/htdocs/media/user.png');
        imagesavealpha($originalImage, true);

        // Create a blank image with the specified width and height and alpha channel support
        $resizedImage = imagecreatetruecolor($width, $height);
        imagesavealpha($resizedImage, true);

        // Set the alpha channel for the resized image
        $transparentColor = imagecolorallocatealpha($resizedImage, 0, 0, 0, 127);
        imagefill($resizedImage, 0, 0, $transparentColor);

        if ($crop) {
            // Crop the original image to the center
            $cropX = max(0, (imagesx($originalImage) - $width) / 2);
            $cropY = max(0, (imagesy($originalImage) - $height) / 2);
            imagecopyresampled($resizedImage, $originalImage, 0, 0, $cropX, $cropY, $width, $height, $width, $height);
        } else {
            // Resize the original image to the specified dimensions without cropping
            imagecopyresampled($resizedImage, $originalImage, 0, 0, 0, 0, $width, $height, imagesx($originalImage), imagesy($originalImage));
        }

        // Output the image in the desired type and quality
        header('Content-Type: image/' . $type);
        switch ($type) {
            case 'jpeg':
                imagejpeg($resizedImage, null, $quality);
                break;
            case 'png':
                imagepng($resizedImage, null, $quality / 100 * 9);
                break;
            case 'webp':
                imagewebp($resizedImage, null, $quality);
                break;
            default:
                // Invalid image type
                header("HTTP/1.1 400 Bad Request");
                echo "<error>Invalid image type</error>";
                exit;
        }

        // Free up memory
        imagedestroy($originalImage);
        imagedestroy($resizedImage);
        exit;
    }
} else {
    // Missing parameters
    header("HTTP/1.1 400 Bad Request");
    echo "<error>Missing parameters</error>";
    exit;
}
?>
