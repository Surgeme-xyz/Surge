<?php
$forwardString='';
if(isset($_GET['forward'])){
    $forwardString='?forward='.$_GET['forward'];
}
$myURL='/authv2/verify/';
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
}?><?php
function generateUsernameNumber($username) {
    // Use MD5 hash to generate a consistent number for the username
    $hash = md5($username);
    // Take the first 6 characters from the hash
    $number = substr($hash, 0, 6);
    // Convert hexadecimal to decimal
    $decimalNumber = hexdec($number);
    // Ensure the number is within the 6-digit range (000000 to 999999)
    $sixDigitNumber = str_pad($decimalNumber % 1000000, 6, '0', STR_PAD_LEFT);
    
    return $sixDigitNumber;
}
if(isset($_GET['sendemail'])){
  


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

            $to_email = $row['Email'];
           }
        }
    } catch (PDOException $e) {
        // Handle database connection errors
        die("Database Connection failed: " . $e->getMessage());
    }

$subject = "Email Verification - Surge";
$verification_code = generateUsernameNumber($username); // Generate your verification code dynamically

$message = '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #333;
        }
        p {
            color: #666;
        }
        .verification-code {
            background-color: #f8f8f8;
            padding: 10px;
            border-radius: 5px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Email Verification</h2>
        <p>Thank you for using Surge! To verify your email address, please use the following verification code:</p>
        <div class="verification-code">' . $verification_code . '</div>
        <p>If you didn\'t sign up for this service, you can safely ignore this email.</p>
    </div>
</body>
</html>
';

$headers = "From: surge@surgeme.xyz\r\n";
$headers .= "Reply-To: surge@surgeme.xyz\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

if (mail($to_email, $subject, $message, $headers)) {
    header('location: /authv2/verify/confirm/'.$forwardString);
    die();
} else {
    echo "Email sending failed";
}

}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification Required</title>
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
        .container {
            text-align: center;
        }
        h1 {
            color: #333;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px;
            text-decoration: none;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>You need to verify your email before you can access Surge</h1>
        <div>
            <a href="/authv2/verify/?sendemail<?php if(isset($_GET['forward'])){echo '&forward='.$_GET['forward'];}?>" class="btn">Send email</a>
            <a href="/authv2/logout/<?php if(isset($_GET['forward'])){echo '?forward='.$_GET['forward'];}?>" class="btn">Logout</a>
        </div>
    </div>
</body>
</html>
