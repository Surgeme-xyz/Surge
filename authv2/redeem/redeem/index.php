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
?><?php
if(file_exists('C:/xampp/htdocs/sdata/redeem/'.$_GET['code'])){
    unlink('C:/xampp/htdocs/sdata/redeem/'.$_GET['code']);
    $string = $_GET['code'];
$substring = ".verify";

if (substr($string, -strlen($substring)) === $substring) {
//verify

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
            
            $updateQuery = "UPDATE Users SET Verified = :newuser WHERE Username = :username";
            $updateStatement = $pdo->prepare($updateQuery);
            $updateStatement->execute(array(':newuser' => 1, ':username' => $row['Username']));
            
            die('Surge account has been verified!');
        }
    }
} catch (PDOException $e) {
    // Handle database connection errors
    die("Database Connection failed: " . $e->getMessage());
}

}
}else{
    die('Invalid code!');
}
?>