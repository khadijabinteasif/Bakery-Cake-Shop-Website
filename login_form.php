<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kakes_bakery";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username_email = $_POST['username'];
    $password = $_POST['password'];

    // Check if the user already exists
    $sql = "SELECT * FROM users WHERE username_email=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username_email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User exists, check password
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            echo "<script>alert('Login Successful!');</script>";
        } else {
            echo "<script>alert('Incorrect password.');</script>";
        }
    } else {
        // User does not exist, insert new user
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username_email, password) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $username_email, $hashed_password);
        
        if ($stmt->execute()) {
            echo "<script>alert('Sign up Successful!');</script>";
        } else {
            echo "<script>alert('Error: " . $sql . "<br>" . $conn->error . "');</script>";
        }
    }

    $stmt->close();
}

$conn->close();
?>
