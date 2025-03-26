<?php
session_start();
include '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM Users WHERE username='$username'";
    $result = $conn->query($sql);
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user["password"])) {
        $_SESSION["user"] = $user;
        header("Location: ../index.php");
    } else {
        echo "<p>Sai tài khoản hoặc mật khẩu!</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <style>
        body {
            font-family: 'Be Vietnam Pro', sans-serif;
            background: linear-gradient(to bottom, #fefcf3, #e5d9c8);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        form {
            background-color: #fff8e7;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
            width: 340px;
            border: 2px solid #d4b483;
            text-align: center;
            animation: fadeIn 1.5s ease-in-out;
        }

        input {
            display: block;
            width: 80%;
            padding: 12px;
            margin: 12px auto;
            border: 1px solid #b8a398;
            border-radius: 6px;
            font-size: 14px;
            background: #fdfaf4;
            color: #5c5247;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        input:focus {
            border-color: #a37d65;
            outline: none;
            background: #fef6e8;
            transform: scale(1.05);
            box-shadow: 0 0 8px rgba(163, 125, 101, 0.5);
        }

        button {
            background-color: #c0a17b;
            color: #ffffff;
            border: none;
            padding: 12px;
            width: 80%;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            margin: 15px auto;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        button:hover {
            background-color: #a37d65;
            transform: scale(1.05);
        }

        p {
            text-align: center;
            color: #a94442;
            font-style: italic;
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
    <form method="POST">
        <h2 style="font-family: 'Be Vietnam pro', serif; color: #6b4f36;">Đăng nhập</h2>
        <input type="text" name="username" placeholder="Tài khoản" required>
        <input type="password" name="password" placeholder="Mật khẩu" required>
        <button type="submit">Đăng nhập</button><br>
        <a href="../index.php" style="color: #d4b483"> Quay lại</a>
    </form>
</body>
</html>
