<?php
// Database file path
$dbFilePath = 'D:/Surge/Surge.accdb';
$forward=@$_GET['forward'];
if(isset($_GET['forward'])){
$forwardString='&forward='.@$_GET['forward'];
}else{
    $forwardString='';
}
try {
    $dsn = "odbc:Driver={Microsoft Access Driver (*.mdb, *.accdb)};Dbq=$dbFilePath";
    $pdo = new PDO($dsn);

    // Set PDO attributes
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Example query
    $query = "SELECT * FROM Users";
    $statement = $pdo->query($query);
    $found = False;

    // Fetch data
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        echo $row['Username'];
        if ($row['Username'] == $_POST['user']) {
            if($row['LoginTrys']>10){
                if (isset($_GET['basic'])) {
                    header('location: /authv2/?basic&error=Account is locked. Please <a href="/authv2/unlock">click here</a> to unlock it.');
                    die();
                } else {
                    header('location: /authv2/?error=Account is locked. Please <a href="/authv2/unlock">click here</a> to unlock it.'.$forwardString);
                    die();
                }
            }
            if($row['Banned']){
                header('location: /authv2/?error=This account is disabled.'.$forwardString);
                die();
            }
            $found = True;
            if (password_verify($_POST['pass'], $row['PasswordHash'])) {
                if (isset($_SERVER['HTTP_CF_CONNECTING_IP'])) {
                    $LastUsedIP = $_SERVER['HTTP_CF_CONNECTING_IP'];
                } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                    $LastUsedIP = $_SERVER['HTTP_X_FORWARDED_FOR'];
                } elseif (isset($_SERVER['REMOTE_ADDR'])) {
                    $LastUsedIP = $_SERVER['REMOTE_ADDR'];
                } else {
                    // Fallback to a default value or handle the situation accordingly
                    $LastUsedIP = 'Unknown';
                }
                if($row['LastUsedIP']!==$LastUsedIP){
                    $Notifications=$row['Notifications'].',,!!,,New login into your account from a different IP('.$LastUsedIP.'). Something seem off? Change your password in your user settings.';
                $updateQuery = "UPDATE Users SET Notifications = :Notifications WHERE Username = :username";
                $updateStatement = $pdo->prepare($updateQuery);
                $updateStatement->execute(array(':Notifications' => $Notifications, ':username' => $_POST['user']));
                }
                $accessToken = bin2hex(random_bytes(100));
                $updateQuery = "UPDATE Users SET AccessToken = :accessToken WHERE Username = :username";
                $updateStatement = $pdo->prepare($updateQuery);
                $updateStatement->execute(array(':accessToken' => $accessToken, ':username' => $_POST['user']));
                $updateQuery = "UPDATE Users SET LastUsedIP = :LastUsedIP WHERE Username = :username";
                $updateStatement = $pdo->prepare($updateQuery);
                $updateStatement->execute(array(':LastUsedIP' => $LastUsedIP, ':username' => $_POST['user']));
                
                $loginTrys = 0;
                $updateQuery = "UPDATE Users SET LoginTrys = :loginTrys WHERE Username = :username";
                $updateStatement = $pdo->prepare($updateQuery);
                $updateStatement->execute(array(':loginTrys' => $loginTrys, ':username' => $_POST['user']));
                setcookie('surge-token', $_POST['user'].',,!!,,'.$accessToken, time() + 300600, '/');
                if($row['EmailConfirmed']){
                if(isset($_GET['forward'])){
         
                    header('location: '.$forward.'?token='.$accessToken);
                }else{
                header('location: /home');
                }}else{
                    if(isset($_GET['forward'])){
                        header('location: /authv2/verify/?forward='.$forward);
                    }else{
                    header('location: /authv2/verify/');
                    }   
                }

            } else {
                $loginTrys = $row['LoginTrys'] + 1;
                $updateQuery = "UPDATE Users SET LoginTrys = :loginTrys WHERE Username = :username";
                $updateStatement = $pdo->prepare($updateQuery);
                $updateStatement->execute(array(':loginTrys' => $loginTrys, ':username' => $_POST['user']));

                if (isset($_GET['basic'])) {
                    header('location: /authv2/?basic&error=Incorrect password.');
                    die();
                } else {
                    header('location: /authv2/?error=Incorrect password.'.$forwardString);
                    die();
                }
            }
        }
    }
    if (!$found) {
        if (isset($_GET['basic'])) {
            header('location: /authv2/?basic&error=The user cannot be found.');
            die();
        } else {
        
            header('location: /authv2/?error=The user cannot be found.'.$forwardString);
            die();
        }
    }
} catch (PDOException $e) {
    // Handle database connection errors
    die("Database Connection failed: " . $e->getMessage());
}
?>
