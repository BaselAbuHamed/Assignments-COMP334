<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $title = $_POST["title"];
  $description = $_POST["description"];
  $keywords = $_POST["keywords"];

  $file = $_FILES["file"]["name"];
  $filePath = "uploads/files/" . $file;
  move_uploaded_file($_FILES["file"]["tmp_name"], $filePath);

  $dsn = "mysql:host=localhost;dbname=c99ass2_db;charset=utf8mb4";
  $username = "c99basel_db";
  $password = "4mMQrfXkBF@da";


  try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->prepare("INSERT INTO fileuploaded (userID, title, `description`, keywords, filepath) VALUES (?, ?, ?, ?, ?)");
    $id = $_SESSION['userID'];
    $stmt->execute([$id,$title,$description,$keywords ,$filePath ]);

  }catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }

  header("Location: file_sharing.php");
  exit();
}
?>