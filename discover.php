<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Social Media Site</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
  <?php
  session_start();
  include("connection.php");
  include("functions.php");

  $user_data = check_login($con);

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $user_data['user_id'];
    $statusText = $_POST["status"]; // Use "status" as the input name.

    // Store the status in the database
    $query = "INSERT INTO user_status (user_id, feed_status) VALUES (?, ?)";
    $stmt = $con->prepare($query);
    $stmt->bind_param("is", $user_id, $statusText);

    if ($stmt->execute()) {
      // Successful insertion
      // Redirect to the page to avoid re-submission if the user refreshes
      header("Location: discover.php"); // Replace with the appropriate page name.
    } else {
      die("Query execution failed: " . mysqli_error($con));
    }
  }

  ?>

  <?php include "header.html"; ?>

  <a href="logout.php" style="float: right; padding-right: 15px">Logout</a>
  <h5 style="padding-top: 15px; padding-left: 15px">Hello, <?php echo $user_data['user_name']; ?>!</h5>

  <div id="status" class="status">
    <h4>What's on your mind?</h4>
    <form method="post">
      <input id="statusText" type="text" name="status"><br><br>
      <input type="submit" value="Submit"><br><br>
    </form>
  </div>
  <div class="feed-container">
    <h5 style="padding-left: 15px; padding-top: 15px">My Feed:</h5>
    <?php
    // Fetch and display status posts from the database here
    $user_data = check_login($con);
    $user_id = $user_data['user_id'];

    $query = "SELECT * FROM user_status WHERE user_id = '$user_id' ORDER BY id DESC";
    $stmt = $con->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
      $statusText = htmlspecialchars($row['feed_status'], ENT_QUOTES, 'UTF-8');
      echo "<div class='bubble right'>$statusText</div><br>";
    }
    echo $result;
    ?>
  </div>
 
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
  </script>
</body>

</html>