<?php
$myURL = '/home'; //URL of this script.
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
} if(!isset($displayname)){
            header('location: /authv2/?forward='.$myURL);
            die();
        }
?><?php    $filePaths = [];
$medias=[];
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the post text
    $postText = isset($_POST['postText']) ? $_POST['postText'] : '';

    // Array to store file paths
    $filePaths = [];
    $ups = 0;

    function getup(){
        global $ups; // Access the global variable $ups
        return $ups;
    }
    
    function addup(){
        global $ups; // Access the global variable $ups
        $ups = $ups + 1;
    }
    
    // Function to handle file upload
    function handleFileUpload($file) {
        addup();
        if(getup()>6){
            header('location: /home');
            die();
        }
        // Allowed file types
        $allowedTypes = ['image/webp','image/gif', 'image/png', 'image/jpeg', 'video/mp4', 'video/webm'];

        // Maximum file size (50MB)
        $maxFileSize = 50 * 1024 * 1024;

        // File details
        $fileTmpName = $file['tmp_name'];
        $fileType = $file['type'];
        $fileError = $file['error'];
        $fileSize = $file['size'];
        $fileName = str_replace(' ','-',$file['name']);

        // Check if file is of allowed type and size
        if ($fileError === 0 && in_array($fileType, $allowedTypes) && $fileSize <= $maxFileSize) {
            // Generate unique file name to prevent overwrite
            $uniqueFileName = date('m.d.y-H.i.s'). '_'.uniqid() . '_' . $fileName;
            $fileDestination = 'D:/Surge/uploads/' . $uniqueFileName;

            // Move file to destination
            if (move_uploaded_file($fileTmpName, $fileDestination)) {
                $filePath=$fileDestination;
            //    array_push($filePath,$filePaths);
                      if($fileType=='image/gif'){
                    $nfilePath = $filePath;
                    $nfilePath = str_replace('D:/Surge/uploads/', '', $nfilePath);
                    $nfilePath = 'D:/Surge/uploads/aft_' . $nfilePath;
                    copy($fileDestination, $nfilePath);
                }
                return $fileDestination;
            }
        }
        return false;
    }

    // Check if single file is uploaded
    if (!empty($_FILES['postFiles']['name'])) {
        // Handle single file upload
        $filePaths[] = handleFileUpload($_FILES['postFiles']);
    }// Check if multiple files are uploaded
if (!empty($_FILES['postFiles']['name'][0])) {
    // Handle multiple files upload
    foreach ($_FILES['postFiles']['name'] as $key => $name) {
        $file = [
            'name' => $_FILES['postFiles']['name'][$key],
            'type' => $_FILES['postFiles']['type'][$key],
            'tmp_name' => $_FILES['postFiles']['tmp_name'][$key],
            'error' => $_FILES['postFiles']['error'][$key],
            'size' => $_FILES['postFiles']['size'][$key]
        ];
        $filePaths[] = handleFileUpload($file);
    }
}

array_filter($filePaths);array_shift($filePaths);
function isVideo($file) {
    $allowedVideoTypes = array(
        'video/mp4',
        'video/mpeg',
        'video/quicktime',
        'video/webm', // WebM video format
        // Add more video MIME types as needed
    );

    // Check if the file exists before using finfo_file
    if (file_exists($file)) {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($finfo, $file);
        finfo_close($finfo);

        return in_array($mime_type, $allowedVideoTypes);
    }

    return false;
}


    foreach ($filePaths as $filePath) {
    
        //aft_
if(isVideo($filePath)){
//vid

// Define file paths
$inputVideo = $filePath;
$nfilePath = $filePath;
$nfilePath = str_replace('D:/Surge/uploads/', '', $nfilePath);
$nfilePath = 'D:/Surge/uploads/aft_' . $nfilePath;
$outputVideo = $nfilePath;
$watermarkImage = 'C:/xampp/htdocs/media/watermark.png';

// Define watermark text
$watermarkText = 'surgeme.xyz - @'.$username;
$ffmpegCommand = "C:/ffmpeg/ffmpeg.exe -i $inputVideo -i $watermarkImage ";
$ffmpegCommand .= "-filter_complex \"[0:v][1:v]overlay=10:main_h-overlay_h-10:format=auto,";
$ffmpegCommand .= "drawtext=text='$watermarkText':x=45:y=main_h-30:fontsize=15:fontfile=Roboto-Regular.ttf:fontcolor=white\" -c:v libx264 -profile:v baseline -preset fast -crf 23 -pix_fmt yuv420p -acodec libaac -b:a 128k -c:a aac -b:a 128k -movflags +faststart ";
$ffmpegCommand .= "$outputVideo";

// Execute FFmpeg command
shell_exec($ffmpegCommand);
array_push($medias,$outputVideo);


}else{
    $nfilePath = $filePath;
    if($nfilePath!==''){
    $nfilePath = str_replace('D:/Surge/uploads/', '', $nfilePath);
    $nfilePath = 'D:/Surge/uploads/aft_' . $nfilePath;
    
    // Ensure that the file path has the PNG extension
if(count($filePaths)==2){
    $filePath=$filePaths[1];
}array_filter($filePaths);
if($filePath==''){continue;}
    // Create an image resource from the original file
    $imageInfo = getimagesize($filePath);
    $imageType = $imageInfo[2]; // Get the image type
    $skip=false;
    // Create an image resource based on the image type
    switch ($imageType) {
        case IMAGETYPE_GIF:
            $skip=true;
            break;
        case IMAGETYPE_JPEG:
            $image = imagecreatefromjpeg($filePath);
            break;
        case IMAGETYPE_PNG:
            $image = imagecreatefrompng($filePath);
            break;
        case IMAGETYPE_WEBP:
            $image = imagecreatefromwebp($filePath);
            break;
        default:
            exit('Unsupported image type');
    }
    
    if(!$skip){
// Load the image
// Check for EXIF data and rotate the image if necessary
$exif = exif_read_data($filePath);
if (!empty($exif['Orientation'])) {
    switch ($exif['Orientation']) {
        case 3:
            $image = imagerotate($image, 180, 0);
            break;
        case 6:
            $image = imagerotate($image, -90, 0);
            break;
        case 8:
            $image = imagerotate($image, 90, 0);
            break;
        default:
            // Do nothing if orientation is not recognized
            break;
    }
}

// Get the dimensions of the original image
$imageWidth = imagesx($image);
$imageHeight = imagesy($image);

// Calculate the scaling factor
$maxWidth = 800;
$maxHeight = 800;
$scale = min($maxWidth / $imageWidth, $maxHeight / $imageHeight);

// Calculate the new dimensions
$newWidth = $imageWidth * $scale;
$newHeight = $imageHeight * $scale;

// Create a new image with the new dimensions
$resizedImage = imagecreatetruecolor($newWidth, $newHeight);

// Resize the original image to the new dimensions
imagecopyresampled($resizedImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $imageWidth, $imageHeight);

// Now you can proceed with your image processing

$textColor = imagecolorallocate($resizedImage, 255, 255, 255);
$watermark = imagecreatefrompng('C:/xampp/htdocs/media/watermark.png'); // Path to your watermark image

$text = "surgeme.xyz - @" . $username;

// Add watermark
$watermarkWidth = imagesx($watermark);
$watermarkHeight = imagesy($watermark);

// Calculate the position of the watermark (bottom-left corner)
$margin = 5; // Margin from the edges
$positionX = $margin;
$positionY = $newHeight - $watermarkHeight - $margin - 30;

imagecopy($resizedImage, $watermark, $positionX, $positionY, 0, 0, $watermarkWidth, $watermarkHeight);

// Add text
imagestring($resizedImage, 4, 5, $newHeight - 30, $text, $textColor);

// Save the result
imagepng($resizedImage, $nfilePath . '.png', 5);
array_push($medias, $nfilePath . '.png');

// Destroy resources
imagedestroy($image);
imagedestroy($resizedImage);
imagedestroy($watermark);



}
}}
    }
}
//$postText;
//foreach ($filePaths as $filePath) {
//    echo "$filePath <br>";
//$nfilePath=$filePath;
//$nfilePath=str_replace('D:/Surge/uploads/','',$nfilePath);
//$nfilePath='D:/Surge/uploads/aft_'.$nfilePath.'.png';
//    echo "$nfilePath <br>";
//}
/////////
//$postText;
//foreach ($medias as $media) {
//$mediaWatermarked = $media;
//}

if(count($medias)>0){
    $mediaPost=1;
}else{
    $mediaPost=0;
}
if(!$postText==''){
    $textPost=1;
}else{
    $textPost=0;
}
if($textPost+$mediaPost==0){
    header('location: /home');
    die();
}
$mediaList='';
function niceInput($text){
    $emojis = array(
        ':smile:' => '😊',
        ':happy:' => '😄',
        ':laugh:' => '😂',
        ':joy:' => '😅',
        ':grin:' => '😁',
        ':wink:' => '😉',
        ':love:' => '😍',
        ':heart:' => '❤️',
        ':kiss:' => '😘',
        ':hug:' => '🤗',
        ':blush:' => '😊',
        ':cool:' => '😎',
        ':awesome:' => '🤩',
        ':thumbsup:' => '👍',
        ':thumbsdown:' => '👎',
        ':okay:' => '👌',
        ':victory:' => '✌️',
        ':peace:' => '✌️',
        ':rockon:' => '🤘',
        ':proud:' => '🤗',
        ':excited:' => '😃',
        ':surprise:' => '😮',
        ':shock:' => '😱',
        ':wow:' => '😲',
        ':fear:' => '😨',
        ':anxious:' => '😰',
        ':angry:' => '😠',
        ':mad:' => '😡',
        ':frustrated:' => '😤',
        ':annoyed:' => '😒',
        ':sad:' => '😢',
        ':cry:' => '😭',
        ':tear:' => '😢',
        ':disappointed:' => '😞',
        ':down:' => '🙁',
        ':worried:' => '😟',
        ':nervous:' => '😬',
        ':scared:' => '😨',
        ':confused:' => '😕',
        ':doubt:' => '🤔',
        ':thinking:' => '🤔',
        ':thinkingface:' => '🤔',
        ':thinkingemoji:' => '🤔',
        ':think:' => '🤔',
        ':thinkface:' => '🤔',
        ':pride:' => '🏳️‍🌈',
        // Add more emoticons and their corresponding emoji here
    );

    // Replace emoticons with emoji
    foreach ($emojis as $emoticon => $emoji) {
        $text = str_replace($emoticon, $emoji, $text);
    }

    return $text;
}function dealWithUsernames($str) {
    // Regular expression pattern to find all usernames starting with '@'
    $pattern = '/@(\w+)/';
    
    // Perform the regular expression match
    preg_match_all($pattern, $str, $matches);
    
    // Extract usernames from the matches
    $usernames = $matches[1];

    // Database file path
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
            foreach ($usernames as $tagged) {
                if ($row['Username'] == $tagged) {
                    $displayname = $row['DisplayName']; // assuming you have a column named 'DisplayName'
                    $username = $row['Username'];
                    $Notifications = $row['Notifications'] . ',,!!,,' . $displayname . ' - Tagged you in a post. <a href="/u/?u=' . $username . '">Click here to view all their posts</a>.';
                    $updateQuery = "UPDATE Users SET Notifications = :Notifications WHERE Username = :username";
                    $updateStatement = $pdo->prepare($updateQuery);
                    $updateStatement->execute(array(':Notifications' => $Notifications, ':username' => $username));
                }
            }
        }
    } catch (PDOException $e) {
        // Handle database connection errors
        die("Database Connection failed: " . $e->getMessage());
    }
 
    return $str;
}

function sanitizeInput($input) {
    // Encode special characters
    $sanitized_input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');

    // Replace HTML tags with Unicode equivalents
    $sanitized_input = str_replace(
        array('<', '>', '&'),
        array('&#x3C;', '&#x3E;', '&#x26;'),
        $sanitized_input
    );

    return $sanitized_input;
}
foreach ($medias as $media) {
$mediaList.=',,!!,,'.$media;
}

$dbFilePath = 'D:/Surge/Surge.accdb';

try {
    $dsn = "odbc:Driver={Microsoft Access Driver (*.mdb, *.accdb)};Dbq=$dbFilePath";
    $pdo = new PDO($dsn);

    // Set PDO attributes
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare the INSERT statement
    $sql = "INSERT INTO Posts (PostUsername, PostTime, MediaPost, TextPost, MediaList, PostText) VALUES (:Username, :PTime, :mp, :tp, :ml, :pt)";
    $stmt = $pdo->prepare($sql);

    // Store the current date and time in a variable
    $currentTime = date('Y-m-d H:i:s');

    $stmt->bindParam(':Username', $username, PDO::PARAM_STR);
    $stmt->bindParam(':PTime', $currentTime, PDO::PARAM_STR); // Use the variable here
    $stmt->bindParam(':mp', $mediaPost, PDO::PARAM_STR);
    @$stmt->bindParam(':tp', $textPost, PDO::PARAM_STR);
    $stmt->bindParam(':ml', $mediaList, PDO::PARAM_STR);
    $stmt->bindParam(':pt', @dealWithUsernames(niceInput(sanitizeInput(@$postText))), PDO::PARAM_STR);

    // Execute the statement
    $stmt->execute();

   // echo "Item added successfully.";

} catch (PDOException $e) {
    // Handle database connection errors
    die("Database Connection failed: " . $e->getMessage());
}



// Discord Webhook URL
$webhookUrl = "https://discord.com/api/webhooks/1207819456689082378/jAz-RdRMBulhQ3Wg6zjhf6wjlcBSufg4TG9nM4t0pJHHqbgYYDYBNzo_IBUpyTFaZK3t";
if($textPost==1 && $mediaPost==0){
    $message ='**'. $displayname."** > ".$postText;
}if($textPost==1 && $mediaPost==1){
    $links=$mediaList;
    $links=str_replace(',,!!,,',"\n",$links);
    $links=str_replace('D:/Surge/uploads/','https://surgeme.xyz/smed/?url=',$links);
    $message = '**'. $displayname."** > ".$postText."\n".$links;
}
if($textPost==0 && $mediaPost==1){
    $links=$mediaList;
    $links=str_replace(',,!!,,',"\n",$links);
    $links=str_replace('D:/Surge/uploads/','https://surgeme.xyz/smed/?url=',$links);
    $message ='**'. $displayname."** > "."\n".$links;
    

}
$message=str_replace('@','(AT)',$message);
// Message to be sent


// Data to be sent in JSON format
$data = array(
    "content" => $message
);

// Encode the data as JSON
$jsonData = json_encode($data);

// Initialize cURL
$ch = curl_init($webhookUrl);

// Set the content type to application/json
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

// Set the request method to POST
curl_setopt($ch, CURLOPT_POST, 1);

// Attach the JSON payload
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);

// Set to true to return the transfer as a string
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
// Execute the request
$response = curl_exec($ch);

// Check for errors
if ($response === false) {
    echo "Error occurred: " . curl_error($ch);
} else {
   // echo "Message sent successfully!";
}

// Close cURL resource
curl_close($ch);






// Database file path
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
            $ptn=explode(',,!!,,',$row['Followers']);
        }
    }
} catch (PDOException $e) {
    // Handle database connection errors
    die("Database Connection failed: " . $e->getMessage());
}




// Database file path
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
        if (in_array($row['Username'], $ptn)) {
            $Notifications=$row['Notifications'].',,!!,,'.$displayname.' - Posted something. <a href="/u/?u='.$username.'">Click here to view all their posts</a>.';
            $updateQuery = "UPDATE Users SET Notifications = :Notifications WHERE Username = :username";
            $updateStatement = $pdo->prepare($updateQuery);
            $updateStatement->execute(array(':Notifications' => $Notifications, ':username' => $row['Username']));
        }
    }
} catch (PDOException $e) {
    // Handle database connection errors
    die("Database Connection failed: " . $e->getMessage());
}



header('location: /home/?posted');
die();
?>
