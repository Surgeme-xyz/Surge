<?php
$querysearch = $_GET['q'];
// Database file path
$dbFilePath = 'D:/Surge/Surge.accdb';

try {
    $dsn = "odbc:Driver={Microsoft Access Driver (*.mdb, *.accdb)};Dbq=$dbFilePath";
    $pdo = new PDO($dsn);

    // Set PDO attributes
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Example query
    $query = "SELECT Username, DisplayName FROM Users";
    $statement = $pdo->query($query);

    // Fetch data
    $results = [];
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $results[] = [
            'username' => $row['Username'],
            'displayname' => $row['DisplayName']
        ];
    }

    // Define custom sorting function
    function custom_sort($a, $b) {
        global $querysearch;
        $a_lower_username = strtolower($a['username']);
        $b_lower_username = strtolower($b['username']);
        $a_lower_displayname = strtolower($a['displayname']);
        $b_lower_displayname = strtolower($b['displayname']);

        // Check for exact match in username or displayname
        if ($a_lower_username === $querysearch || $a_lower_displayname === $querysearch) return -1;
        if ($b_lower_username === $querysearch || $b_lower_displayname === $querysearch) return 1;

        // Check for partial match in username or displayname
        similar_text($a_lower_username, $querysearch, $similarity_a_username);
        similar_text($b_lower_username, $querysearch, $similarity_b_username);
        similar_text($a_lower_displayname, $querysearch, $similarity_a_displayname);
        similar_text($b_lower_displayname, $querysearch, $similarity_b_displayname);

        // Sort by similarity in username or displayname
        $similarity_a = max($similarity_a_username, $similarity_a_displayname);
        $similarity_b = max($similarity_b_username, $similarity_b_displayname);
        
        return $similarity_b - $similarity_a;
    }

    // Sort the results using custom sorting function
    usort($results, "custom_sort");

    // Output sorted results
    foreach ($results as $user) {
        $username = $user['username'];
        $displayname = $user['displayname'];
        if (str_contains(strtolower($username), strtolower($querysearch)) || str_contains(strtolower($displayname), strtolower($querysearch))) {
            echo '<searchUser>'.$username . '</searchUser>';
            // Also, you may output display name if needed
            // echo '<searchDisplayName>'.$displayname . '</searchDisplayName>';
        }
    }
} catch (PDOException $e) {
    // Handle database connection errors
    die("Database Connection failed: " . $e->getMessage());
}
?>
