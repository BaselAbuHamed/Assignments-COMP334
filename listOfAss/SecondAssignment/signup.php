<?php
session_start();
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Retrieve form data
  $firstName = $_POST["first_name"];
  $lastName = $_POST["last_name"];
  $email = $_POST["email"];
  $gender = $_POST["gender"];
  $birthdate = $_POST["birthdate"];
  $phone = $_POST["phone"];
  $pass = $_POST["password"];

  $dsn = "mysql:host=localhost;dbname=c99ass2_db;charset=utf8mb4";
  $username = "c99basel_db";
  $password = "4mMQrfXkBF@da";

  try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM user WHERE email = :email");
    $stmt->bindParam(':email', $email);

    $stmt->execute();

    $count = $stmt->fetchColumn();

    if ($count > 0) {
      echo "Email already exists. Please choose a different email.";
    } else {
    $stmt = $pdo->prepare("INSERT INTO user(firstName, lastName, email, gender, birthdate, phoneNumber, pass) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$firstName, $lastName, $email, $gender, $birthdate, $phone, $pass]);

    $stmt = $pdo->prepare("SELECT userID FROM user WHERE email = :email");
    $stmt->bindParam(':email', $email);

    $stmt->execute();

    $id = $stmt->fetch();
    
    $_SESSION['userID'] = $id[0];

    header("Location: createProfile.html");
    exit();
    }
    
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
}
?>