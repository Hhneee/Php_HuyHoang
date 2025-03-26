<?php
session_start();
include 'config/db.php';

// Kiểm tra đăng nhập
$user = isset($_SESSION["user"]) ? $_SESSION["user"] : null;

// Mặc định ảnh nếu không có
$studentImage = "images/default.jpeg";

if ($user && isset($user["MaSV"])) {
    $maSV = $user["MaSV"];

    // Truy vấn lấy ảnh từ CSDL
    $query = "SELECT Hinh FROM SinhVien WHERE MaSV='$maSV'";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (!empty($row['Hinh']) && file_exists($row['Hinh'])) {
            $studentImage = $row['Hinh'];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hệ thống Quản lý Sinh viên</title>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            ffont-family: 'Be Vietnam Pro', sans-serif;
            background: linear-gradient(to bottom, #fefcf3, #e5d9c8);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background: #fff8e7;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            width: 400px;
            text-align: center;
            animation: fadeIn 1.5s ease;
        }

        h2 {
            font-family: 'Palatino Linotype', serif;
            color: #6b4f36;
            margin-bottom: 20px;
        }

        .profile-img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #d4b483;
            margin-bottom: 15px;
        }

        .menu a {
            display: block;
            padding: 12px;
            margin: 10px 0;
            background: #c0a17b;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-size: 16px;
            transition: transform 0.3s ease, background-color 0.3s ease;
        }

        .menu a:hover {
            background: #a37d65;
            transform: scale(1.05);
        }

        .menu a:last-child {
            background: #e57373;
        }

        .menu a:last-child:hover {
            background: #c0392b;
        }

        p {
            font-size: 14px;
            color: #6b4f36;
            margin-bottom: 10px;
        }

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
        <h2>Hệ thống Quản lý Sinh viên</h2>

        <?php if ($user): ?>
            <img class="profile-img" src="<?= $studentImage ?>" alt="Ảnh Sinh viên">
            <p>Xin chào, <strong><?= $user["username"] ?></strong> (<?= $user["MaSV"] ?>)</p>
            <div class="menu">
                <a href="./students/qlindex.php">📚 Quản lý Sinh viên</a>
                <a href="courses/index.php">📖 Danh sách Học phần</a>
                <a href="courses/registered.php">📝 Học phần đã Đăng ký</a>
                <a href="auth/logout.php">🚪 Đăng xuất</a>
            </div>
        <?php else: ?>
            <p>Vui lòng đăng nhập để sử dụng hệ thống.</p>
            <div class="menu">
                <a href="auth/login.php">🔑 Đăng nhập</a>
                <a href="auth/register.php">📝 Đăng ký</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>