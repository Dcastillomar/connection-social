<?php
session_start();
include("connection.php");
include("functions.php");

checkLoggedIn();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $user_name = $_POST['user_name'];
  $email = $_POST['email'];
  $password = $_POST['password'];

  if (!empty($user_name) && !empty($password)) {
    
    $user_id = random_num(20);
    $query = "insert into users (user_id, user_name, email, password) values ('$user_id', '$user_name','$email','$password')";
    
    mysqli_query($con, $query);
    
    header("Location: login.php");
    die;

  } else {
    echo "Please enter valid information";
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Signup</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<?php include "header.html" ?>

<body>
  <br>
  <div id="box" class="formborder">
    <form method="post">
      Name:&nbsp;&nbsp;&nbsp;&nbsp;
      <input type="text" name="user_name"><br><br>
      Email:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="text" name="email"><br><br>
      Password: <input type="password" name="password"><br><br>
      <input type="submit" value="Sign Up"><br><br>
      <a href="login.php" style="color:white">Click to Login</a>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>

</html>