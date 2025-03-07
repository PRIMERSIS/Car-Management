<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "car_management";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Lấy giá trị từ form
$type = isset($_GET['type']) ? $_GET['type'] : '';
$search = isset($_GET['search']) ? $_GET['search'] : '';
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$limit = 5;
$offset = ($page - 1) * $limit;

// Tạo truy vấn SQL với điều kiện lọc
$sql = "SELECT * FROM products WHERE 1=1";

if ($type !== '') {
    $sql .= " AND type = " . intval($type);
}

if ($search !== '') {
    $sql .= " AND name LIKE '%" . $conn->real_escape_string($search) . "%'";
}

// Đếm tổng số sản phẩm
$total_sql = "SELECT COUNT(*) as total FROM products WHERE 1=1";
if ($type !== '') {
    $total_sql .= " AND type = " . intval($type);
}
if ($search !== '') {
    $total_sql .= " AND name LIKE '%" . $conn->real_escape_string($search) . "%'";
}
$total_result = $conn->query($total_sql);
$total_row = $total_result->fetch_assoc();
$total_products = $total_row['total'];
$total_pages = ceil($total_products / $limit);

// Thêm giới hạn và offset vào truy vấn SQL
$sql .= " LIMIT $limit OFFSET $offset";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .card-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .card {
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 16px;
            width: 200px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .card img {
            max-width: 100%;
            border-radius: 8px;
        }
        .card h3 {
            margin: 0 0 10px;
        }
        .card p {
            margin: 5px 0;
        }
        .pagination {
            margin-top: 20px;
        }
        .pagination a {
            margin: 0 5px;
            padding: 8px 16px;
            text-decoration: none;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .pagination a.active {
            background-color: #007bff;
            color: white;
            border: 1px solid #007bff;
        }
    </style>
</head>
<body>
<h1>Danh Sách Sản Phẩm</h1>
<!-- Button thêm sản phẩm -->
<a href="form.php">
    <button style="margin-bottom: 10px; padding: 10px 15px; font-size: 16px;">Thêm Sản Phẩm</button>
</a>

<h2>Lọc sản phẩm</h2>

<div>
    <form action="index.php" method="Get">
        <div>
            <select name="type">
                <option value="">Tất cả</option>
                <option value="0" <?php if ($type === '0') echo 'selected'; ?>>Xe đạp</option>
                <option value="1" <?php if ($type === '1') echo 'selected'; ?>>Xe máy</option>
                <option value="2" <?php if ($type === '2') echo 'selected'; ?>>Ô tô</option>
            </select>
        </div>
        <input type="text" name="search" placeholder="Tìm kiếm" value="<?php echo htmlspecialchars($search); ?>">
        <input type="submit" value="Tìm">
    </form>
</div>

<div class="card-container">
<?php
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $id = isset($row["ID"]) ? $row["ID"] : "Không có ID";
        $name = isset($row["Name"]) ? $row["Name"] : "Không có tên";
        $release_year = isset($row["release_year"]) ? $row["release_year"] : "Không có năm sản xuất";
        $price = isset($row["price"]) ? $row["price"] : "Không có giá";
        $description = isset($row["description"]) ? $row["description"] : "Không có mô tả";
        $image_url = isset($row["image_url"]) ? $row["image_url"] : "Không có hình ảnh";

        $typeName = "Không xác định";
        if (isset($row["type"])) {
            switch ($row["type"]) {
                case 0: $typeName = "Xe đạp"; break;
                case 1: $typeName = "Xe máy"; break;
                case 2: $typeName = "Ô tô"; break;
            }
        }

        echo "<div class='card'>
                <img src='{$image_url}' alt='Hình ảnh'>
                <h3>{$name}</h3>
                <p>Loại: {$typeName}</p>
                <p>Năm sản xuất: {$release_year}</p>
                <p>Giá: {$price} VND</p>
                <p>Mô tả: {$description}</p>
              </div>";
    }
} else {
    echo "Không có sản phẩm nào.";
}
$conn->close();
?>
</div>

<div class="pagination">
<?php
for ($i = 1; $i <= $total_pages; $i++) {
    $active = ($i == $page) ? 'active' : '';
    echo "<a class='$active' href='index.php?page=$i&type=$type&search=$search'>$i</a>";
}
?>
</div>

</body>
</html>