<?php

$danhSachDangKy = [];

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $maSV = $_POST["maSV"];
    $maHocPhan = $_POST["maHocPhan"];
    $tenHocPhan = $_POST["tenHocPhan"];
    $soTinChi = (int) $_POST["soTinChi"];

    $tongTinChi = 0;

    foreach ($danhSachDangKy as $hocPhan) {
        $tongTinChi += $hocPhan["soTinChi"];
    }

    $trangThai = kiemTraDangKy($soTinChi, $tongTinChi);

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

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Đăng ký học phần</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;

            /* XANH NƯỚC PASTEL */
            background: #dff3ff;

            margin: 0;

            padding: 40px 20px;

            color: #52728a;
        }

        .container {
            width: 800px;

            max-width: 100%;

            margin: auto;

            background: #ffffff;

            padding: 35px;

            border-radius: 22px;

            box-shadow: 0 8px 25px rgba(100, 170, 210, 0.18);

            border: 1px solid #c5e8fa;
        }

        h1 {
            text-align: center;

            color: #6baed0;

            margin-bottom: 30px;

            font-size: 28px;
        }

        h2 {
            color: #6baed0;

            margin-top: 30px;

            margin-bottom: 15px;
        }

        label {
            display: block;

            margin-top: 16px;

            margin-bottom: 7px;

            font-weight: bold;

            color: #5d8299;
        }

        input {
            width: 100%;

            padding: 12px 14px;

            border: 1px solid #c3e5f7;

            border-radius: 11px;

            outline: none;

            background: #f8fcff;

            color: #52728a;

            font-size: 14px;
        }

        input:focus {
            border-color: #91cce8;

            box-shadow: 0 0 0 3px rgba(145, 204, 232, 0.18);
        }

        button {
            margin-top: 24px;

            width: 100%;

            padding: 13px;

            border: none;

            border-radius: 11px;

            /* NÚT XANH NƯỚC PASTEL */
            background: #9bd4ee;

            color: white;

            font-size: 16px;

            font-weight: bold;

            cursor: pointer;

            transition: 0.2s;
        }

        button:hover {
            background: #82c4e3;
        }

        .thong-bao {
            margin-top: 25px;

            padding: 15px 18px;

            background: #e5f5fd;

            border-left: 5px solid #9bd4ee;

            border-radius: 10px;

            color: #52728a;
        }

        table {
            width: 100%;

            border-collapse: collapse;

            margin-top: 15px;

            border-radius: 10px;

            overflow: hidden;
        }

        th {
            background: #b8e0f3;

            color: #4f748a;

            padding: 12px 8px;

            border: 1px solid #a8d7ed;
        }

        td {
            padding: 11px 8px;

            text-align: center;

            border: 1px solid #d9edf8;

            background: #fbfdff;
        }

        tr:hover td {
            background: #f0f9fe;
        }

        .tong-tin-chi {
            margin-top: 15px;

            padding: 12px;

            background: #eaf7fd;

            border-radius: 10px;

            color: #52728a;

            font-weight: bold;
        }

        @media (max-width: 600px) {

            body {
                padding: 20px 10px;
            }

            .container {
                padding: 20px;
            }

            h1 {
                font-size: 23px;
            }

            table {
                font-size: 12px;
            }

            th,
            td {
                padding: 8px 5px;
            }
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
            $tongTinChiHienTai = 0;

            foreach ($danhSachDangKy as $hocPhan) {

                $tongTinChiHienTai += $hocPhan["soTinChi"];

            ?>

                <tr>

                    <td><?php echo $stt; ?></td>

                    <td><?php echo $hocPhan["maSV"]; ?></td>

                    <td><?php echo $hocPhan["maHocPhan"]; ?></td>

                    <td><?php echo $hocPhan["tenHocPhan"]; ?></td>

                    <td><?php echo $hocPhan["soTinChi"]; ?></td>

                    <td><?php echo $hocPhan["trangThai"]; ?></td>

                </tr>

            <?php

                $stt++;

            }

            ?>

        </table>

        <div class="tong-tin-chi">

            Tổng số tín chỉ:
            <?php echo $tongTinChiHienTai; ?>
            / 15 tín chỉ

        </div>

    <?php } ?>

</div>

</body>

</html>
