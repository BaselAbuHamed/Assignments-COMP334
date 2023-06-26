<?php
 session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST["name"];
  $bio = $_POST["bio"];
  $photo = $_FILES["photo"]["name"];
  $cv = $_FILES["cv"]["name"];
  $areaOfExperience = $_POST["area_of_experience"];
  $experienceLevel = $_POST["experience_level"];
  $areaOfInterest = $_POST["area_of_interest"];

  
  $photoPath = "uploads/photos/" . $photo;
  $cvPath = "uploads/cvs/" . $cv;
  move_uploaded_file($_FILES["photo"]["tmp_name"], $photoPath);
  move_uploaded_file($_FILES["cv"]["tmp_name"], $cvPath);

  $dsn = "mysql:host=localhost;dbname=c99ass2_db;charset=utf8mb4";
  $username = "c99basel_db";
  $password = "4mMQrfXkBF@da";

  try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt =$pdo->prepare("INSERT INTO userprofile(userID,name,photo,cv,experience,experienceLevel,interestOf,bio) VALUES (?, ?, ?, ?, ?, ?, ? ,? )" );
    $id = $_SESSION['userID'];
    $stmt->execute([$id,$name,$photoPath,$cvPath ,$areaOfExperience ,$experienceLevel,$areaOfInterest,$bio]);
    
    header("Location: index.php");
    exit();
  }catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
}
?>