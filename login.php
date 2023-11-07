<?php
session_start();
include("connection.php");
include("functions.php");

checkLoggedIn();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $email = $_POST['email'];
  $password = $_POST['password'];

  if (!empty($email) && !empty($password)) {

    $query = "select * from users where email = '$email' limit 1";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) 
    {
      $user_data = mysqli_fetch_assoc($result);
      
      if($user_data['password'] === $password) 
      {
        $_SESSION['user_id'] = $user_data['user_id'];
        
        header("Location: discover.php");
        die;
      }
    }
    echo "Wrong username or password";
  } else {
    echo "wrong username or password";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<?php include "header.html" ?>

<body>
  <br>
  <div id="box" class="formborder">
    <form method="post">
      Email:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="email"><br><br>
      Password: <input type="password" name="password"><br><br>
      <input type="submit" value="Login"><br><br>
      <a href="signup.php" style="color:white">Click to Sign Up</a>
    </form>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
  </script>
</body>

</html>