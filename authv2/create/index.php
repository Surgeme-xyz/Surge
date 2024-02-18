<?php
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

if(isset($_GET['forward'])){
    $forwardString='&forward='.$_GET['forward'];
}else{
    $forwardString='';
}
// Retrieve sanitized input from POST
if (
    isset($_POST['user']) &&
    isset($_POST['displayname']) &&
    isset($_POST['pass']) &&
    isset($_POST['dob']) &&
    isset($_POST['email'])
) {
    // If all fields are set, sanitize them
    $username = sanitizeInput($_POST['user']);
    $displayname = sanitizeInput($_POST['displayname']);
    $password = sanitizeInput($_POST['pass']);
    $dateofbirth = sanitizeInput($_POST['dob']);
    $email = sanitizeInput($_POST['email']);

    // Proceed with further processing
} else {
    // Handle the case where not all fields are set
    header('location: /authv2/register/?error=Something went wrong. Please try again.'.$forwardString);
    die();
}
// Database file path
$dbFilePath = 'D:/Surge/Surge.accdb';

try {
    $dsn = "odbc:Driver={Microsoft Access Driver (*.mdb, *.accdb)};Dbq=$dbFilePath";
    $pdo = new PDO($dsn);

    // Set PDO attributes
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare the insert statement
    $query = "INSERT INTO Users (Username, DisplayName, Email, PasswordHash, DateOfCreation, LastUsedIP, DateOfBirth) 
              VALUES (:username, :displayname, :email, :password_hash, :date_of_creation, :ip_address, :dob)";
    $statement = $pdo->prepare($query);

    // Hash the password using bcrypt with a cost factor of 12
    $hashed_password = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);

    // Get the current date
    $date_of_creation = date('Y-m-d H:i:s');

    if (isset($_SERVER['HTTP_CF_CONNECTING_IP'])) {
        $ip_address = $_SERVER['HTTP_CF_CONNECTING_IP'];
    } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } elseif (isset($_SERVER['REMOTE_ADDR'])) {
        $ip_address = $_SERVER['REMOTE_ADDR'];
    } else {
        // Fallback to a default value or handle the situation accordingly
        $ip_address = 'Unknown';
    }

    // Bind parameters
    $statement->bindParam(':username', $username, PDO::PARAM_STR);
    $statement->bindParam(':displayname', $displayname, PDO::PARAM_STR);
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->bindParam(':dob', $dateofbirth, PDO::PARAM_STR);
    $statement->bindParam(':password_hash', $hashed_password, PDO::PARAM_STR);
    $statement->bindParam(':date_of_creation', $date_of_creation, PDO::PARAM_STR);
    $statement->bindParam(':ip_address', $ip_address, PDO::PARAM_STR);

    // Execute the statement
    $statement->execute();
    mkdir('C:/xampp/htdocs/userv2/'.$username.'/');
    echo <<<EOT
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Account Created - Surge</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                background-color: #f4f4f4;
                color: #333;
            }
            .container {
                max-width: 600px;
                margin: 50px auto;
                padding: 20px;
                background-color: #fff;
                border-radius: 5px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }
            h1, h2, h3 {
                text-align: center;
            }
            hr {
                border: 1px solid #ddd;
                margin: 20px 0;
            }
            a {
                color: #007bff;
                text-decoration: none;
            }
            a:hover {
                text-decoration: underline;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>Account Created</h1>
            <hr>
            <h2>Your account has been created.</h2>
            <h3><a href="/authv2/$forwardString">Click here</a> to login.</h3>
        </div>
    </body>
    </html>
    EOT    ;

} catch (PDOException $e) {
    // Handle database connection errors
    header('location: /authv2/register/?error=That username is taken.'.$forwardString);
    die();
}
?>
