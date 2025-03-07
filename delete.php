<?php
$servername = "localhost";
$username = "root";
$password = "2102002Lt@@";
$dbname = "Car_management";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}


$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    
    $sql = "DELETE FROM products WHERE ID = " . $id;
    $conn->query($sql);
}

$conn->close();


header("Location: list.php");
exit();
?>