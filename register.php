<?php
$conn = new mysqli("localhost", "root", "", "forumdb");

if ($conn->connect_error) {
    die("Connection error: " . $conn->connect_error);
} else {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['name'];
        $password = $_POST['password'];

        $sql = "INSERT INTO user (name,password) VALUES ('$name','$password')";
        $result = $conn->query($sql);

        if ($result) {
            echo "Registration Successful";
        } else {
            echo "Error: " . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
</head>
<body>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <input type="text" name="name" id="name">
        <input type="password" name="password" id="password">
        <input type="submit" name="submit" id="submit">
    </form>
</body>
</html>
