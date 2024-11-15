<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get username and password from form
    $username = filter_input(INPUT_POST, 'username');
    $password = filter_input(INPUT_POST, 'password');

    if (!empty($username) && !empty($password)) {
        // Database connection
        $host = "localhost";
        $dbusername = "root";
        $dbpassword = "";
        $dbname = "travel";

        $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } else {
            // Query to check if username and password exist in the database
            $sql = "SELECT * FROM users1 WHERE username = ?";

            // Prepare and bind
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $username); // 's' is for string
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                // Verify password
                if (password_verify($password, $row['password'])) {
                    // Successful login, set session variable
                    $_SESSION['username'] = $username;
                    echo "Logged in successfully!";
                    // Redirect to the dashboard or homepage
                    header("refresh:3; url=index.html");
                    exit();
                } else {
                    echo "Invalid password.";
                }
            } else {
                echo "No user found with that username. Please sign up.";
            }

            $stmt->close();
            $conn->close();
        }
    } else {
        echo "Please fill in both fields.";
    }
}
?>
