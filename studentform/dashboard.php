<?php
session_start();
if (!isset($_SESSION['student']) || !isset($_SESSION['photo'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Dashboard</title>
  <style>
    body {
      background: #ffe8d6;
      font-family: 'Poppins', sans-serif;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      margin: 0;
    }

    .photo-container img {
      width: 160px;
      height: 160px;
      object-fit: cover;
      border-radius: 50%;
      border: 4px solid #e76f51;
      margin-bottom: 20px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    }

    h2 {
      color: #6a040f;
      margin-bottom: 10px;
    }

    p {
      font-size: 16px;
      color: #333;
      margin: 5px 0 25px;
    }

    a {
      padding: 10px 20px;
      background-color: #e76f51;
      color: white;
      text-decoration: none;
      border-radius: 10px;
      transition: background-color 0.3s;
    }

    a:hover {
      background-color: #d62828;
    }
  </style>
</head>
<body>

  <div class="photo-container">
    <img src="uploads/<?php echo htmlspecialchars($_SESSION['photo']); ?>" alt="Student Photo">
  </div>

  <h2>Welcome, <?php echo htmlspecialchars($_SESSION['student']); ?>!</h2>
  <p>Email: <?php echo htmlspecialchars($_SESSION['email']); ?></p>

  <a href="logout.php">Logout</a>

</body>
</html>
