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

// Truy vấn lấy tất cả sản phẩm và sắp xếp theo ID tăng dần
$sql = "SELECT * FROM products ORDER BY ID ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh Sách Sản Phẩm</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        .action-icons {
            display: flex;
            gap: 10px;
        }
        .action-icons a {
            color: #000;
            text-decoration: none;
        }
        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
            padding-top: 60px;
        }
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>

<h2>Danh Sách Sản Phẩm</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Tên Sản Phẩm</th>
        <th>Loại</th>
        <th>Năm Sản Xuất</th>
        <th>Giá</th>
        <th>Mô Tả</th>
        <th>Hình Ảnh</th>
        <th>Hành Động</th>
    </tr>

    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {

            switch ($row["type"]) {
                case 0:
                    $typeName = "Xe đạp";
                    break;
                case 1:
                    $typeName = "Xe máy";
                    break;
                case 2:
                    $typeName = "Ô tô";
                    break;
                default:
                    $typeName = "Không xác định";
            }

            echo "<tr>
                    <td>{$row['ID']}</td>
                    <td>{$row['Name']}</td>
                    <td>{$typeName}</td>
                    <td>{$row['release_year']}</td>
                    <td>{$row['price']} VND</td>
                    <td>{$row['description']}</td>
                    <td><img src='{$row['image_url']}' width='100' height='60' alt='Hình ảnh'></td>
                    <td class='action-icons'>
                        <a href='#' class='edit-btn' data-id='{$row['ID']}' data-name='{$row['Name']}' data-description='{$row['description']}' data-price='{$row['price']}'><i class='fas fa-edit'></i></a>
                        <a href='delete.php?id={$row['ID']}'><i class='fas fa-trash-alt'></i></a>
                    </td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='8'>Không có sản phẩm nào</td></tr>";
    }
    $conn->close();
    ?>
</table>


<div id="myModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <form id="editForm" action="update.php" method="post">
        <input type="hidden" name="id" id="productId">
        <div>
            <label for="productName">Tên Sản Phẩm:</label>
            <input type="text" name="name" id="productName">
        </div>
        <div>
            <label for="productDescription">Mô Tả:</label>
            <input type="text" name="description" id="productDescription">
        </div>
        <div>
            <label for="productPrice">Giá:</label>
            <input type="text" name="price" id="productPrice">
        </div>
        <div>
            <input type="submit" value="Cập Nhật">
        </div>
    </form>
  </div>
</div>

<script>

var modal = document.getElementById("myModal");


var span = document.getElementsByClassName("close")[0];


span.onclick = function() {
  modal.style.display = "none";
}


window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}


var editButtons = document.getElementsByClassName('edit-btn');


for (var i = 0; i < editButtons.length; i++) {
    editButtons[i].onclick = function() {
        var id = this.getAttribute('data-id');
        var name = this.getAttribute('data-name');
        var description = this.getAttribute('data-description');
        var price = this.getAttribute('data-price');


        document.getElementById('productId').value = id;
        document.getElementById('productName').value = name;
        document.getElementById('productDescription').value = description;
        document.getElementById('productPrice').value = price;


        modal.style.display = "block";
    }
}
</script>

</body>
</html>