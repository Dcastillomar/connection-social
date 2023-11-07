<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Friends</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function () {
        // Handle button clicks
        $('.follow-button').on('click', function () {
            var userName = $(this).siblings('p').text().replace('User Name: ', '').trim();
            var action = $(this).text().toLowerCase();

            $.ajax({
                type: "POST",
                url: "follow_unfollow.php",
                data: {
                    user_name: userName,
                    action: action
                },
                success: function (response) {
                    if (response === 'followed' || response === 'unfollowed') {
                        location.reload(); // Refresh the entire page
                    }
                }
            });
        });
    });
        
    </script>
</head>

<body>
    <?php
    //checking if logged in
    session_start();
    include("connection.php");
    include("functions.php");

    $user_data = check_login($con);
    ?>

    <?php include "header.html"; ?>
    <div>
        <a href="logout.php" style="float: right; padding-right: 15px">Logout</a>
        <h5 style="padding-left: 15px; padding-top: 15px">Following:</h5>
        <!-- finding friends and displaying their name and most recent status -->
        <div id="feed-item">

            <?php
            //query to go to the user_friends table and find all friends where the user_id is in it
            $user_id = $user_data['user_id'];

            $query = "SELECT friends_name FROM user_friends WHERE user_id = ?";
            $stmt = $con->prepare($query);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();

            $friends_names = array(); // Initialize an array to store the friend names

            while ($row = $result->fetch_assoc()) {
                $friends_names[] = htmlspecialchars($row['friends_name'], ENT_QUOTES, 'UTF-8');
            }

            // Fetch friend IDs
            $friend_ids = array();

            $query = "SELECT friend_ID FROM user_friends WHERE user_id = ?";
            $stmt = $con->prepare($query);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                $friend_ids[] = htmlspecialchars($row['friend_ID'], ENT_QUOTES, 'UTF-8');
            }
            // Display friend names and their statuses
            for ($i = 0; $i < count($friend_ids); $i++) {
                $friend_id = $friend_ids[$i];

                $query = "SELECT * FROM user_status WHERE user_id = ? ORDER BY id DESC LIMIT 1";
                $stmt = $con->prepare($query);
                $stmt->bind_param("i", $friend_id);
                $stmt->execute();
                $result = $stmt->get_result();

                while ($row = $result->fetch_assoc()) {
                    $friends_status = htmlspecialchars($row['feed_status'], ENT_QUOTES, 'UTF-8');
                    echo "<div class='bubble left'>" . $friends_names[$i] . "<br>" . $friends_status . "</div><br>";
                }
            }

            //friend profiles and follow/unfollow button
            $user_id = $user_data['user_id'];

            $query = "SELECT user_name FROM users";
            $stmt = $con->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();

            $user_names = array(); // Initialize an array to store user names

            while ($row = $result->fetch_assoc()) {
                $user_name = htmlspecialchars($row['user_name'], ENT_QUOTES, 'UTF-8');

                // Exclude the currently logged-in user from the list
                if ($user_name !== $user_data['user_name']) {
                    $user_names[] = $user_name;
                }
            }

            // Fetch the friend names from the user_friends table
            $friend_names = array();

            $query = "SELECT friends_name FROM user_friends WHERE user_id = ?";
            $stmt = $con->prepare($query);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                $friend_names[] = htmlspecialchars($row['friends_name'], ENT_QUOTES, 'UTF-8');
            }

            // Display user names and "Follow" or "Unfollow" buttons
            foreach ($user_names as $user_name) {
                $isFriend = in_array($user_name, $friend_names);
            
                if ($isFriend) {
                    $buttonText = "Unfollow";
                } else {
                    $buttonText = "Follow";
                }
            
                echo "<div class='friend-info'>";
                echo "<p>User Name: $user_name</p>";
                echo "<button class='follow-button'>$buttonText</button>";
                echo "</div>";
            }
            ?>
        </div>

</body>

</html>