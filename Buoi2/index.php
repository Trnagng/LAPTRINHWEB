<?php

// Mảng lưu danh sách sinh viên
$danhSachSinhVien = [];

// Hàm kiểm tra trạng thái sinh viên
function xacDinhTrangThai($email)
{
    if ($email != "") {
        return "Đã cập nhật thông tin";
    } else {
        return "Chưa có email";
    }
}

// Xử lý dữ liệu khi người dùng gửi form
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $maSinhVien = $_POST["maSinhVien"];
    $hoTen = $_POST["hoTen"];
    $lop = $_POST["lop"];
    $email = $_POST["email"];

    // Tạo một sinh viên bằng mảng
    $sinhVien = [
        "maSinhVien" => $maSinhVien,
        "hoTen" => $hoTen,
        "lop" => $lop,
        "email" => $email,
        "trangThai" => xacDinhTrangThai($email)
    ];

    // Thêm sinh viên vào danh sách
    $danhSachSinhVien[] = $sinhVien;
}

?>

<!DOCTYPE html>
<html lang="vi">

<head>

    <meta charset="UTF-8">

    <title>Quản lý sinh viên</title>

</head>

<body>

    <h1>QUẢN LÝ SINH VIÊN</h1>

    <h2>Thêm thông tin sinh viên</h2>

    <form method="POST">

        <label>Mã sinh viên:</label>
        <input type="text" name="maSinhVien" required>

        <br><br>

        <label>Họ và tên:</label>
        <input type="text" name="hoTen" required>

        <br><br>

        <label>Lớp:</label>
        <input type="text" name="lop" required>

        <br><br>

        <label>Email:</label>
        <input type="email" name="email">

        <br><br>

        <button type="submit">
            Thêm sinh viên
        </button>

    </form>


    <?php if (!empty($danhSachSinhVien)) { ?>

        <h2>Danh sách sinh viên</h2>

        <table border="1" cellpadding="10">

            <tr>

                <th>STT</th>
                <th>Mã sinh viên</th>
                <th>Họ và tên</th>
                <th>Lớp</th>
                <th>Email</th>
                <th>Trạng thái</th>

            </tr>


            <?php

            $stt = 1;

            // Vòng lặp duyệt danh sách sinh viên
            foreach ($danhSachSinhVien as $sinhVien) {

            ?>

                <tr>

                    <td>
                        <?php echo $stt; ?>
                    </td>

                    <td>
                        <?php echo $sinhVien["maSinhVien"]; ?>
                    </td>

                    <td>
                        <?php echo $sinhVien["hoTen"]; ?>
                    </td>

                    <td>
                        <?php echo $sinhVien["lop"]; ?>
                    </td>

                    <td>
                        <?php echo $sinhVien["email"]; ?>
                    </td>

                    <td>
                        <?php echo $sinhVien["trangThai"]; ?>
                    </td>

                </tr>

            <?php

                $stt++;

            }

            ?>

        </table>

    <?php } ?>

</body>

</html>
