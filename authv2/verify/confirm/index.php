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
if(isset($_GET['check'])){
    if($_POST['verification_code']==generateUsernameNumber($username)){
        // Database file path
        $dbFilePath = 'D:/Surge/Surge.accdb';
        try {
            $dsn = "odbc:Driver={Microsoft Access Driver (*.mdb, *.accdb)};Dbq=$dbFilePath";
            $pdo = new PDO($dsn);

            // Set PDO attributes
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Update query
            $updateQuery = "UPDATE Users SET EmailConfirmed = true WHERE Username = :username";

            // Prepare and execute the update statement
            $statement = $pdo->prepare($updateQuery);
            $statement->execute(array(':username' => $username));

            // Handle success or failure
            if ($statement->rowCount() > 0) {
                
                if(isset($_GET['forward'])){
                    header('location: '.$forward.'?token='.$accessToken);
                }else{
                header('location: /home/?firsttime');
                }
                
                // EmailConfirmed updated successfully
                die();

            } else {
                // No rows affected, handle this scenario
               die("Email confirmation failed!");
            }

        } catch (PDOException $e) {
            // Handle database connection errors or SQL execution errors
            die("Database Connection failed: " . $e->getMessage());
        }
    }else{
        echo "<h1 style='color:red;text-align:center;padding-top:20px;'>Invalid code.</h1>";
    }
}

?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Email Verification</title>
  <!-- Bootstrap CSS -->
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f4f4f4;
    }
    .container {
      margin-top: 100px;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h3 class="text-center">Email Verification</h3>
          </div>
          <div class="card-body">
            <form method='POST' action="?check<?php if(isset($_GET['forward'])){echo '&forward='.$_GET['forward'];}?>">
                <span>Make sure to check both your inbox and your spam mail.</span>
                <br><br>
              <div class="form-group">
                <label for="verification_code">Enter Verification Code:</label>
                <input type="text" class="form-control" id="verification_code" name="verification_code" required>
              </div>
              <button type="submit" class="btn btn-primary btn-block">Verify</button>
              <button type="button" onclick='window.location.replace("/authv2/verify/?sendemail<?php if(isset($_GET['forward'])){echo '&forward='.$_GET['forward'];}?>")' class="btn btn-secondary btn-block">Resend email</button>
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
</body>
</html>
