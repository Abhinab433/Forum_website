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
    <style> 
        body {
            font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: rgb(07, 45, 74);
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100vh; /* Ensure the full height of the viewport is covered */
    margin: 0;
}
form{
    background-color: green;
    border: 1px solid black;
    padding: 40px;
   
}

.style1 {
    color: lightgoldenrodyellow;
    font-size: 30px;
    font-weight: bolder;
    text-align: center; /* Center the text within the container */
}

#submit {
    padding: 10px;
    border: 1px solid lightsalmon;
    background-color: lightcyan;
    
    margin: 20px; margin-left: 215px;
    color: limegreen;
    font-size: 30px;
    font-weight: bolder;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}
input{
    margin: 20px;
}
#cat_name,#description  {
    height: 45px;
    width: 250px;
    border: 1px solid lightsalmon;
    font-size: 30px;       
    font-weight: bolder;
    color: limegreen;
  
    box-sizing: border-box;
}
.y{
    border-radius: 20px;
}
#description{
    margin-left: 50px;
}
#cat_name{
    margin-left:25px ;
}

    </style>
</head>
<body>
    <form  action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="y">
        Category Name:<input type="text" name="cat_name" id="cat_name"class="y">
        <br>
        Description: <input type="text" name="description" id="description" class="y">
        <br>
        <input type="submit" name="submit" id="submit" class="y">
    </form>
</body>
</html>
