<?php
session_start();
include '../config/db.php';

$maSV = $_SESSION["user"]["MaSV"];
$maHP = $_GET["MaHP"];
$ngayDK = date("Y-m-d");

// Tạo bản ghi đăng ký nếu chưa có
$conn->query("INSERT INTO DangKy (NgayDK, MaSV) VALUES ('$ngayDK', '$maSV') ON DUPLICATE KEY UPDATE NgayDK='$ngayDK'");
$maDK = $conn->insert_id;

// Thêm vào bảng ChiTietDangKy
$sql = "INSERT INTO ChiTietDangKy (MaDK, MaHP) VALUES ('$maDK', '$maHP')";
if ($conn->query($sql) === TRUE) {
    // Giảm số lượng sinh viên có thể đăng ký
    $conn->query("UPDATE HocPhan SET SoLuong = SoLuong - 1 WHERE MaHP='$maHP'");
    header("Location: index.php");
} else {
    echo "Lỗi: " . $conn->error;
}
?>
