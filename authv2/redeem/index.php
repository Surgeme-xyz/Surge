<?php
$myURL = '/authv2/redeem/'; //URL of this script.
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
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redeem a code</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
                    <div class="card-body">
                        <h4 class="card-title text-center mb-4">Redeem a code</h4>
                        <form id="redeemForm" method='get' action='redeem/'>
                            <div class="form-group">
                                <label for="code">Enter your code:</label>
                                <input type="text" class="form-control" id="code" name="code" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Redeem</button>
                        </form>
                        <div id="result" class="mt-3 text-center"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and jQuery (optional) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>

    </script>
</body>
</html>
