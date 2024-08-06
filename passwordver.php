<?php
// Database connection
include "connection.php";

// Initialize variables
$alert = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve username and password from the form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Sanitize input
    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);

    // Query to fetch user data
    $sql = "SELECT * FROM register WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            // Fetch the result row
            $row = mysqli_fetch_assoc($result);
            $hashed_password = $row['password']; // Get hashed password from database
            
            // Verify password (MD5 format)
            if (md5($password) === $hashed_password) {
                // Start session and store username
                session_start();
                $_SESSION['username'] = $username;
                header('Location: main.php');
                exit();
            } else {
                $alert = "Invalid username or password";
            }
        } else {
            $alert = "Invalid username or password";
        }
        mysqli_free_result($result);
    } else {
        $alert = "Database query error: " . mysqli_error($conn);
    }

    // Close connection
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <?php if(!empty($alert)): ?>
        <div><?php echo $alert; ?></div>
    <?php endif; ?>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" required><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" value="Login">
    </form>
</body>
</html>
