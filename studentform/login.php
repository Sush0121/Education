<?php
session_start();

$conn = new mysqli("localhost", "root", "", "school");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email    = $_POST['email'];
$password = $_POST['password'];


$sql = "SELECT * FROM students WHERE email='$email'";
$result = $conn->query($sql);

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();

    
    if (password_verify($password, $row['password'])) {
        $_SESSION['student'] = $row['fname'] . " " . $row['lname'];
        $_SESSION['email'] = $row['email'];
        
        header("Location: dashboard.php");
        exit();
    } else {
        echo "<h3 class='error'>❌ Incorrect password.</h3>";
    }
} else {
    echo "<h3 class='error'>❌ No account found with that email.</h3>";
}

$conn->close();
?>
