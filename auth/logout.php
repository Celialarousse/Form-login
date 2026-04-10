<?php
session_start();
session_unset(); // This clears all data stored in the session
session_destroy(); // This deletes the session on the server side

header("Location: ../auth/login.php");
exit();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Logout</title>
        <link rel="stylesheet" href="../assets/styles.css">
    </head>
    <body>
        <div class="welcome-container">
            <h1>You are logged out</h1>
            <p>Thank you for using our service.</p>
            <p>You will be redirected to the login page...</p>
            <meta http-equiv="refresh" content="3;url=login.php"> <!-- This meta tag refreshes the page after 3 seconds and redirects to the login page -->
        </div>
    </body>
</html>