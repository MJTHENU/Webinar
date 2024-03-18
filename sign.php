<?php
session_start();

$localhost = "localhost";
$username = "skill";
$password = "SCknl*t.&aMn";
$database = "skill_development";

$conn = mysqli_connect($localhost, $username, $password, $database);

if (!$conn) {
    echo "Database Connection Failed";
}

if (isset($_POST['user']) && isset($_POST['password'])) {
    $user = $_POST['user'];
    $password = $_POST['password'];

    // Hash the password securely (use bcrypt or another secure hashing algorithm)
    $hashed_password = md5($password); // Example: using md5 (not recommended for production)

    $sql = "SELECT * FROM `admin` WHERE user = '$user' AND password = '$password'";
    
    // Execute the query
    $result = mysqli_query($conn, $sql);

    if ($result) {
        // Check if there is a matching row
        if (mysqli_num_rows($result) == 1) {
            $admin = mysqli_fetch_assoc($result);
            $id = $admin['id'];
            $_SESSION['id'] = $id;

            // Redirect to admin.php
            header("Location: admin.php");
            exit();
        } else {
            // Invalid username or password, redirect back to sign-in page with an error message
            $_SESSION['error'] = "Invalid Username or Password";
            header("Location: sign.php");
            exit();
        }
    } else {
        // Handle query execution error
        echo "Query execution failed: " . mysqli_error($conn);
    }
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="css/login.css">
    <script>
        // Check if there's an error message, then display alert
        <?php if(isset($_SESSION['error'])): ?>
            alert("<?php echo $_SESSION['error']; ?>");
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
    </script>
</head>
<body>
    
    <?php
    if(isset($_SESSION['error'])) {
        echo "<p>{$_SESSION['error']}</p>";
        unset($_SESSION['error']); 
    }
    ?>
    <form action="" method="post">
    <h1>Admin Login</h1>
        <label for="user">Username:</label>
        <input type="text" placeholder="@username" id="user" name="user" required>
        <label for="password">Password:</label>
        <input type="password" placeholder="password" id="password" name="password" required>
        <input type="submit" value="Submit">
    </form>
</body>
</html>
