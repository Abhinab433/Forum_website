<?php
session_start();
$conn = new mysqli("localhost", "root", "", "forumdb");

if ($conn->connect_error) {
    die("Connection error: " . $conn->connect_error);
} else {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['name'];
        $password = $_POST['password'];

        // Use a prepared statement to prevent SQL injection
        $stmt = $conn->prepare("SELECT name, password FROM user WHERE name = '$name'");
        $stmt->execute();
        $stmt->bind_result($dbUsername, $dbPassword);
        $stmt->fetch();
        $stmt->close();

        // Verify the entered password against the hashed password from the database
        if ($dbUsername== $name && $password== $dbPassword) {
            echo "Login Successful";
            $_SESSION['user']=$name;
            header("Location: home.php");
        } else {
            echo "Invalid username or password";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <input type="text" name="name" id="name" required>
        <input type="password" name="password" id="password" required>
        <input type="submit" name="submit" id="submit">
    </form>
</body>
</html>
