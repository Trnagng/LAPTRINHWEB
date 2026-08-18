<?php

// =====================================================
// BUỔI 3 - ĐĂNG KÝ HỌC PHẦN
// Form + Validation phía Server + Xử lý dữ liệu an toàn
// =====================================================


// =====================================================
// 1. MẢNG LƯU DANH SÁCH HỌC PHẦN ĐÃ ĐĂNG KÝ
// =====================================================

$danhSachDangKy = [
    [
        "maSV" => "224001836",
        "maHP" => "LTH001",
        "tenHP" => "Lập trình Web",
        "soTinChi" => 3
    ]
];


// =====================================================
// 2. BIẾN LƯU DỮ LIỆU FORM
// =====================================================

$maSV = "";
$maHP = "";
$tenHP = "";
$soTinChi = "";

$errors = [];
$thongBao = "";


// =====================================================
// 3. HÀM CHUẨN HÓA DỮ LIỆU
// =====================================================

function chuanHoa($duLieu)
{
    return trim($duLieu);
}


// =====================================================
// 4. HÀM HIỂN THỊ DỮ LIỆU AN TOÀN
// =====================================================

function hienThi($duLieu)
{
    return htmlspecialchars(
        $duLieu,
        ENT_QUOTES,
        "UTF-8"
    );
}


// =====================================================
// 5. HÀM TÍNH TỔNG SỐ TÍN CHỈ
// =====================================================

function tinhTongTinChi($danhSach)
{
    $tong = 0;

    foreach ($danhSach as $hocPhan) {
        $tong += $hocPhan["soTinChi"];
    }

    return $tong;
}


// =====================================================
// 6. XỬ LÝ FORM
// =====================================================

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Nhận dữ liệu từ form
    $maSV = chuanHoa($_POST["maSV"] ?? "");
    $maHP = chuanHoa($_POST["maHP"] ?? "");
    $tenHP = chuanHoa($_POST["tenHP"] ?? "");
    $soTinChi = chuanHoa($_POST["soTinChi"] ?? "");


    // =================================================
    // KIỂM TRA MÃ SINH VIÊN
    // =================================================

    if ($maSV === "") {

        $errors["maSV"] =
            "Vui lòng nhập mã sinh viên.";

    } elseif (!preg_match("/^[0-9]{9}$/", $maSV)) {

        $errors["maSV"] =
            "Mã sinh viên phải gồm đúng 9 chữ số.";
    }


    // =================================================
    // KIỂM TRA MÃ HỌC PHẦN
    // =================================================

    if ($maHP === "") {

        $errors["maHP"] =
            "Vui lòng nhập mã học phần.";

    } elseif (!preg_match("/^[A-Za-z0-9]+$/", $maHP)) {

        $errors["maHP"] =
            "Mã học phần chỉ được chứa chữ và số.";

    } elseif (strlen($maHP) < 3) {

        $errors["maHP"] =
            "Mã học phần phải có ít nhất 3 ký tự.";
    }


    // =================================================
    // KIỂM TRA TÊN HỌC PHẦN
    // =================================================

    if ($tenHP === "") {

        $errors["tenHP"] =
            "Vui lòng nhập tên học phần.";

    } elseif (mb_strlen($tenHP) < 3) {

        $errors["tenHP"] =
            "Tên học phần phải có ít nhất 3 ký tự.";
    }


    // =================================================
    // KIỂM TRA SỐ TÍN CHỈ
    // =================================================

    if ($soTinChi === "") {

        $errors["soTinChi"] =
            "Vui lòng nhập số tín chỉ.";

    } elseif (!filter_var($soTinChi, FILTER_VALIDATE_INT)) {

        $errors["soTinChi"] =
            "Số tín chỉ phải là số nguyên.";

    } elseif ($soTinChi < 1 || $soTinChi > 6) {

        $errors["soTinChi"] =
            "Số tín chỉ phải từ 1 đến 6.";
    }


    // =================================================
    // KIỂM TRA TỔNG TÍN CHỈ
    // =================================================

    if (!isset($errors["soTinChi"])) {

        $tongTinChiHienTai =
            tinhTongTinChi($danhSachDangKy);

        $tongTinChiMoi =
            $tongTinChiHienTai + (int)$soTinChi;


        if ($tongTinChiMoi > 15) {

            $errors["soTinChi"] =
                "Không thể đăng ký. Tổng số tín chỉ không được vượt quá 15.";
        }
    }


    // =================================================
    // KIỂM TRA TRÙNG HỌC PHẦN
    // =================================================

    if (!isset($errors["maHP"])) {

        foreach ($danhSachDangKy as $hocPhan) {

            if (
                strtoupper($hocPhan["maHP"])
                === strtoupper($maHP)
            ) {

                $errors["maHP"] =
                    "Học phần này đã được đăng ký.";

                break;
            }
        }
    }


    // =================================================
    // 7. NẾU KHÔNG CÓ LỖI -> THÊM VÀO MẢNG
    // =================================================

    if (empty($errors)) {

        $danhSachDangKy[] = [

            "maSV" => $maSV,

            "maHP" => strtoupper($maHP),

            "tenHP" => $tenHP,

            "soTinChi" => (int)$soTinChi
        ];


        $thongBao =
            "Đăng ký học phần thành công!";


        // Xóa dữ liệu form sau khi thành công
        $maHP = "";
        $tenHP = "";
        $soTinChi = "";
    }
}


// =====================================================
// 8. TÍNH TỔNG TÍN CHỈ HIỆN TẠI
// =====================================================

$tongTinChi =
    tinhTongTinChi($danhSachDangKy);

?>

<!DOCTYPE html>

<html lang="vi">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Đăng ký học phần - Buổi 3</title>


    <style>

        * {
            box-sizing: border-box;
        }


        body {

            margin: 0;

            font-family: Arial, sans-serif;

            background: #eaf5ff;

            color: #536b85;
        }


        .container {

            width: 90%;

            max-width: 1000px;

            margin: 40px auto;

            background: white;

            padding: 40px;

            border-radius: 20px;

            box-shadow:
                0 8px 30px
                rgba(100, 140, 180, 0.15);
        }


        /* ==============================
           HEADER
        ============================== */

        h1 {

            text-align: center;

            margin: 0;

            color: #6795ca;

            font-size: 30px;
        }


        .subtitle {

            text-align: center;

            color: #8aa1b9;

            margin-top: 10px;

            margin-bottom: 35px;
        }


        /* ==============================
           THÔNG BÁO
        ============================== */

        .success {

            padding: 14px 18px;

            margin-bottom: 25px;

            border-radius: 11px;

            background: #e6f7ee;

            color: #4c9670;

            border-left:
                4px solid #7cbd99;

            font-weight: bold;
        }


        /* ==============================
           THÔNG TIN TÍN CHỈ
        ============================== */

        .credit-box {

            display: flex;

            justify-content: space-between;

            align-items: center;

            padding: 17px 20px;

            margin-bottom: 28px;

            border-radius: 13px;

            background: #f2f8ff;

            border: 1px solid #dceafa;
        }


        .credit-label {

            color: #6683a2;

            font-weight: bold;
        }


        .credit-number {

            font-size: 20px;

            font-weight: bold;

            color: #709ed0;
        }


        .credit-number span {

            font-size: 14px;

            font-weight: normal;

            color: #8da2b8;
        }


        /* ==============================
           FORM
        ============================== */

        h2 {

            color: #6b96c8;

            font-size: 21px;

            margin-bottom: 20px;
        }


        .form-group {

            margin-bottom: 20px;
        }


        label {

            display: block;

            margin-bottom: 8px;

            font-weight: bold;

            color: #607c9b;
        }


        .required {

            color: #d5828c;
        }


        input {

            width: 100%;

            padding: 14px 15px;

            border-radius: 10px;

            border: 1px solid #caddec;

            background: #f8fbff;

            color: #536b85;

            font-size: 15px;

            outline: none;

            transition: 0.2s;
        }


        input:focus {

            background: white;

            border-color: #8eb5df;

            box-shadow:
                0 0 0 3px
                rgba(142, 181, 223, 0.15);
        }


        /* Ô bị lỗi */

        input.input-error {

            border-color: #dc969f;

            background: #fff9fa;
        }


        /* Lỗi */

        .error {

            margin-top: 7px;

            color: #d36f79;

            font-size: 13px;
        }


        /* ==============================
           NÚT
        ============================== */

        .btn {

            width: 100%;

            padding: 14px;

            margin-top: 5px;

            border: none;

            border-radius: 10px;

            background: #91b7de;

            color: white;

            font-size: 16px;

            font-weight: bold;

            cursor: pointer;
        }


        .btn:hover {

            background: #7ea7d2;
        }


        /* ==============================
           GHI CHÚ NHỎ
        ============================== */

        .note {

            margin-top: 15px;

            padding: 12px 15px;

            border-radius: 10px;

            background: #f4f9ff;

            color: #8095ab;

            font-size: 13px;

        }


        /* ==============================
           DANH SÁCH
        ============================== */

        .list-section {

            margin-top: 40px;
        }


        .table-wrapper {

            overflow-x: auto;
        }


        table {

            width: 100%;

            border-collapse: collapse;
        }


        th {

            padding: 13px;

            background: #dcecff;

            color: #5d7fa5;

            border: 1px solid #caddec;
        }


        td {

            padding: 12px;

            text-align: center;

            border: 1px solid #dce6f0;
        }


        tr:nth-child(even) td {

            background: #f8fbff;
        }


        .status {

            display: inline-block;

            padding: 5px 10px;

            border-radius: 20px;

            background: #e5f6ed;

            color: #4c9670;

            font-size: 12px;

            font-weight: bold;
        }


        /* ==============================
           MOBILE
        ============================== */

        @media (max-width: 600px) {

            .container {

                padding: 25px 20px;

                margin: 20px auto;
            }


            h1 {

                font-size: 25px;
            }


            .credit-box {

                align-items: flex-start;

                flex-direction: column;

                gap: 5px;
            }

        }

    </style>

</head>


<body>


<div class="container">


    <!-- ==============================
         TIÊU ĐỀ
    ============================== -->

    <h1>
        ĐĂNG KÝ HỌC PHẦN
    </h1>


    <div class="subtitle">

        Đăng ký học phần cho sinh viên

    </div>


    <!-- ==============================
         THÔNG BÁO THÀNH CÔNG
    ============================== -->

    <?php if ($thongBao !== ""): ?>

        <div class="success">

            ✓ <?php echo hienThi($thongBao); ?>

        </div>

    <?php endif; ?>


    <!-- ==============================
         TỔNG TÍN CHỈ
    ============================== -->

    <div class="credit-box">

        <div class="credit-label">

            Số tín chỉ đã đăng ký

        </div>


        <div class="credit-number">

            <?php echo $tongTinChi; ?>

            <span>/ 15 tín chỉ</span>

        </div>

    </div>


    <!-- ==============================
         FORM
    ============================== -->

    <h2>
        Thông tin đăng ký
    </h2>


    <form method="POST" action="">


        <!-- MÃ SINH VIÊN -->

        <div class="form-group">

            <label for="maSV">

                Mã sinh viên

                <span class="required">*</span>

            </label>


            <input
                type="text"
                id="maSV"
                name="maSV"
                value="<?php echo hienThi($maSV); ?>"
                placeholder="Nhập mã sinh viên"
                class="<?php echo isset($errors["maSV"])
                    ? "input-error"
                    : ""; ?>"
            >


            <?php if (isset($errors["maSV"])): ?>

                <div class="error">

                    ⚠
                    <?php
                    echo hienThi($errors["maSV"]);
                    ?>

                </div>

            <?php endif; ?>

        </div>


        <!-- MÃ HỌC PHẦN -->

        <div class="form-group">

            <label for="maHP">

                Mã học phần

                <span class="required">*</span>

            </label>


            <input
                type="text"
                id="maHP"
                name="maHP"
                value="<?php echo hienThi($maHP); ?>"
                placeholder="Ví dụ: LTH001"
                class="<?php echo isset($errors["maHP"])
                    ? "input-error"
                    : ""; ?>"
            >


            <?php if (isset($errors["maHP"])): ?>

                <div class="error">

                    ⚠
                    <?php
                    echo hienThi($errors["maHP"]);
                    ?>

                </div>

            <?php endif; ?>

        </div>


        <!-- TÊN HỌC PHẦN -->

        <div class="form-group">

            <label for="tenHP">

                Tên học phần

                <span class="required">*</span>

            </label>


            <input
                type="text"
                id="tenHP"
                name="tenHP"
                value="<?php echo hienThi($tenHP); ?>"
                placeholder="Ví dụ: Lập trình Web"
                class="<?php echo isset($errors["tenHP"])
                    ? "input-error"
                    : ""; ?>"
            >


            <?php if (isset($errors["tenHP"])): ?>

                <div class="error">

                    ⚠
                    <?php
                    echo hienThi($errors["tenHP"]);
                    ?>

                </div>

            <?php endif; ?>

        </div>


        <!-- SỐ TÍN CHỈ -->

        <div class="form-group">

            <label for="soTinChi">

                Số tín chỉ

                <span class="required">*</span>

            </label>


            <input
                type="number"
                id="soTinChi"
                name="soTinChi"
                value="<?php echo hienThi($soTinChi); ?>"
                placeholder="Nhập số tín chỉ"
                min="1"
                max="6"
                class="<?php echo isset($errors["soTinChi"])
                    ? "input-error"
                    : ""; ?>"
            >


            <?php if (isset($errors["soTinChi"])): ?>

                <div class="error">

                    ⚠
                    <?php
                    echo hienThi($errors["soTinChi"]);
                    ?>

                </div>

            <?php endif; ?>

        </div>


        <!-- NÚT -->

        <button
            type="submit"
            class="btn"
        >

            Đăng ký học phần

        </button>


    </form>


    <!-- ==============================
         GHI CHÚ
    ============================== -->

    <div class="note">

        <strong>*</strong>
        Các trường thông tin bắt buộc.
        Tổng số tín chỉ đăng ký tối đa là 15 tín chỉ.

    </div>


    <!-- ==============================
         DANH SÁCH ĐÃ ĐĂNG KÝ
    ============================== -->

    <div class="list-section">


        <h2>
            Học phần đã đăng ký
        </h2>


        <div class="table-wrapper">


            <table>

                <thead>

                    <tr>

                        <th>STT</th>

                        <th>Mã sinh viên</th>

                        <th>Mã học phần</th>

                        <th>Tên học phần</th>

                        <th>Tín chỉ</th>

                        <th>Trạng thái</th>

                    </tr>

                </thead>


                <tbody>

                    <?php foreach (
                        $danhSachDangKy
                        as $index => $hocPhan
                    ): ?>

                        <tr>

                            <td>

                                <?php
                                echo $index + 1;
                                ?>

                            </td>


                            <td>

                                <?php
                                echo hienThi(
                                    $hocPhan["maSV"]
                                );
                                ?>

                            </td>


                            <td>

                                <?php
                                echo hienThi(
                                    $hocPhan["maHP"]
                                );
                                ?>

                            </td>


                            <td>

                                <?php
                                echo hienThi(
                                    $hocPhan["tenHP"]
                                );
                                ?>

                            </td>


                            <td>

                                <?php
                                echo $hocPhan["soTinChi"];
                                ?>

                            </td>


                            <td>

                                <span class="status">

                                    Đã đăng ký

                                </span>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                </tbody>

            </table>


        </div>

    </div>


</div>


</body>

</html>
