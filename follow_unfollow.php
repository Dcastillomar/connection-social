<?php
session_start();
include("connection.php");
include("functions.php");

$user_data = check_login($con);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_name = $_POST['user_name'];
    $action = $_POST['action'];

    if ($action === 'follow') {
        // Retrieve the friend's user_id
        $query = "SELECT user_id FROM users WHERE user_name = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("s", $user_name);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $friend_user_id = $row['user_id'];

            // Perform the INSERT operation to add a friend in the user_friends table
            $query = "INSERT INTO user_friends (user_id, friend_id, friends_name) VALUES (?, ?, ?)";
            $stmt = $con->prepare($query);
            $stmt->bind_param("iis", $user_data['user_id'], $friend_user_id, $user_name);

            if ($stmt->execute()) {
                echo 'followed';
            } else {
                echo 'error'; // You can handle errors as needed
            }
        } else {
            echo 'error'; // Friend not found
        }
    } elseif ($action === 'unfollow') {
        // Perform the DELETE operation to remove the entire row representing the friendship
        $query = "DELETE FROM user_friends WHERE user_id = ? AND friends_name = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("is", $user_data['user_id'], $user_name);

        if ($stmt->execute()) {
            echo 'unfollowed';
        } else {
            echo 'error'; // You can handle errors as needed
        }
    }
} else {
    // Handle invalid request
    http_response_code(400);
    echo 'Invalid request';
}