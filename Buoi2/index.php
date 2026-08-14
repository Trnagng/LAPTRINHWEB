<?php

// Mảng lưu danh sách học phần đã đăng ký
$danhSachDangKy = [];

// Hàm kiểm tra điều kiện đăng ký
function kiemTraDangKy($soTinChi, $tongTinChi)
{
    $gioiHanTinChi = 15;

    if ($soTinChi <= 0) {
        return "Không hợp lệ";
    }

    if ($tongTinChi + $soTinChi > $gioiHanTinChi) {
        return "Không được đăng ký - vượt quá 15 tín chỉ";
    }

    return "Được đăng ký";
}


// Tiếp nhận và xử lý dữ liệu từ form
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $maSV = $_POST["maSV"];
    $maHocPhan = $_POST["maHocPhan"];
    $tenHocPhan = $_POST["tenHocPhan"];
    $soTinChi = (int) $_POST["soTinChi"];

    // Tính tổng tín chỉ hiện tại
    $tongTinChi = 0;

    foreach ($danhSachDangKy as $hocPhan) {
        $tongTinChi += $hocPhan["soTinChi"];
    }

    // Kiểm tra điều kiện đăng ký
    $trangThai = kiemTraDangKy($soTinChi, $tongTinChi);

    // Nếu đủ điều kiện thì thêm vào mảng
    if ($trangThai == "Được đăng ký") {

        $hocPhan = [
            "maSV" => $maSV,
            "maHocPhan" => $maHocPhan,
            "tenHocPhan" => $tenHocPhan,
            "soTinChi" => $soTinChi,
            "trangThai" => $trangThai
        ];

        $danhSachDangKy[] = $hocPhan;
    }
}

?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Đăng ký học phần</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            margin: 0;
            padding: 40px;
        }

        .container {
            width: 800px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
        }

        h2 {
            margin-top: 30px;
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
            padding: 11px 25px;
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
            text-align: center;
        }

        th {
            background: #eee;
        }

        .thong-bao {
            margin-top: 20px;
            padding: 12px;
            background: #f1f1f1;
            border-radius: 6px;
        }
    </style>
</head>

<body>

<div class="container">

    <h1>ĐĂNG KÝ HỌC PHẦN</h1>

    <form method="POST">

        <label>Mã sinh viên:</label>
        <input
            type="text"
            name="maSV"
            placeholder="Ví dụ: SV001"
            required
        >

        <label>Mã học phần:</label>
        <input
            type="text"
            name="maHocPhan"
            placeholder="Ví dụ: PHP01"
            required
        >

        <label>Tên học phần:</label>
        <input
            type="text"
            name="tenHocPhan"
            placeholder="Ví dụ: Lập trình PHP"
            required
        >

        <label>Số tín chỉ:</label>
        <input
            type="number"
            name="soTinChi"
            min="1"
            max="6"
            placeholder="Nhập số tín chỉ"
            required
        >

        <button type="submit">
            Đăng ký học phần
        </button>

    </form>


    <?php if ($_SERVER["REQUEST_METHOD"] == "POST") { ?>

        <div class="thong-bao">

            <strong>Trạng thái:</strong>

            <?php echo $trangThai; ?>

        </div>

    <?php } ?>


    <?php if (!empty($danhSachDangKy)) { ?>

        <h2>Danh sách học phần đã đăng ký</h2>

        <table>

            <tr>
                <th>STT</th>
                <th>Mã SV</th>
                <th>Mã học phần</th>
                <th>Tên học phần</th>
                <th>Tín chỉ</th>
                <th>Trạng thái</th>
            </tr>

            <?php

            $stt = 1;

            // Vòng lặp duyệt danh sách
            foreach ($danhSachDangKy as $hocPhan) {

            ?>

                <tr>

                    <td>
                        <?php echo $stt; ?>
                    </td>

                    <td>
                        <?php echo $hocPhan["maSV"]; ?>
                    </td>

                    <td>
                        <?php echo $hocPhan["maHocPhan"]; ?>
                    </td>

                    <td>
                        <?php echo $hocPhan["tenHocPhan"]; ?>
                    </td>

                    <td>
                        <?php echo $hocPhan["soTinChi"]; ?>
                    </td>

                    <td>
                        <?php echo $hocPhan["trangThai"]; ?>
                    </td>

                </tr>

            <?php

                $stt++;

            }

            ?>

        </table>

    <?php } ?>

</div>

</body>
</html>
