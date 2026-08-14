<?php

// Mảng lưu thông tin sinh viên
$sinhVien = [
    "maSV" => "",
    "hoTen" => "",
    "lop" => "",
    "email" => "",
    "trangThai" => ""
];

// Hàm kiểm tra trạng thái thông tin sinh viên
function kiemTraThongTin($hoTen, $lop, $email)
{
    if ($hoTen != "" && $lop != "" && $email != "") {
        return "Đã cập nhật đầy đủ";
    } else {
        return "Chưa đầy đủ thông tin";
    }
}

// Tiếp nhận và xử lý dữ liệu từ form
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $sinhVien["maSV"] = $_POST["maSV"];
    $sinhVien["hoTen"] = $_POST["hoTen"];
    $sinhVien["lop"] = $_POST["lop"];
    $sinhVien["email"] = $_POST["email"];

    // Sử dụng hàm tự định nghĩa
    $sinhVien["trangThai"] = kiemTraThongTin(
        $sinhVien["hoTen"],
        $sinhVien["lop"],
        $sinhVien["email"]
    );
}

?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Thông tin sinh viên</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            margin: 0;
            padding: 40px;
        }

        .container {
            width: 700px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 25px;
        }

        h2 {
            margin-top: 25px;
        }

        label {
            display: block;
            margin-top: 15px;
            margin-bottom: 6px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        button {
            margin-top: 20px;
            padding: 11px 20px;
            border: none;
            border-radius: 6px;
            background: #333;
            color: white;
            cursor: pointer;
        }

        button:hover {
            background: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        th {
            background: #eee;
        }
    </style>
</head>

<body>

<div class="container">

    <h1>THÔNG TIN SINH VIÊN</h1>

    <!-- Form nhập thông tin -->
    <form method="POST">

        <label>Mã sinh viên:</label>
        <input
            type="text"
            name="maSV"
            placeholder="Ví dụ: SV001"
            required
        >

        <label>Họ và tên:</label>
        <input
            type="text"
            name="hoTen"
            placeholder="Nhập họ và tên"
            required
        >

        <label>Lớp:</label>
        <input
            type="text"
            name="lop"
            placeholder="Ví dụ: CNTT01"
            required
        >

        <label>Email:</label>
        <input
            type="email"
            name="email"
            placeholder="Nhập email"
            required
        >

        <button type="submit">
            Cập nhật thông tin
        </button>

    </form>


    <?php if ($sinhVien["maSV"] != "") { ?>

        <h2>Thông tin đã nhập</h2>

        <table>

            <tr>
                <th>Thông tin</th>
                <th>Giá trị</th>
            </tr>

            <?php foreach ($sinhVien as $key => $value) { ?>

                <tr>

                    <td>
                        <?php
                        if ($key == "maSV") {
                            echo "Mã sinh viên";
                        } elseif ($key == "hoTen") {
                            echo "Họ và tên";
                        } elseif ($key == "lop") {
                            echo "Lớp";
                        } elseif ($key == "email") {
                            echo "Email";
                        } else {
                            echo "Trạng thái";
                        }
                        ?>
                    </td>

                    <td>
                        <?php echo $value; ?>
                    </td>

                </tr>

            <?php } ?>

        </table>

    <?php } ?>

</div>

</body>
</html>
