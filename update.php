<?php
$servername = "localhost";
$username = "root";
$password = "2102002Lt@@";
$dbname = "Car_management";

// Kết nối đến MySQL
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy giá trị từ form
$id = isset($_POST['id']) ? $_POST['id'] : '';
$name = isset($_POST['name']) ? $_POST['name'] : '';
$description = isset($_POST['description']) ? $_POST['description'] : '';
$price = isset($_POST['price']) ? $_POST['price'] : '';

// Tạo truy vấn SQL để cập nhật thông tin sản phẩm
$sql = "UPDATE products SET ";
$updates = [];

if ($name !== '') {
    $updates[] = "Name = '" . $conn->real_escape_string($name) . "'";
}

if ($description !== '') {
    $updates[] = "description = '" . $conn->real_escape_string($description) . "'";
}

if ($price !== '') {
    $updates[] = "price = '" . $conn->real_escape_string($price) . "'";
}

if (!empty($updates)) {
    $sql .= implode(", ", $updates) . " WHERE ID = " . intval($id);
    $conn->query($sql);
}

$conn->close();

// Chuyển hướng quay lại list.php
header("Location: list.php");
exit();
?>