<?php 
session_start();

if (isset($_SESSION["user"])) {
    $name = $_SESSION["user"];
    $conn = new mysqli("localhost", "root", "", "forumdb");

    if ($conn->connect_error) {
        die("Connection error: " . $conn->connect_error);
    } else {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Corrected code to use bind_param for the SELECT query
            $stmt = $conn->prepare("SELECT userid FROM user WHERE name = ?");
            $stmt->bind_param("s", $name);
            $stmt->execute();
            $stmt->bind_result($uid);
            $stmt->fetch();
            $stmt->close();

            $category = $_POST['cat_name'];
            $description = $_POST['description'];

            $sql = "INSERT INTO test (uid, cat_name, description) VALUES ('$uid', '$category', '$description')";
            $result = $conn->query($sql);

            if ($result) {
                echo "Successfully created new category";
                $_SESSION['category'] = $category;
                header('location:discussion.php');
            } else {
                echo "Error: " . $conn->error;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Category</title>
</head>
<body>
    <form  action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        Category Name:<input type="text" name="cat_name" id="cat_name">
        <br>
        Description:
        <input type="text" name="description" id="description">
        <input type="submit" name="submit" id="submit">
    </form>
</body>
</html>
