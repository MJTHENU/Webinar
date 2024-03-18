<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['id'])) {
    header("Location: sign.php");
    exit();
}

$localhost = "localhost";
$username = "skill";
$password = "SCknl*t.&aMn";
$database = "skill_development";

$conn = mysqli_connect($localhost, $username, $password, $database);

if (!$conn) {
    echo "Database Connection Failed";
}

$sql = "SELECT * FROM `users`";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
    <div>
        <h1>Welcome Admin!</h1>
    </div>

    <h2>Registered Users</h2>
    <div class="btn">
        <a href="logout.php" class="logout">Logout</a>
        <a href="download.php" class="download-excel">Download Excel Sheet</a>
    </div>

    <table style="overflow-x:auto;">
        <tr>
            <th>Id</th>
            <th>User Id</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Mobile Number</th>
            <th>Gender</th>
            <th>College</th>
            <th>Degree</th>
            <th>Department</th>
            <th>Date of Birth</th>
            <th>Passed Out</th>
            <th>City / District</th>
            <!-- Add more fields as needed -->
        </tr>
        <?php
        $i = 1;
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>". $i . "</td>";
            echo "<td>" . $row['user_id'] . "</td>";
            echo "<td>" . $row['first_name'] . "</td>";
            echo "<td>" . $row['last_name'] . "</td>";
            echo "<td>" . $row['email'] . "</td>";
            echo "<td>" . $row['mobile_no'] . "</td>";
            echo "<td>" . $row['gender'] . "</td>";
            echo "<td>" . $row['college'] . "</td>";
            echo "<td>" . $row['degree'] . "</td>";
            echo "<td>" . $row['department'] . "</td>";
            echo "<td>" . $row['dob'] . "</td>";
            echo "<td>" . $row['year'] . "</td>";
            echo "<td>" . $row['city'] . "</td>";
            // Add more table cells for additional fields
            echo "</tr>";
            
            $i++;
        }
        ?>
    </table>
</body>
</html>
