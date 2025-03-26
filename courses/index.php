<?php
include '../config/db.php';

$sql = "SELECT * FROM HocPhan";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh sách Học phần</title>
    <style>
    /* Reset mặc định */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    /* Thiết lập nền */
    body {
        font-family: 'Be Vietnam Pro', sans-serif;
        background: linear-gradient(to bottom, #fefcf3, #e5d9c8);
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh; /* Chiều cao tối thiểu là toàn màn hình */
        margin: 0;
        padding: 20px;
    }

    /* Container chính */
    .container {
        width: 90%;
        max-width: 1000px; /* Giới hạn chiều rộng tối đa */
        background: #fff8e7;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        text-align: center;
        animation: fadeIn 1s ease-in-out;
    }

    /* Tiêu đề */
    h2 {
        font-size: 24px;
        color: #6b4f36;
        margin-bottom: 20px;
    }

    /* Nút thêm sinh viên */
    a.btn-add {
        display: inline-block;
        padding: 10px 15px;
        background-color: #6b4f36; /* Màu nâu nhạt */
        color: white;
        text-decoration: none;
        border-radius: 8px;
        font-weight: bold;
        transition: background-color 0.3s ease, transform 0.3s ease;
        margin-bottom: 20px;
    }

    a.btn-add:hover {
        background-color: #a37d65; /* Đổi màu khi hover */
        transform: scale(1.05);
    }

    /* Bảng */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        background: #fdfaf4;
        border-radius: 12px;
        overflow: hidden;
    }

    th, td {
        padding: 12px;
        border-bottom: 1px solid #ddd;
        text-align: center;
    }

    th {
        background-color: #6b4f36;
        color: white;
        font-weight: bold;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    tr:hover {
        background-color: #f1f1f1;
        cursor: pointer;
    }

    /* Ảnh sinh viên */
    .student-img {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #ddd;
    }

    /* Nút hành động */
    td a {
        display: inline-block;
        padding: 6px 10px;
        margin: 2px;
        font-size: 14px;
        border-radius: 6px;
        text-decoration: none;
        transition: transform 0.3s ease, background-color 0.3s ease;
    }

    td a:nth-child(1) {
        background-color: #28a745; /* Sửa */
        color: white;
    }

    td a:nth-child(2) {
        background-color: #dc3545; /* Xóa */
        color: white;
    }

    td a:nth-child(3) {
        background-color: #ffc107; /* Chi tiết */
        color: black;
    }

    td a:hover {
        opacity: 0.9;
        transform: scale(1.05);
    }

    /* Nút quay lại */
    a.btn-secondary {
        display: inline-block;
        margin-top: 15px;
        padding: 10px 15px;
        background: #c0392b;
        color: white;
        text-decoration: none;
        border-radius: 8px;
        font-weight: bold;
        transition: background-color 0.3s ease, transform 0.3s ease;
    }

    a.btn-secondary:hover {
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
    <h2>Danh sách học phần</h2>
    <table border="1">
        <tr><th>Mã HP</th><th>Tên học phần</th><th>Số tín chỉ</th><th>Số lượng</th><th>Đăng ký</th></tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['MaHP'] ?></td>
                <td><?= $row['TenHP'] ?></td>
                <td><?= $row['SoTinChi'] ?></td>
                <td><?= $row['SoLuong'] ?></td>
                <td>
                    <a href="register.php?MaHP=<?= $row['MaHP'] ?>" 
                       class="btn-register"
                       onclick="return confirm('Bạn có chắc chắn muốn đăng ký học phần <?= $row['TenHP'] ?>?');">
                       📝 Đăng ký
                    </a>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
