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
    exit();
}

$sql = "SELECT * FROM `users`";
$result = $conn->query($sql);

header("Content-Disposition: attachment; filename=\"users_data.xls\"");
header("Content-Type: application/vnd.ms-excel");

$flag = false;
while ($row = $result->fetch_assoc()) {
    if (!$flag) {
        echo implode("\t", array_keys($row)) . "\n";
        $flag = true;
    }
    array_walk($row, function(&$item, $key) {
        $item = str_replace("\n", " ", $item); // Remove newlines
        $item = preg_replace("/\t/", "\\t", $item); // Escape tabs
        $item = preg_replace("/\r/", "\\r", $item); // Escape carriage returns
        echo $item . "\t";
    });
    echo "\n";
}
exit();
?>
