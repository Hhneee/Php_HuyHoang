<?php
include '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $maSV = $_POST["MaSV"];
    $hoTen = $_POST["HoTen"];
    $gioiTinh = $_POST["GioiTinh"];
    $ngaySinh = $_POST["NgaySinh"];
    $maNganh = $_POST["MaNganh"];
    $hinhAnh = ""; // Khởi tạo đường dẫn ảnh

    // Xử lý upload ảnh
    if (!empty($_FILES["Hinh"]["name"])) {
        $targetDir = "../images/"; // Thư mục lưu ảnh
        $fileName = basename($_FILES["Hinh"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        $allowTypes = array("jpg", "jpeg", "png");
        if (in_array($fileType, $allowTypes)) {
            if (move_uploaded_file($_FILES["Hinh"]["tmp_name"], $targetFilePath)) {
                $hinhAnh = $targetFilePath;
            } else {
                echo "Lỗi khi tải ảnh.";
            }
        } else {
            echo "Chỉ chấp nhận file JPG, JPEG, PNG.";
        }
    }

    // Chèn dữ liệu vào database
    $sql = "INSERT INTO SinhVien (MaSV, HoTen, GioiTinh, NgaySinh, MaNganh, Hinh) VALUES ('$maSV', '$hoTen', '$gioiTinh', '$ngaySinh', '$maNganh', '$hinhAnh')";
    if ($conn->query($sql) === TRUE) {
        header("Location: qlindex.php");
        exit();
    } else {
        echo "Lỗi: " . $conn->error;
    }
}

$nganhHoc = $conn->query("SELECT * FROM NganhHoc");
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm Sinh viên</title>
    <style>
    /* Reset và thiết lập chung */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Be Vietnam Pro', sans-serif;
        background: linear-gradient(to bottom, #fdfcf3, #e5d9c8);
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh; /* Chiều cao tối thiểu là toàn màn hình */
        margin: 0;
        padding: 20px;
    }

    /* Container chính */
    .container {
        background: #fff8e7;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        width: 90%;
        max-width: 500px; /* Giới hạn chiều rộng tối đa */
        text-align: center;
        animation: fadeIn 1s ease-in-out;
    }

    h2 {
        font-size: 24px;
        color: #6b4f36;
        margin-bottom: 25px;
    }

    /* Nhóm input */
    .input-group {
        margin-bottom: 20px;
        text-align: left;
    }

    .input-group label {
        font-weight: 500;
        color: #6b4f36;
        margin-bottom: 5px;
        display: block;
    }

    .input-group input, .input-group select, .input-group input[type="file"] {
        width: 100%;
        padding: 10px;
        border: 1px solid #b8a398;
        border-radius: 6px;
        background: #fdfaf4;
        font-size: 14px;
        box-sizing: border-box;
        transition: all 0.3s ease;
    }

    .input-group input:focus, .input-group select:focus {
        border-color: #a37d65;
        box-shadow: 0 0 8px rgba(163, 125, 101, 0.5);
        outline: none;
    }

    /* Nút bấm */
    .btn {
        display: inline-block;
        padding: 12px 20px;
        font-size: 16px;
        font-weight: bold;
        text-align: center;
        border-radius: 6px;
        cursor: pointer;
        text-decoration: none;
        width: 48%;
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
        transition: background-color 0.3s ease, transform 0.3s ease;
    }

    .btn-primary {
        background: #007BFF; /* Màu xanh */
        color: white;
    }

    .btn-primary:hover {
        background: #0056b3;
        transform: scale(1.05);
    }

    .btn-secondary {
        background: #c0392b; /* Màu đỏ */
        color: white;
    }

    .btn-secondary:hover {
        background: #a93226;
        transform: scale(1.05);
    }

    /* Hiệu ứng xuất hiện */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
</head>
<body>
    <div class="container">
        <h2>Thêm Sinh viên</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="input-group">
                <label>Mã SV:</label> 
                <input type="text" name="MaSV" required>
            </div>
            <div class="input-group">
                <label>Họ tên:</label> 
                <input type="text" name="HoTen" required>
            </div>
            <div class="input-group">
                <label>Giới tính:</label>
                <select name="GioiTinh">
                    <option value="Nam">Nam</option>
                    <option value="Nữ">Nữ</option>
                </select>
            </div>
            <div class="input-group">
                <label>Ngày sinh:</label> 
                <input type="date" name="NgaySinh" required>
            </div>
            <div class="input-group">
                <label>Ngành học:</label>
                <select name="MaNganh">
                    <?php while ($row = $nganhHoc->fetch_assoc()) { ?>
                        <option value="<?= $row['MaNganh'] ?>"><?= $row['TenNganh'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="input-group">
                <label>Chọn ảnh:</label>
                <input type="file" name="Hinh">
            </div>
            <button type="submit" class="btn btn-primary">Thêm</button>
            <a href="../index.php" class="btn btn-secondary">Quay lại Trang Chính</a>
        </form>
    </div>
</body>
</html>
