<?php
// Prevent caching
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past

// Your PHP code goes here
?>
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
} else {
    header('location: /authv2/?forward='.$myURL);
    die();
} 
if(!isset($displayname)){
    header('location: /authv2/?forward='.$myURL);
    die();
}
?>
<?php
$trendingposts=false;
if(isset($_GET['trend'])){
    $trendingposts=true;
}
if(isset($_GET['p'])){
    $donep=$_GET['p'];
  
    // Database file path
    $dbFilePath = 'D:/Surge/Surge.accdb';

    try {
        $dsn = "odbc:Driver={Microsoft Access Driver (*.mdb, *.accdb)};Dbq=$dbFilePath";
        $pdo = new PDO($dsn);

        // Set PDO attributes
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Example query
        if($trendingposts){
            $query = "SELECT * FROM Posts ORDER BY Likes DESC, ID DESC";
        } else {
            $query = "SELECT * FROM Posts ORDER BY ID DESC";
        }
        $statement = $pdo->query($query);
        $count=0;
        $donec=0;
        
        // Fetch data
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $count=$count+1;
            if($count>$donep){
                $donec=$donec+1;
                if($donec<6){
                    echo ',,!!,,'.$row['ID'];
                }
            }
        }
    } catch (PDOException $e) {
        // Handle database connection errors
        die("Database Connection failed: " . $e->getMessage());
    }
}
?>
