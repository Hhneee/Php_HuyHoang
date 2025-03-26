<?php
include '../config/db.php';

$maSV = $_GET["id"];
$result = $conn->query("SELECT * FROM SinhVien WHERE MaSV = '$maSV'");
$row = $result->fetch_assoc();

// Lấy danh sách ngành học từ CSDL
$nganhHoc = $conn->query("SELECT * FROM NganhHoc");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $hoTen = $_POST["HoTen"];
    $gioiTinh = $_POST["GioiTinh"];
    $ngaySinh = $_POST["NgaySinh"];
    $maNganh = $_POST["MaNganh"];

    // Xử lý upload ảnh nếu có
    if (!empty($_FILES["Hinh"]["name"])) {
        $targetDir = "../images/"; 
        $fileName = basename($_FILES["Hinh"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        $allowTypes = array("jpg", "jpeg", "png");
        if (in_array($fileType, $allowTypes)) {
            if (move_uploaded_file($_FILES["Hinh"]["tmp_name"], $targetFilePath)) {
                $sql = "UPDATE SinhVien SET HoTen='$hoTen', GioiTinh='$gioiTinh', NgaySinh='$ngaySinh', MaNganh='$maNganh', Hinh='$targetFilePath' WHERE MaSV='$maSV'";
            } else {
                echo "Lỗi khi tải ảnh.";
            }
        } else {
            echo "Chỉ chấp nhận file JPG, JPEG, PNG.";
        }
    } else {
        $sql = "UPDATE SinhVien SET HoTen='$hoTen', GioiTinh='$gioiTinh', NgaySinh='$ngaySinh', MaNganh='$maNganh' WHERE MaSV='$maSV'";
    }

    if ($conn->query($sql) === TRUE) {
        header("Location: qlindex.php");
        exit();
    } else {
        echo "Lỗi khi cập nhật sinh viên: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa Sinh viên</title>
    <style>
    /* Reset CSS */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Be Vietnam Pro', sans-serif;
        background: linear-gradient(to bottom, #fefcf3, #e5d9c8);
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh; /* Đảm bảo chiều cao toàn màn hình */
        margin: 0;
        padding: 20px;
    }

    /* Container chính */
    .container {
        background: #fff8e7;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        text-align: center;
        width: 90%;
        max-width: 500px; /* Giới hạn chiều rộng */
        animation: fadeIn 1s ease-in-out;
    }

    h2 {
        font-size: 24px;
        color: #6b4f36;
        margin-bottom: 20px;
    }

    .profile-img {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #d4b483;
        margin-bottom: 20px;
    }

    .input-group {
        margin-bottom: 15px;
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
        background-color: #007BFF;
        color: white;
        transition: background-color 0.3s ease, transform 0.3s ease;
    }

    .btn:hover {
        background-color: #0056b3;
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
        <h2>Sửa Sinh viên</h2>
        <img class="profile-img" src="<?= !empty($row['Hinh']) ? $row['Hinh'] : '../images/default.jpeg' ?>" alt="Ảnh Sinh viên">
        <form method="POST" enctype="multipart/form-data">
            <div class="input-group">
                <label>Họ tên:</label> 
                <input type="text" name="HoTen" value="<?= $row['HoTen'] ?>" required>
            </div>
            <div class="input-group">
                <label>Giới tính:</label>
                <select name="GioiTinh">
                    <option value="Nam" <?= $row['GioiTinh'] == 'Nam' ? 'selected' : '' ?>>Nam</option>
                    <option value="Nữ" <?= $row['GioiTinh'] == 'Nữ' ? 'selected' : '' ?>>Nữ</option>
                </select>
            </div>
            <div class="input-group">
                <label>Ngày sinh:</label>
                <input type="date" name="NgaySinh" value="<?= $row['NgaySinh'] ?>" required>
            </div>
            <div class="input-group">
                <label>Ngành học:</label>
                <select name="MaNganh">
                    <?php while ($rowNganh = $nganhHoc->fetch_assoc()) { ?>
                        <option value="<?= $rowNganh['MaNganh'] ?>" <?= ($rowNganh['MaNganh'] == $row['MaNganh']) ? 'selected' : '' ?>>
                            <?= $rowNganh['TenNganh'] ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="input-group">
                <label>Chọn ảnh mới:</label>
                <input type="file" name="Hinh">
            </div>
            <button type="submit" class="btn">Lưu</button>
        </form>
    </div>
</body>
</html>
