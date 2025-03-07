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

// Kiểm tra xem dữ liệu đã được gửi từ form chưa
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $name = $_POST["name"];
    $type = $_POST["type"];
    $release_year = $_POST["release_year"];
    $price = $_POST["price"];
    $description = $_POST["description"];
    $image_url = $_POST["image_url"];

    // Chuẩn bị câu lệnh SQL INSERT
    $sql = "INSERT INTO products (ID, Name, type, release_year, price, description, image_url) 
            VALUES ('$id', '$name', '$type', '$release_year', '$price', '$description', '$image_url')";

    if ($conn->query($sql) === TRUE) {
        echo "Thêm sản phẩm thành công!";
        header("Location: list.php"); // Chuyển về trang danh sách sản phẩm
        exit();
    } else {
        echo "Lỗi: " . $conn->error;
    }
}

$conn->close();
?>
