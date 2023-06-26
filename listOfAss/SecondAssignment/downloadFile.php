<?php
$fileId = $_GET["file_id"];
$connection = mysqli_connect("localhost", "username", "password", "database_name");
$query = "SELECT * FROM files WHERE id = $fileId";
$result = mysqli_query($connection, $query);
$fileData = mysqli_fetch_assoc($result);

if ($fileData) {
  $filePath = $fileData["file_path"];
  
  header('Content-Type: application/octet-stream');
  header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
  header('Content-Length: ' . filesize($filePath));

  readfile($filePath);
  exit();
} else {
  // File not found
  echo "File not found.";
}
?>