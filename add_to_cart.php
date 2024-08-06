<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kakes_bakery";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$product_name = $_POST['product_name'];
$price = $_POST['price'];

$sql = "SELECT * FROM cart_items WHERE product_name='$product_name'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $quantity = $row['quantity'] + 1;
    $update_sql = "UPDATE cart_items SET quantity=$quantity WHERE product_name='$product_name'";
    $conn->query($update_sql);
} else {
    $insert_sql = "INSERT INTO cart_items (product_name, price, quantity) VALUES ('$product_name', $price, 1)";
    $conn->query($insert_sql);
}

$conn->close();
?>
