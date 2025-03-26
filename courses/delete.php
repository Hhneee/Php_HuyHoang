<?php
session_start();
include '../config/db.php';

$maSV = $_SESSION["user"]["MaSV"];
$maHP = $_GET["MaHP"];

// Lấy MaDK của sinh viên
$sql = "SELECT MaDK FROM DangKy WHERE MaSV='$maSV'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$maDK = $row["MaDK"];

// Xóa học phần khỏi ChiTietDangKy
$conn->query("DELETE FROM ChiTietDangKy WHERE MaDK='$maDK' AND MaHP='$maHP'");

// Cập nhật số lượng sinh viên có thể đăng ký
$conn->query("UPDATE HocPhan SET SoLuong = SoLuong + 1 WHERE MaHP='$maHP'");

header("Location: registered.php");
?>
