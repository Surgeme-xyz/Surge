<?php
if(isset($_GET['sent'])){
    die('
    <html><head>
    <style>
*{font-family:Arial;}
    </style>
    </head><body>
    <h1>Recovery email sent.</h1>
    <hr>
    <h4>Please check your email to continue.</h4>
    </body></html>
    ');
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
      if($row['Username']==$_POST['username']){
        if($row['Email']==$_POST['email']){
            $to_email = $row['Email'];
      
$subject = "Account recovery - Surge";
$accessToken = bin2hex(random_bytes(10));
$updateQuery = "UPDATE Users SET AccessToken = :accessToken WHERE Username = :username";
$updateStatement = $pdo->prepare($updateQuery);
$updateStatement->execute(array(':accessToken' => $accessToken, ':username' => $_POST['username']));
$verification_code = 'https://surgeme.xyz/authv2/forgot/reset/?temptoken='.$_POST['username'].',,!!,,'.$accessToken; // Generate your verification code dynamically

$message = '
<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>Account recovery</title>
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
     <h2>Account recovery</h2>
     <p>Thank you for using Surge! To recover your account, please use the following link:</p>
     <div class="verification-code"><a href="' . $verification_code . '">'.$verification_code.'</a></div>
     <p>If you didn\'t request this please do not share this link.</p>
 </div>
</body>
</html>
';

$headers = "From: surge@surgeme.xyz\r\n";
$headers .= "Reply-To: surge@surgeme.xyz\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

if (mail($to_email, $subject, $message, $headers)) {
 header('location: /authv2/forgot/?sent'.$forwardString);
 die();
} else {
 echo "Email sending failed";
}


            die();
        }else{
            die('<h1>Incorrect Email!</h1><a href="/authv2/forgot/">Click here to go back.</a>');
        }
      }else{
        die('<h1>That user was not found!</h1><a href="/authv2/forgot/">Click here to go back.</a>');
      }
    }
} catch (PDOException $e) {
    // Handle database connection errors
    die("Database Connection failed: " . $e->getMessage());
}
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Recovery</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 500px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        label {
            font-weight: bold;
        }
        input[type="text"],
        input[type="email"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #4caf50;
            color: white;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Password Recovery</h2>
        <form action="?sendemail" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <input type="submit" value="Submit">
        </form>
    </div>
</body>
</html>
