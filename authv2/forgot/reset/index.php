<?php
$myURL = '/authv2/forgot/reset/'; //URL of this script.
if(isset($_GET['temptoken'])){
    setcookie("surge-token", $_GET['temptoken'], time()+360000);
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
}
?><?php
if(isset($_GET['reset'])){
    $dbFilePath = 'D:/Surge/Surge.accdb';

try {
    $dsn = "odbc:Driver={Microsoft Access Driver (*.mdb, *.accdb)};Dbq=$dbFilePath";
    $pdo = new PDO($dsn);

    // Set PDO attributes
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



    $updateQuery = "UPDATE Users SET PasswordHash = :passwordhash WHERE Username = :username";
    $hashed_password = password_hash($_POST['password'], PASSWORD_BCRYPT, ['cost' => 12]);
    // Prepare and execute the update statement
    $statement = $pdo->prepare($updateQuery);
    $statement->execute(array(':username' => $username,':passwordhash' => $hashed_password));

    die('<h1>Password has been reset.</h1><hr><a href="/authv2/logout/">Click here to login.</a><style>*{font-family:Arial;}</style>');
} catch (PDOException $e) {
    // Handle database connection errors
    die("Database Connection failed: " . $e->getMessage());
}
    die();
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Recovery - Pick New Password</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Account Recovery - Pick New Password</h3>
                    </div>
                    <div class="card-body">
                        <form id="passwordForm" action='?reset' method='POST'>
                            <div class="form-group">
                                <label for="password">New Password:</label>
                                <input type="password" class="form-control" name='password' id="password" required minlength="8">
                            </div>
                            <div class="form-group">
                                <label for="confirmPassword">Confirm Password:</label>
                                <input type="password" class="form-control" id="confirmPassword" required minlength="8">
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // JavaScript for validating password and confirm password
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                var form = document.getElementById('passwordForm');
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            }, false);
        })();
    </script>
</body>
</html>
