<?php
session_start();

if (!isset($_SESSION["user"])) {
    header("Location: home.php");
}

if (isset($_SESSION["user"])) {
    $user = $_SESSION["user"];
    $conn = new mysqli("localhost", "root", "", "forumdb");

    if ($conn->connect_error) {
        die("Connection error: " . $conn->connect_error);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $category = $_POST['selected_category'];

    $_SESSION['category'] = $category;

    header('Location: discussion.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Options</title>
    <link rel="stylesheet" href="homestyle.css">
</head>

<body>
    <?php
    $realUsername = "Anush";
    ?>

    <div class="username">Hey,
        <?php echo $realUsername; ?>
    </div>

    <div class="container">
        <h1>Welcome to my forum Website!</h1>
        <div class="create_cat"><a href="create_catform.php">Create New Category</a></div>
        <div class="select">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="categoryForm">
                <?php
                // category ko name fetch garera select gariyeko category ko name laai store garne
                $sql = "SELECT cat_name from test ";
                $result = $conn->query($sql);
                echo "<select name='selected_category' id='select' onchange='this.form.submit()'>";
                if ($result) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option>" . $row['cat_name'] . "</option>";
                    }
                }
                echo "</select>";
                ?>
            </form>
        </div>
    </div>

</body>

</html>
