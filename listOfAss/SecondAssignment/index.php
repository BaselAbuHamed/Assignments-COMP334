<?php
session_start();
                if(isset($_GET['send'])){
                  $keywords=$_GET['keywords'];
                  $author=$_GET['author'];

                  $dsn = "mysql:host=localhost;dbname=c99ass2_db;charset=utf8mb4";
  $username = "c99basel_db";
  $password = "4mMQrfXkBF@da";


                  try {
                    $pdo = new PDO($dsn, $username, $password);
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                  
                    
                    
                    $sql = "SELECT * FROM user WHERE CONCAT(firstName, ' ', lastName) = :author";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':author', $author);
                    $stmt->execute();
                  

                    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);


                  
                  } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                  }
                }?>

<!DOCTYPE html>
<html>
<head>
  <title>Home Page</title>
</head>
<body>
<!-- ----------------------------------------------------------------------------------------------- -->
<h1>Login</h1>
    <form method="POST" action="login.php">
        <fieldset>
            <legend>login</legend>

            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" required><br>

            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required><br><br>

            <button type="submit">Login</button>

            <a href="signup.html">singup</a><br>
        </fieldset>
    </form>
<!-- ----------------------------------------------------------------------------------------------- -->
  <h2>Search Results</h2>

  <form method="GET">
        <fieldset>
            <legend>Search</legend>

            <input type="text" name="keywords" placeholder="Enter keywords">
            <input type="text" name="author" placeholder="Enter author name">

            <input type="submit" name= "submit" value="Search">
            <br><br>
                </tr>
                <?php foreach ($results as $result): ?>
                <tr>
                  <td><?php echo $result['firstName']; ?></td>
                  <td><?php echo $result['lastName']; ?></td>
                  <td><?php echo $result['email']; ?></td>
                  <!-- Display additional user details in respective columns -->
                </tr>
                <?php endforeach; ?>
              </table>
          </fieldset>
        </fieldset>
    </form>
</body>
</html>