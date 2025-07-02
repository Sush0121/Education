<?php

$conn = new mysqli("localhost", "root", "", "school");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$fname    = $_POST['fname'];
$lname    = $_POST['lname'];
$sname    = $_POST['schoolname'];
$standard = $_POST['standard'];
$section  = $_POST['section'];
$email    = $_POST['email'];
$phone    = $_POST['phone'];
$password = $_POST['password'];
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$photoName = "";
$imageSizeKB = 0;

if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
    $targetDir = "uploads/";

    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    $fileName     = basename($_FILES["photo"]["name"]);
    $fileType     = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $allowedTypes = ["jpg", "jpeg", "png", "gif"];

    if (in_array($fileType, $allowedTypes)) {
        $photoName  = uniqid("student_") . "." . $fileType;
        $targetPath = $targetDir . $photoName;

        $imageSizeKB = round($_FILES['photo']['size'] / 1024, 2); 
        
        if (!move_uploaded_file($_FILES["photo"]["tmp_name"], $targetPath)) {
            die("Failed to upload photo.");
        }
    } else {
        die("Only JPG, JPEG, PNG, and GIF files are allowed.");
    }
} else {
    die("Please upload a valid photo.");
}

$sql = "INSERT INTO students (fname, lname, sname, standard, section, email, phone, photo, password)
        VALUES ('$fname', '$lname', '$sname', '$standard', '$section', '$email', '$phone', '$photoName', '$hashedPassword')";

if ($conn->query($sql) === TRUE) {
    echo "<h2 style='color:green; text-align:center;'>🎉 Registration Successful!</h2>";
    echo "<h3 style='text-align:center;'>Stored Details:</h3>";

    echo "<table border='1' cellpadding='10' cellspacing='0' style='margin: auto; font-family: Arial;'>
            <tr>
                <th>Photo</th>
                <th>Size (KB)</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>School Name</th>
                <th>Standard</th>
                <th>Section</th>
                <th>Email</th>
                <th>Phone</th>
            </tr>
            <tr>
                <td><img src='uploads/$photoName' alt='Student Photo' width='100'></td>
                <td>{$imageSizeKB} KB</td>
                <td>$fname</td>
                <td>$lname</td>
                <td>$sname</td>
                <td>$standard</td>
                <td>$section</td>
                <td>$email</td>
                <td>$phone</td>
            </tr>
        </table>";

    // Go Back to Login Button
    echo "<div style='text-align:center; margin-top: 30px;'>
            <a href='login.html' style='
                display: inline-block;
                padding: 12px 25px;
                font-size: 16px;
                background-color: #2a9d8f;
                color: white;
                border-radius: 8px;
                text-decoration: none;
                transition: background-color 0.3s ease;
            '>⬅ Go Back to Login Page</a>
          </div>";
} else {
    echo "❌ Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?> 