<?php
include '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $maSV = $_POST["MaSV"];
    $hoTen = $_POST["HoTen"];
    $gioiTinh = $_POST["GioiTinh"];
    $ngaySinh = $_POST["NgaySinh"];
    $maNganh = $_POST["MaNganh"];
    $username = $_POST["username"];
    $password = password_hash($_POST["password"], PASSWORD_BCRYPT);

    // Kiểm tra nếu Mã SV đã có trong bảng SinhVien
    $checkSV = $conn->query("SELECT * FROM SinhVien WHERE MaSV='$maSV'");
    
    if ($checkSV->num_rows == 0) {
        // Nếu Mã SV chưa tồn tại, thêm mới vào SinhVien
        $sqlSV = "INSERT INTO SinhVien (MaSV, HoTen, GioiTinh, NgaySinh, MaNganh) 
                  VALUES ('$maSV', '$hoTen', '$gioiTinh', '$ngaySinh', '$maNganh')";
        if ($conn->query($sqlSV) !== TRUE) {
            die("Lỗi khi thêm Sinh viên: " . $conn->error);
        }
    }

    // Kiểm tra nếu tài khoản đã tồn tại trong Users
    $checkUser = $conn->query("SELECT * FROM Users WHERE username='$username'");
    if ($checkUser->num_rows > 0) {
        $error = "Tên đăng nhập đã tồn tại!";
    } else {
        // Thêm tài khoản vào bảng Users
        $sqlUser = "INSERT INTO Users (MaSV, username, password) 
                    VALUES ('$maSV', '$username', '$password')";
        if ($conn->query($sqlUser) === TRUE) {
            header("Location: login.php");
            exit();
        } else {
            $error = "Lỗi khi tạo tài khoản: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký tài khoản</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
    /* Căn chỉnh và hiển thị toàn màn hình */
    body {
        font-family: 'Be Vietnam Pro', sans-serif;
        background: linear-gradient(to bottom, #fdf8e4, #f1e0c8);
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }

    /* Khung chính giữa và thiết kế hợp lý */
    .container {
        background: #fff8e7;
        padding: 25px 20px;
        border-radius: 12px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        width: 90%; /* Chiều rộng khung điều chỉnh theo màn hình nhỏ */
        max-width: 500px; /* Giới hạn chiều rộng tối đa */
        text-align: center;
        animation: fadeIn 1s ease-in-out;
        box-sizing: border-box;
    }

    /* Tiêu đề */
    h2 {
        font-size: 26px;
        color: #6b4f36;
        margin-bottom: 25px;
    }

    /* Căn chỉnh từng nhóm input */
    .input-group {
        margin-bottom: 20px; /* Tạo khoảng cách hợp lý giữa các input */
        text-align: left;
    }

    /* Nhãn cho các trường input */
    .input-group label {
        font-weight: 600;
        color: #6b4f36;
        margin-bottom: 8px;
        display: block;
    }

    /* Input và Select */
    .input-group input, .input-group select {
        width: 100%;
        padding: 10px;
        border: 1px solid #b8a398;
        border-radius: 8px;
        background: #fbf8f4;
        transition: all 0.3s ease;
        font-size: 15px;
        box-sizing: border-box;
    }

    .input-group input:focus, .input-group select:focus {
        border-color: #a37d65;
        box-shadow: 0 0 8px rgba(163, 125, 101, 0.5);
        outline: none;
    }

    /* Nút đăng ký */
    .btn {
        background-color: #c0a17b;
        color: white;
        border: none;
        padding: 12px 20px;
        border-radius: 8px;
        cursor: pointer;
        font-size: 16px;
        font-weight: bold;
        width: 100%;
        transition: transform 0.3s ease, background-color 0.3s ease;
        margin-top: 15px;
    }

    .btn:hover {
        background-color: #a37d65;
        transform: scale(1.05);
    }

    /* Hiển thị lỗi */
    .error {
        color: red;
        font-size: 14px;
        margin-bottom: 15px;
    }

    /* Căn chỉnh thông tin bổ sung */
    p {
        font-size: 14px;
        color: #6b4f36;
        margin-top: 15px;
    }

    p a {
        color: #a37d65;
        text-decoration: none;
        font-weight: bold;
    }

    p a:hover {
        text-decoration: underline;
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
        <h2>Đăng ký tài khoản</h2>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="POST">
            <div class="input-group">
                <label>Mã Sinh viên:</label>
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
                    <?php
                    $nganhHoc = $conn->query("SELECT * FROM NganhHoc");
                    while ($row = $nganhHoc->fetch_assoc()) {
                        echo "<option value='{$row['MaNganh']}'>{$row['TenNganh']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="input-group">
                <label>Tên đăng nhập:</label>
                <input type="text" name="username" required>
            </div>
            <div class="input-group">
                <label>Mật khẩu:</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" class="btn">Đăng ký</button>
        </form>
        <p>Đã có tài khoản? <a href="login.php">Đăng nhập</a></p>
    </div>
</body>
</html>
