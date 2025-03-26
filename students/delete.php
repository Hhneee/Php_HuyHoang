<?php
include '../config/db.php';
$maSV = $_GET["id"];
$conn->query("DELETE FROM SinhVien WHERE MaSV='$maSV'");
header("Location: qlindex.php");
?>
