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
            if($row['Username'] == $_GET['user'] && generateUsernameNumber($row['Email']) == $_GET['code']){
              $username=$_GET['user'];
                // Construct DELETE query for the current row
                $deleteQuery = "DELETE FROM Users WHERE Username = :username AND Email = :email";
                $deleteStatement = $pdo->prepare($deleteQuery);
                
                // Bind parameters
                $deleteStatement->bindParam(':username', $_GET['user']);
                $deleteStatement->bindParam(':email', $row['Email']);
                
                // Execute the DELETE query
                $deleteStatement->execute();
                $files = glob('C:/xampp/htdocs/userv2/'.$username.'/*');
foreach ($files as $file) {
        @unlink($file);
    
}

// Remove the folder

    rmdir('C:/xampp/htdocs/userv2/'.$username.'/');
                echo '<!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Surge Account Deleted</title>
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
                            text-align: center;
                        }
                        h1 {
                            color: #333;
                        }
                        #logout-btn {
                            background-color: #4CAF50;
                            border: none;
                            color: white;
                            padding: 15px 32px;
                            text-align: center;
                            text-decoration: none;
                            display: inline-block;
                            font-size: 16px;
                            margin-top: 20px;
                            cursor: pointer;
                            border-radius: 5px;
                            transition: background-color 0.3s ease;
                        }
                        #logout-btn:hover {
                            background-color: #45a049;
                        }
                    </style>
                </head>
                <body>
                    <div class="container">
                        <h1>Surge Account Deleted</h1>
                        <button id="logout-btn" onclick="logout()">Logout</button>
                    </div>
                
                    <script>
                        function logout() {
                         
                            window.location.href = "/authv2/logout";
                        }
                    </script>
                </body>
                </html>
                ';
                die();
                // After deleting the row, you might want to break out of the loop
                break;
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
  <title>Delete Account Confirmation</title>
  <style>
    body {
  font-family: Arial, sans-serif;
  background-color: #f4f4f4;
}

.container {
  max-width: 400px;
  margin: 100px auto;
  padding: 20px;
  background-color: #fff;
  border-radius: 8px;
  transition:0.2s;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  text-align: center;
}

h1 {
  color: #333;
}

button {
  padding: 10px 20px;
  background-color: #dc3545;
  color: #fff;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

button:hover {
  background-color: #c82333;
}


</style>
</head>
<body>
  <div class="container">
    <h1>Delete Account</h1>
    <p id='a'>Are you sure you want to delete your account?</p>
    <button id="deleteBtn">Delete Account</button>
  </div>

  <script>document.getElementById('deleteBtn').addEventListener('click', function() {
  if (confirm("Are you sure you want to delete your account?")) {
    if (confirm("This action cannot be undone. Are you really sure?")) {
      alert("Your account will be deleted. Close your browser now to abort.");
      // Here you can add the logic to delete the account\
      document.getElementById('deleteBtn').setAttribute('disabled','disabled')
      document.getElementById('deleteBtn').innerHTML='Removing Surge account in 5'
      document.getElementsByClassName('container')[0].style='color:red!important;transform:scale(1.5);'
       document.getElementById('a').style=''
      setTimeout(() => {
        document.getElementById('deleteBtn').innerHTML='Removing Surge account in 4'
      document.getElementsByClassName('container')[0].style='color:yellow!important;transform:scale(1.5);'
      document.getElementById('a').style='background:black!important';
      setTimeout(() => {
        document.getElementById('deleteBtn').innerHTML='Removing Surge account in 3'
      document.getElementsByClassName('container')[0].style='color:black!important;transform:scale(1.5);'
       document.getElementById('a').style=''
      setTimeout(() => {
        document.getElementById('deleteBtn').innerHTML='Removing Surge account in 2'
      document.getElementsByClassName('container')[0].style='color:red!important;transform:scale(1.5);'
      document.getElementById('a').style=''
      setTimeout(() => {
        document.getElementById('deleteBtn').innerHTML='Removing Surge account in 1'
      document.getElementsByClassName('container')[0].style='color:yellow!important;transform:scale(1.5);'
       document.getElementById('a').style='background:black!important';
      setTimeout(() => {
        document.getElementById('deleteBtn').innerHTML='Removing Surge account in 0'
      document.getElementsByClassName('container')[0].style='color:black!important;transform:scale(1.5);'
       document.getElementById('a').style=''
      setTimeout(() => {
        document.getElementById('deleteBtn').innerHTML='Removing Surge account...'
      document.getElementsByClassName('container')[0].style='color:red!important;transform:scale(2);'
       document.getElementById('a').style=''
       setTimeout(() => {
      window.location.replace('?delete&code=<?=$_GET['code']?>&user=<?=$_GET['user']?>')
      }, 1000);
      }, 1000);
      }, 1000);
      }, 1000);
      }, 1000);
      }, 1000);
      }, 1000);
    }
  }
});
</script>
</body>
</html>
