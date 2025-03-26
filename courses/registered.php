    <?php
session_start();
include '../config/db.php';

$maSV = $_SESSION["user"]["MaSV"];
$sql = "SELECT hp.* FROM ChiTietDangKy cdk 
        JOIN DangKy dk ON cdk.MaDK = dk.MaDK 
        JOIN HocPhan hp ON cdk.MaHP = hp.MaHP 
        WHERE dk.MaSV='$maSV'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Học phần đã đăng ký</title>
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
        min-height: 100vh; /* Chiều cao tối thiểu là toàn màn hình */
        margin: 0;
        padding: 20px;
    }

    /* Container */
    .container {
        width: 90%;
        max-width: 800px; /* Giới hạn chiều rộng */
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
        margin-bottom: 25px;
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
        background-color: #6b4f36; /* Màu tiêu đề */
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

    /* Nút xóa */
    .btn-delete {
        display: inline-block;
        padding: 8px 12px;
        background-color: #c0392b; /* Màu đỏ */
        color: white;
        text-decoration: none;
        border-radius: 6px;
        font-size: 14px;
        transition: transform 0.3s ease, background-color 0.3s ease;
    }

    .btn-delete:hover {
        background-color: #a93226;
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

    <h2>📚 Học phần đã đăng ký</h2>
    <table border="1">
        <tr><th>Mã HP</th><th>Tên học phần</th><th>Số tín chỉ</th><th>Hủy</th></tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['MaHP'] ?></td>
                <td><?= $row['TenHP'] ?></td>
                <td><?= $row['SoTinChi'] ?></td>
                <td><a href="delete.php?MaHP=<?= $row['MaHP'] ?>" class="btn-delete">❌ Hủy</a></td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
