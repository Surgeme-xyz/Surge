<?php
$myURL = '/authv2/editname'; //URL of this script.
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

if(isset($_GET['set'])){
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
            $newuser=sanitizeInput($_POST['displayName']);
            $updateQuery = "UPDATE Users SET DisplayName = :newuser WHERE Username = :username";
            $updateStatement = $pdo->prepare($updateQuery);
            $updateStatement->execute(array(':newuser' => $newuser, ':username' => $row['Username']));
        if(isset($_GET['forward'])){
            header('location: '.$_GET['forward']);
            die();
        }else{

            die('<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Display Name Changed Successfully</title>
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
                    <h2>Display Name Changed Successfully</h2>
                </div>
            </body>
            </html>
            ');
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
    <title>Change Display Name</title>
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
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        label {
            font-weight: bold;
        }

        input[type="text"] {
            width: 95%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Change Display Name</h2>
        <form id="changeNameForm" action='?set<?php if(isset($_GET['forward'])){echo '&forward='.$_GET['forward'];} ?>' method='POST'>
            <div class="form-group">
                <label for="displayName">New Display Name:</label>
                <input type="text" id="displayName" name="displayName" required>
            </div>
            <div class="form-group">
                <input type="submit" value="Change Name">
            </div>
        </form>
    </div>

    <script>

    </script>
</body>
</html>
