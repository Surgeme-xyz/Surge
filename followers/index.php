<?php
  
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
        if($row['Username']==$_GET['u']){
            $fs=explode(',,!!,,',$row['Followers']);
            array_filter($fs);
            $fs=implode(',,!!,,',$fs);

        }
    }
} catch (PDOException $e) {
    // Handle database connection errors
    die("Database Connection failed: " . $e->getMessage());
}
function formatFollowers($num) {
  if($num == 0) {
      return '0 Followers';
  }  elseif($num == 1) {
      return '1 Follower';
  }
  
  // Define an array of suffixes for different magnitudes
  $suffixes = ['', 'k', 'M', 'B', 'T'];

  // Determine the magnitude of the number
  $magnitude = floor(log10(abs($num)) / 3);

  // Determine the suffix to use
  $suffix = $suffixes[$magnitude];

  // Calculate the shortened number
  $shortNum = $num / pow(10, $magnitude * 3);

  // Format the number and suffix with "follower" or "followers" based on the value
  $formattedFollowers = $shortNum . $suffix . ($num === 1 ? ' Follower' : ' Followers');

  return $formattedFollowers;
}

echo formatFollowers(count(array_filter(explode(',,!!,,',$fs))));

  ?>