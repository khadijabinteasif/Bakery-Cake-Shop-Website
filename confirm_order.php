<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kakes_bakery";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT SUM(price * quantity) AS total FROM cart_items";
$result = $conn->query($sql);
$total = $result->fetch_assoc()['total'];

$sql = "DELETE FROM cart_items";
$conn->query($sql);

echo json_encode(array("total" => $total));

$conn->close();
?>
