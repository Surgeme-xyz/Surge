<?php

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
if(isset($_GET['delete'])){



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
       if($row['Username']==$_POST['username']){
        if($row['Email']==$_POST['email']){
            if(password_verify($_POST['password'], $row['PasswordHash'])){


$username=$row['Username'];

                $to_email = $row['Email'];
    
 
 $subject = "Account removal - Surge";
 $verification_code = generateUsernameNumber($row['Email']); // Generate your verification code dynamically
 
 $message = '
 <!DOCTYPE html>
 <html lang="en">
 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Account removal</title>
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
         <h2>Account removal</h2>
         <p>Warning! You are about to delete your Surge account. This action cannot be undone. All data Surge has about your account will be deleted. Are you sure? To delete your account please use the following link:</p>
         <div class="verification-code"><a href="https://surgeme.xyz/authv2/delete/confirm/?code=' . $verification_code . '&user='.$username.'">'.'https://surgeme.xyz/authv2/delete/confirm/?code=' . $verification_code . '&user='.$username. '</a>.</div>
         <p>If you didn\'t request this, Please change your Surge password immediately.</p>
     </div>
 </body>
 </html>
 ';
 
 $headers = "From: surge@surgeme.xyz\r\n";
 $headers .= "Reply-To: surge@surgeme.xyz\r\n";
 $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
 
 if (!mail($to_email, $subject, $message, $headers)) {

    die("Email sending failed");
 }
 


            die('<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Delete My Account</title>
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
                        padding: 20px;
                        background-color: #fff;
                        border-radius: 8px;
                        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                    }
                    h2 {
                        text-align: center;
                    }
                    label {
                        display: block;
                        margin-bottom: 5px;
                    }
                    input[type="text"], input[type="password"] {
                        width: 100%;
                        padding: 10px;
                        margin-bottom: 15px;
                        border: 1px solid #ccc;
                        border-radius: 5px;
                        box-sizing: border-box;
                    }
                    input[type="submit"] {
                        width: 100%;
                        padding: 10px;
                        background-color: #007bff;
                        color: #fff;
                        border: none;
                        border-radius: 5px;
                        cursor: pointer;
                    }
                    input[type="submit"]:hover {
                        background-color: #0056b3;
                    }
                </style>
            </head>
            <body>
                <div class="container">
                    <h2>Delete My Account</h2>
                    <form id="deleteForm" action="?delete" method="POST" onsubmit="return confirmDelete()"><center>
            <h3>Please check your email to continue.</h3>
            </center>
                        <input type="submit" style="cursor: not-allowed;            background: #98a8e3;            color: #434343;" disabled value="Delete My Account">
                    </form>
                </div>
            
                <script>
                    function confirmDelete() {
                        // First warning
                        if (!confirm("Are you sure you want to delete your account? This action cannot be undone.")) {
                            return false;
                        }
            return true;
                    }
                </script>
            </body>
            </html>
            ');








                }
        }
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
    <title>Delete My Account</title>
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
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Delete My Account</h2>
        <form id="deleteForm" action="?delete" method="POST" onsubmit="return confirmDelete()">
            <label for="email">Email:</label>
            <input type="text" id="email" name="email" required>

            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <input type="submit" value="Delete My Account">
        </form>
    </div>

    <script>
        function confirmDelete() {
            // First warning
            if (!confirm("Are you sure you want to delete your account? This action cannot be undone.")) {
                return false;
            }
return true;
        }
    </script>
</body>
</html>
