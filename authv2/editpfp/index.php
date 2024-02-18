<?php
$myURL = '/authv2/editpfp'; //URL of this script.
if(isset($_GET['token'])){
    header('location: ?');
    die();
}
if(isset($_COOKIE['surge-token'])){
$rawToken=$_COOKIE['surge-token'];
$username=explode(',,!!,,',$rawToken)[0];
$token=explode(',,!!,,',$rawToken)[1];
$dbFilePath = 'D:/Surge/Surge.accdb';

try {
    $dsn = "odbc:Driver={Microsoft Access Driver (*.mdb, *.accdb)};Dbq=$dbFilePath";
    $pdo = new PDO($dsn);

    // Set PDO attributes
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Example query
    $query = "SELECT * FROM Users";
    $statement = $pdo->query($query);

    // Fetch data
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
       if($row['Username']==$username){
           $displayname=$row['DisplayName'];
        if($token!==$row['AccessToken']){
            header('location: /authv2/?forward='.$myURL);
            die();
        }
       }
    }
} catch (PDOException $e) {
    // Handle database connection errors
    die("Database Connection failed: " . $e->getMessage());
}
}else{
    header('location: /authv2/?forward='.$myURL);
    die();
}
?><?php
if(isset($_GET['set'])){
    
if(isset($_FILES['profile-picture'])) {
    // Custom location to save the file
    $target_dir = "C:/xampp/htdocs/userv2/".$username.'/';
    $target_file = $target_dir . basename($_FILES["profile-picture"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    
    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["profile-picture"]["tmp_name"]);
    if($check !== false) {
        // Check file size
        if ($_FILES["profile-picture"]["size"] > 5000000) {
            echo "Sorry, your file is too large.";
        } else {
            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            } else {
                if (move_uploaded_file($_FILES["profile-picture"]["tmp_name"], $target_file)) {
                    // Successfully uploaded, now re-render the image
                    $image = imagecreatefromstring(file_get_contents($target_file));
                    $textColor = imagecolorallocate($image, 255, 255, 255);
                    $watermark = imagecreatefrompng('C:/xampp/htdocs/media/watermark.png'); // Path to your watermark image
                   
                    $text = "surgeme.xyz - @".$username;
                    $resizedImage = imagescale($image, 200, 200);
                    imagecopy($resizedImage, $watermark, 5, imagesy($resizedImage) - imagesy($watermark) - 15, 0, 0, imagesx($watermark), imagesy($watermark));
                    imagestring($resizedImage, 1, 5, 190,  $text , $textColor); // Add text
                    // Scale image to 200x200px
                    imagepng($resizedImage, $target_dir . 'pfp.png'); // Save the output as gif
                    imagedestroy($image);
                    imagedestroy($resizedImage);
                    unlink($target_file);
                    if(isset($_GET['forward'])){
                        header('location: '.$_GET['forward']);
                        die();
                    }else{
            
                        die('<!DOCTYPE html>
                        <html lang="en">
                        <head>
                            <meta charset="UTF-8">
                            <meta name="viewport" content="width=device-width, initial-scale=1.0">
                            <title>Profile Picture Changed Successfully</title>
                            <style>
                                body {
                                    font-family: Arial, sans-serif;
                                    background-color: #f4f4f4;
                                    margin: 0;
                                    padding: 0;
                                    display: flex;
                                    justify-content: center;
                                    align-items: center;
                                    height: 100vh;
                                }
                                .success-message {
                                    background-color: #4CAF50;
                                    color: white;
                                    padding: 20px;
                                    border-radius: 5px;
                                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                                }
                            </style>
                        </head>
                        <body>
                            <div class="success-message">
                                <h2>Profile Picture Changed Successfully</h2>
                            </div>
                        </body>
                        </html>
                        ');
                    }
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
        }
    } else {
        echo "File is not an image.";
    }
}
die();
}
?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Change Profile Picture</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    #preview-image {
      width:150px;
      height:150px;
      margin-top: 10px;
      animation-play-state: paused;

    }
  </style>
</head>
<body>
  <div class="container mt-5">
    <div class="row">
      <div class="col-md-6 offset-md-3">
        <div class="card">
          <div class="card-header">
            <h3 class="text-center">Change Profile Picture</h3>
          </div>
          <div class="card-body">
            <form action="?set<?php if(isset($_GET['forward'])){echo '&forward='.$_GET['forward'];} ?>" method="post" enctype="multipart/form-data">
              <div class="form-group">
                <label for="profile-picture">Choose Picture:</label>
                <input required type="file" class="form-control-file" id="profile-picture" name="profile-picture" onchange="previewImage(event)" accept='.png,.jpg,.jpeg,.gif'>
              </div>
              <div class="text-center">
                <img id="preview-image"  >
              </div>
              <button type="submit" class="btn btn-primary btn-block mt-3">Upload Picture</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <script>
    function previewImage(event) {
      var reader = new FileReader();
      reader.onload = function(){
        var output = document.getElementById('preview-image');
        output.src = reader.result;
      }
      reader.readAsDataURL(event.target.files[0]);
    }
  </script>
</body>
</html>
