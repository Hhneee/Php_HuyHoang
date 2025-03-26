<?php
include '../config/db.php';

$maSV = $_GET["id"];
$result = $conn->query("SELECT sv.*, nh.TenNganh 
                        FROM SinhVien sv 
                        JOIN NganhHoc nh ON sv.MaNganh = nh.MaNganh 
                        WHERE sv.MaSV = '$maSV'");
$row = $result->fetch_assoc();


if (!$row) {
    echo "Không tìm thấy sinh viên!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thông tin Sinh viên</title>
    <style>
    /* Reset cơ bản */
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
        min-height: 100vh; /* Đảm bảo chiều cao toàn màn hình */
        margin: 0;
    }

    /* Container */
    .container {
        background: #fff8e7;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        text-align: center;
        width: 90%;
        max-width: 400px; /* Giới hạn chiều rộng */
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

    .info {
        text-align: left;
        margin-top: 10px;
    }

    .info p {
        font-size: 16px;
        margin-bottom: 10px;
        color: #6b4f36;
    }

    .info p strong {
        color: #333;
    }

    .btn {
        display: inline-block;
        padding: 12px 20px;
        background-color: #007BFF;
        color: white;
        text-decoration: none;
        border-radius: 6px;
        font-size: 16px;
        font-weight: bold;
        transition: background-color 0.3s ease, transform 0.2s ease;
        margin-top: 20px;
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
        <h2>Thông tin chi tiết</h2>
        <img class="profile-img" src="<?= !empty($row['Hinh']) ? $row['Hinh'] : '../images/default.jpeg' ?>" alt="Ảnh Sinh viên">
        <div class="info">
            <p><strong>Họ Tên:</strong> <?= $row['HoTen'] ?></p>
            <p><strong>Giới Tính:</strong> <?= $row['GioiTinh'] ?></p>
            <p><strong>Ngày Sinh:</strong> <?= $row['NgaySinh'] ?></p>
            <p><strong>Ngành Học:</strong> <?= $row['TenNganh'] ?></p>
        </div>
        <a href="index.php" class="btn">Quay lại</a>
    </div>
</body>
</html>