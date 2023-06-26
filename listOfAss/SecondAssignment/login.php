<?php
session_start();
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Retrieve form data
  $email = $_POST["email"];
  $pass = $_POST["password"];

  $dsn = "mysql:host=localhost;dbname=c99ass2_db;charset=utf8mb4";
  $username = "c99basel_db";
  $password = "4mMQrfXkBF@da";


  try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare("SELECT * FROM user WHERE email = ? AND pass = ?");
    $stmt->execute([$email, $pass]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt = $pdo->prepare("SELECT userID FROM user WHERE email = :email");
    $stmt->bindParam(':email', $email);

    $stmt->execute();

    $id = $stmt->fetch();
    
    $_SESSION['userID'] = $id[0];

    if ($user) {

     
      
      $_SESSION['userID'] = $user['userID'];
      $_SESSION['firstName'] = $user['firstName'];
      $_SESSION['lastName'] = $user['lastName'];
      $_SESSION['email'] = $email;

      header("Location: file_sharing.php");
      exit();  
    } 
    else {

      echo "Invalid email or password.";
    }
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
}
?>