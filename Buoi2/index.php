<?php

// ======================================================
// 1. MẢNG LƯU DANH SÁCH HỌC PHẦN ĐĂNG KÝ
// ======================================================

$danhSachDangKy = [];


// ======================================================
// 2. HÀM KIỂM TRA ĐIỀU KIỆN ĐĂNG KÝ
// ======================================================

function kiemTraDangKy($soTinChi, $tongTinChi)
{
    // Sinh viên được đăng ký tối đa 15 tín chỉ
    $gioiHanTinChi = 15;

    if ($soTinChi <= 0) {
        return "Không hợp lệ";
    }

    if ($tongTinChi + $soTinChi > $gioiHanTinChi) {
        return "Không được đăng ký - vượt quá 15 tín chỉ";
    }

    return "Được đăng ký";
}


// ======================================================
// 3. TIẾP NHẬN DỮ LIỆU TỪ FORM
// ======================================================

$thongBao = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Nhận dữ liệu
    $maSV = trim($_POST["maSV"]);
    $maHocPhan = trim($_POST["maHocPhan"]);
    $tenHocPhan = trim($_POST["tenHocPhan"]);
    $soTinChi = (int) $_POST["soTinChi"];


    // Kiểm tra dữ liệu nhập
    if (
        empty($maSV) ||
        empty($maHocPhan) ||
        empty($tenHocPhan) ||
        $soTinChi <= 0
    ) {

        $thongBao = "Vui lòng nhập đầy đủ thông tin!";

    } else {

        // Tổng tín chỉ hiện tại
        $tongTinChi = 0;

        // Vòng lặp duyệt mảng
        foreach ($danhSachDangKy as $hocPhan) {
            $tongTinChi += $hocPhan["soTinChi"];
        }


        // Gọi hàm kiểm tra điều kiện
        $trangThai = kiemTraDangKy(
            $soTinChi,
            $tongTinChi
        );


        // Điều kiện xử lý
        if ($trangThai == "Được đăng ký") {

            // Tạo dữ liệu học phần
            $hocPhan = [

                "maSV" => $maSV,

                "maHocPhan" => $maHocPhan,

                "tenHocPhan" => $tenHocPhan,

                "soTinChi" => $soTinChi,

                "trangThai" => $trangThai

            ];


            // Thêm vào mảng
            $danhSachDangKy[] = $hocPhan;


            $thongBao = "Đăng ký học phần thành công!";

        } else {

            $thongBao = $trangThai;

        }
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

        /* ==========================
           CÀI ĐẶT CHUNG
        ========================== */

        * {
            box-sizing: border-box;
        }


        body {

            margin: 0;

            padding: 40px 20px;

            font-family: Arial, sans-serif;

            /* MÀU NỀN GIỐNG ẢNH */
            background: #eef4ff;

            color: #52647a;
        }


        /* ==========================
           MENU
        ========================== */

        .menu {

            width: 850px;

            max-width: 100%;

            margin: 0 auto 20px auto;

            background: white;

            padding: 15px 20px;

            border-radius: 15px;

            box-shadow: 0 5px 20px rgba(92, 137, 190, 0.10);

            display: flex;

            justify-content: center;

            gap: 10px;

            flex-wrap: wrap;
        }


        .menu a {

            text-decoration: none;

            color: #5f8fc9;

            background: #f0f6ff;

            padding: 10px 18px;

            border-radius: 9px;

            font-weight: bold;

            transition: 0.2s;
        }


        .menu a:hover {

            background: #dcecff;

            color: #4f7faf;
        }


        /* ==========================
           KHUNG CHÍNH
        ========================== */

        .container {

            width: 850px;

            max-width: 100%;

            margin: auto;

            background: #ffffff;

            padding: 40px;

            border-radius: 18px;

            box-shadow: 0 8px 30px rgba(92, 137, 190, 0.12);

            border: 1px solid #e1ebf8;
        }


        /* ==========================
           TIÊU ĐỀ
        ========================== */

        h1 {

            text-align: center;

            color: #5f8fc9;

            font-size: 30px;

            margin-top: 0;

            margin-bottom: 10px;
        }


        .moTa {

            text-align: center;

            color: #8798aa;

            margin-bottom: 35px;

            font-size: 14px;
        }


        h2 {

            color: #6594c9;

            font-size: 22px;

            margin-top: 35px;

            margin-bottom: 18px;
        }


        /* ==========================
           FORM
        ========================== */

        label {

            display: block;

            margin-top: 18px;

            margin-bottom: 8px;

            font-weight: bold;

            color: #607b98;
        }


        input {

            width: 100%;

            padding: 13px 15px;

            border: 1px solid #d4e3f3;

            border-radius: 10px;

            background: #f9fbff;

            color: #52647a;

            font-size: 15px;

            outline: none;

            transition: 0.2s;
        }


        input:focus {

            border-color: #91b6dc;

            background: #ffffff;

            box-shadow:
                0 0 0 3px
                rgba(145, 182, 220, 0.15);
        }


        input::placeholder {

            color: #a6b6c8;
        }


        /* ==========================
           NÚT ĐĂNG KÝ
        ========================== */

        button {

            width: 100%;

            margin-top: 25px;

            padding: 13px;

            border: none;

            border-radius: 10px;

            background: #91b6dc;

            color: white;

            font-size: 16px;

            font-weight: bold;

            cursor: pointer;

            transition: 0.2s;
        }


        button:hover {

            background: #7fa7d0;
        }


        /* ==========================
           THÔNG BÁO
        ========================== */

        .thongBao {

            margin-top: 25px;

            padding: 15px 18px;

            background: #f0f6ff;

            border-left: 4px solid #91b6dc;

            border-radius: 10px;

            color: #5c7692;
        }


        /* ==========================
           BẢNG
        ========================== */

        table {

            width: 100%;

            margin-top: 15px;

            border-collapse: collapse;

            overflow: hidden;

            border-radius: 10px;

            border: 1px solid #dce7f4;
        }


        th {

            padding: 13px 10px;

            background: #dcecff;

            color: #587da5;

            border: 1px solid #d2e2f2;

            font-size: 14px;
        }


        td {

            padding: 12px 10px;

            text-align: center;

            background: #ffffff;

            border: 1px solid #e2eaf3;

            font-size: 14px;
        }


        tr:hover td {

            background: #f6f9ff;
        }


        /* ==========================
           TỔNG TÍN CHỈ
        ========================== */

        .tongTinChi {

            margin-top: 18px;

            padding: 14px 18px;

            background: #f0f6ff;

            border-radius: 10px;

            color: #5d7895;

            font-weight: bold;
        }


        /* ==========================
           GHI CHÚ
        ========================== */

        .ghiChu {

            margin-top: 25px;

            padding: 15px;

            background: #f8fbff;

            border-radius: 10px;

            color: #8293a6;

            font-size: 13px;

            line-height: 1.6;
        }


        /* ==========================
           MOBILE
        ========================== */

        @media (max-width: 600px) {

            body {

                padding: 20px 10px;
            }


            .container {

                padding: 25px 20px;
            }


            h1 {

                font-size: 24px;
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


<!-- ==================================================
     MENU CHUYỂN TRANG
=================================================== -->

<div class="menu">

    <a href="index.php">
        Đăng ký học phần
    </a>

    <a href="ketqua.php">
        Kết quả học tập
    </a>

    <a href="xeploai.php">
        Xếp loại điểm
    </a>

</div>



<!-- ==================================================
     NỘI DUNG CHÍNH
=================================================== -->

<div class="container">


    <h1>
        ĐĂNG KÝ HỌC PHẦN
    </h1>


    <p class="moTa">
        Hệ thống đăng ký học phần dành cho sinh viên
    </p>



    <!-- ==================================================
         FORM NHẬP
    =================================================== -->

    <h2>
        Thông tin đăng ký
    </h2>


    <form method="POST">


        <!-- MÃ SINH VIÊN -->

        <label>
            Mã sinh viên
        </label>

        <input
            type="text"
            name="maSV"
            placeholder="Ví dụ: 224001836"
            required
        >



        <!-- MÃ HỌC PHẦN -->

        <label>
            Mã học phần
        </label>

        <input
            type="text"
            name="maHocPhan"
            placeholder="Ví dụ: LTH001"
            required
        >



        <!-- TÊN HỌC PHẦN -->

        <label>
            Tên học phần
        </label>

        <input
            type="text"
            name="tenHocPhan"
            placeholder="Ví dụ: Lập trình Web"
            required
        >



        <!-- SỐ TÍN CHỈ -->

        <label>
            Số tín chỉ
        </label>

        <input
            type="number"
            name="soTinChi"
            min="1"
            max="6"
            placeholder="Nhập số tín chỉ"
            required
        >



        <!-- NÚT -->

        <button type="submit">
            Đăng ký học phần
        </button>


    </form>



    <!-- ==================================================
         THÔNG BÁO
    =================================================== -->

    <?php

    if (!empty($thongBao)) {

    ?>

        <div class="thongBao">

            <strong>
                Thông báo:
            </strong>

            <?php

            echo htmlspecialchars($thongBao);

            ?>

        </div>

    <?php

    }

    ?>



    <!-- ==================================================
         DANH SÁCH ĐĂNG KÝ
    =================================================== -->

    <?php

    if (!empty($danhSachDangKy)) {

    ?>

        <h2>
            Danh sách học phần đã đăng ký
        </h2>


        <table>


            <tr>

                <th>
                    STT
                </th>

                <th>
                    Mã sinh viên
                </th>

                <th>
                    Mã học phần
                </th>

                <th>
                    Tên học phần
                </th>

                <th>
                    Tín chỉ
                </th>

                <th>
                    Trạng thái
                </th>

            </tr>



            <?php

            // Biến STT
            $stt = 1;

            // Tổng tín chỉ
            $tongTinChiHienTai = 0;


            // ==================================================
            // VÒNG LẶP DUYỆT MẢNG
            // ==================================================

            foreach ($danhSachDangKy as $hocPhan) {

                $tongTinChiHienTai += $hocPhan["soTinChi"];

            ?>

                <tr>


                    <td>
                        <?php echo $stt; ?>
                    </td>


                    <td>
                        <?php
                        echo htmlspecialchars(
                            $hocPhan["maSV"]
                        );
                        ?>
                    </td>


                    <td>
                        <?php
                        echo htmlspecialchars(
                            $hocPhan["maHocPhan"]
                        );
                        ?>
                    </td>


                    <td>
                        <?php
                        echo htmlspecialchars(
                            $hocPhan["tenHocPhan"]
                        );
                        ?>
                    </td>


                    <td>
                        <?php
                        echo $hocPhan["soTinChi"];
                        ?>
                    </td>


                    <td>
                        <?php
                        echo $hocPhan["trangThai"];
                        ?>
                    </td>


                </tr>


            <?php

                $stt++;

            }

            ?>


        </table>



        <!-- TỔNG TÍN CHỈ -->

        <div class="tongTinChi">

            Tổng số tín chỉ:

            <?php

            echo $tongTinChiHienTai;

            ?>

            / 15 tín chỉ

        </div>


    <?php

    }

    ?>



    <!-- ==================================================
         GHI CHÚ
    =================================================== -->

    <div class="ghiChu">

        <strong>Quy định:</strong>

        Sinh viên được đăng ký tối đa
        <strong>15 tín chỉ</strong>.

        Hệ thống sẽ kiểm tra số tín chỉ trước khi
        xác nhận đăng ký.

    </div>


</div>


</body>

</html>
