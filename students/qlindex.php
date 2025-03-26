<?php
include '../config/db.php';

$sql = "SELECT sv.*, nh.TenNganh FROM SinhVien sv JOIN NganhHoc nh ON sv.MaNganh = nh.MaNganh";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh sách Sinh viên</title>
    <style>
    /* Reset cơ bản */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    /* Thiết lập chung */
    body {
        font-family: 'Be Vietnam Pro', sans-serif;
        background: linear-gradient(to bottom, #fefcf3, #e5d9c8);
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh; /* Đảm bảo hiển thị toàn màn hình */
        margin: 0;
        padding: 20px;
    }

    .container {
        width: 90%;
        max-width: 1000px; /* Giới hạn chiều rộng */
        background: #fff8e7;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        text-align: center;
        animation: fadeIn 1s ease-in-out;
    }

    h2 {
        font-size: 24px;
        color: #6b4f36;
        margin-bottom: 20px;
    }

    /* Nút thêm sinh viên */
    a.btn-add {
        display: inline-block;
        padding: 10px 15px;
        background-color: #6b4f36; /* Màu nâu nhẹ */
        color: white;
        text-decoration: none;
        border-radius: 8px;
        font-weight: bold;
        transition: transform 0.3s ease, background-color 0.3s ease;
        margin-bottom: 20px;
    }

    a.btn-add:hover {
        background-color: #a37d65;
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
        font-size: 14px;
        border-radius: 6px;
        text-decoration: none;
        transition: transform 0.3s ease, background-color 0.3s ease;
        margin: 2px;
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

    /* Nút Quay lại */
    a.btn-secondary {
        display: inline-block;
        margin-top: 15px;
        padding: 12px 20px;
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
    <h2>Danh sách Sinh viên</h2><br>
    <a href="create.php" style="color: #a37d65">Thêm sinh viên</a>
    <table border="1">
        <tr>
            <th>Ảnh</th>
            <th>Mã SV</th>
            <th>Họ tên</th>
            <th>Giới tính</th>
            <th>Ngày sinh</th>
            <th>Ngành</th>
            <th>Hành động</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td>
                    <img class="student-img" src="<?= !empty($row['Hinh']) ? $row['Hinh'] : '../images/default.jpeg' ?>" alt="Ảnh SV">
                </td>
                <td><?= $row['MaSV'] ?></td>
                <td><?= $row['HoTen'] ?></td>
                <td><?= $row['GioiTinh'] ?></td>
                <td><?= $row['NgaySinh'] ?></td>
                <td><?= $row['TenNganh'] ?></td>
                <td>
                    <a href="edit.php?id=<?= $row['MaSV'] ?>">Sửa</a> | 
                    <a href="delete.php?id=<?= $row['MaSV'] ?>" onclick="return confirm('Xóa sinh viên này?')">Xóa</a> | 
                    <a href="detail.php?id=<?= $row['MaSV'] ?>">Chi tiết</a>
                </td>
            </tr>
        <?php } ?>
    </table>
    <a href="../index.php" class="btn btn-secondary">Quay lại Trang Chính</a>

</body>
</html>