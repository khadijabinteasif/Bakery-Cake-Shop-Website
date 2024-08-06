<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kakes_bakery";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM cart_items";
$result = $conn->query($sql);

$cart_items = array();
while($row = $result->fetch_assoc()) {
    $cart_items[] = $row;
}

echo json_encode($cart_items);

$conn->close();
?>
