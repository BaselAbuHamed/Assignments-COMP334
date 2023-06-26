<?php
session_start();

$dsn = "mysql:host=localhost;dbname=c99ass2_db;charset=utf8mb4";
$username = "c99basel_db";
$password = "4mMQrfXkBF@da";


try {
  $pdo = new PDO($dsn, $username, $password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $stmt = $pdo->prepare("SELECT * FROM fileuploaded");
  $stmt->execute();
  $files = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $stmt = $pdo->prepare("SELECT * FROM userprofile WHERE userID = ?");
  $stmt->execute([$_SESSION['userID']]);
  $userProfile = $stmt->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}

?>

<!DOCTYPE html>
<html>
<head>
  <title>File Sharing</title>
</head>
<body>
<h1>Welcome, <?php echo $_SESSION['firstName']; ?>!</h1>

<form>
    <fieldset>
        <legend>User Profile</legend>
        <?php if ($userProfile): ?>
  <p>Name: <?php echo $userProfile['name']; ?></p>
  <p>Bio: <?php echo $userProfile['bio']; ?></p>
  <img src="<?php echo $userProfile['photo']; ?>" alt="Profile Image" style="width: 20%; height: 20%;">

<?php else: ?>
  <p>No profile details found. Please create your profile.</p>
  <a href="createProfile.html">Create Profile</a>
<?php endif; ?>

    </fieldset>
</form>


<h2>Upload File</h2>
    <form method="POST" action="uploadFile.php">
        <fieldset>
            <legend>upload</legend>
            <label for="title">Title:</label><br>
            <input type="text" id="title" name="title" required>
            <br>
            <label for="description">Description:</label><br>
            <input type="text" id="description" name="description" required>
            <br>
            <label for="keywords">Keywords:</label><br>
            <input type="text" id="keywords" name="keywords" required>
            <br>
            <label for="file">File:</label><br>
            <input type="file" id="file" name="file" required>
            <br><br>
            <button type="submit">Upload File</button>

        </fieldset>
    </form>
  <h1>File Sharing</h1>

  <form>
    <fieldset>
        <legend>Uploaded Files</legend>

        <table border="1px">
            <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Keywords</th>
            <th></th>
            </tr>
            <?php foreach ($files as $file): ?>
            <tr>
            <td><?php echo $file['title']; ?></td>
            <td><?php echo $file['description']; ?></td>
            <td><?php echo $file['keywords']; ?></td>
            <td><a href="<?php echo $file['filepath']; ?>" download>Download</a></td>
            </tr>
    <?php endforeach; ?>
  </table>
    </fieldset>
  </form>
</body>
</html>