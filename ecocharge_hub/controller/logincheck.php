<?php
// Start session to manage session variables
session_start();

// Include database connection
include_once('../model/db_connection.php');

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = $_POST['name'];
    $password = $_POST['pwd'];

    // Establish database connection and sanitize inputs
    $conn = connection();

    // Query the database using the `get` function
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = get($query);

    if (!empty($result)) {
        // User exists, fetch the first result
        $user = $result[0];

        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Store user details in session and redirect
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_type'] = $user['userType'];

            // Redirect based on user type
            if ($user['userType'] == 'Environmentalist') {
                header('Location: ../view/environmentalist_dashboard.php');
            } elseif ($user['userType'] == 'Supervisor') {
                header('Location: ../view/supervisor_dashboard.php');
            }
            exit();
        } else {
            // Invalid password
            $_SESSION['error'] = 'Invalid username or password!';
            header('Location: ../view/login.php');
            exit();
        }
    } else {
        // User not found
        $_SESSION['error'] = 'Invalid username or password!';
        header('Location: ../view/login.php');
        exit();
    }
} else {
    // Redirect to login page if form is not submitted
    header('Location: ../view/login.php');
    exit();
}
