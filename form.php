<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Sản Phẩm</title>
</head>
<body>

<h2>Thêm Sản Phẩm Mới</h2>
<form action="create.php" method="POST">
    <label>ID:</label>
    <input type="number" name="id" required><br><br>

    <label>Tên sản phẩm:</label>
    <input type="text" name="name" required><br><br>

    <label>Loại:</label>
    <select name="type" required>
        <option value="0">Xe đạp</option>
        <option value="1">Xe máy</option>
        <option value="2">Ô tô</option>
    </select><br><br>

    <label>Năm sản xuất:</label>
    <input type="number" name="release_year" min="1900" max="2099" required><br><br>

    <label>Mô tả:</label>
    <textarea name="description" rows="4" cols="50"></textarea><br><br>

    <label>Giá:</label>
    <input type="number" step="0.01" name="price" required><br><br>

    <label>URL hình ảnh:</label>
    <input type="text" name="image_url"><br><br>

    <input type="submit" value="Thêm sản phẩm">
</form>

</body>
</html>
