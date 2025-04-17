<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link href="/bloom/assets/vendors/paper-css/paper-css.min.css" type="text/css" rel="stylesheet">

    <style>
        @page { size: A4 }
    </style>
</head>
<body class="A4">
    <?php 

    include_once __DIR__ . '/../../dbconnect.php';

    $dh_ma = $_GET['dh_ma'];

    $sql = "SELECT dh.dh_ma, dh.dh_ngaylap, dh.dh_ngaygiao, dh.dh_noigiao, dh.dh_trangthaithanhtoan, httt.httt_ten, kh.kh_ho, kh.kh_ten, kh.kh_dienthoai, sum(sp_dh.sp_dh_soluong * sp_dh.sp_dh_dongia) AS tongthanhtien
            FROM dondathang AS dh
            JOIN khachhang AS kh ON dh.kh_tendangnhap = kh.kh_tendangnhap
            JOIN hinhthucthanhtoan AS httt ON httt.httt_ma = dh.httt_ma
            JOIN sanpham_dondathang as sp_dh ON sp_dh.dh_ma = dh.dh_ma
            WHERE dh.dh_ma = $dh_ma
            GROUP BY dh.dh_ma, dh.dh_ngaylap, dh.dh_ngaygiao, dh.dh_noigiao, dh.dh_trangthaithanhtoan, httt.httt_ten, kh.kh_ho, kh.kh_ten, kh.kh_dienthoai";

    $result = mysqli_query($conn, $sql);

    $danhsachdonhang = mysqli_fetch_array($result, MYSQLI_ASSOC);

    //var_dump($danhsachdonhang);

    $sqlThongTinSanPham = "SELECT sp.sp_ten, lsp.lsp_ten, sp_dh.sp_dh_soluong, sp_dh.sp_dh_dongia FROM sanpham_dondathang AS sp_dh
                            JOIN sanpham as sp ON sp_dh.sp_ma = sp.sp_ma
                            JOIN loaisanpham AS lsp ON lsp.lsp_ma = sp.lsp_ma
                            WHERE sp_dh.dh_ma = $dh_ma;";

    $resultThongTinSanPham = mysqli_query($conn, $sqlThongTinSanPham);

    $danhsachThongTinSanPham = [];

    while ($row = mysqli_fetch_array($resultThongTinSanPham, MYSQLI_ASSOC)) {
        $danhsachThongTinSanPham[] = array(
            'sp_ten'    =>  $row['sp_ten'],
            'lsp_ten'   =>  $row['lsp_ten'],
            'sp_dh_soluong'   =>  $row['sp_dh_soluong'],
            'sp_dh_dongia'   =>  $row['sp_dh_dongia']
        );
    }

    //var_dump($danhsachThongTinSanPham);

    ?>
    <section class="sheet padding-10mm">
        <table style="width: 100%;">
            <tr style="font-size: 35px; font-weight: bold;">
                <td><img src="/bloom/assets/img/Bloom Horizontal-pink.png" style="width: 200px; height: 65px"></td>
                <td style="text-align: center; padding: 5px;">ĐƠN HÀNG</td>
            </tr>
        </table>

        <h4 style="font-style:italic; text-decoration:underline;">Thông tin Đơn hàng</h4>
        <table style="width: 100%;">
            <tr>
                <td style="width: 200px;">Khách Hàng:</td>
                <td><b><?php echo $danhsachdonhang['kh_ho'] . ' ' . $danhsachdonhang['kh_ten'] . ' ' . '(' . $danhsachdonhang['kh_dienthoai'] . ')' ?></td>
            </tr>
            <tr>
                <td>Ngày lập:</td>
                <td><?php echo date('d/m/Y H:i:s', strtotime($danhsachdonhang['dh_ngaylap']))?></td>
            </tr>
            <tr>
                <td>Hình thức thanh toán:</td>
                <td><?php echo $danhsachdonhang['httt_ten']?></td>
            </tr>
            <tr>
                <td>Tổng thành tiền:</td>
                <td><?php echo number_format($danhsachdonhang['tongthanhtien'], 0, ',', '.')?> VND</td>
            </tr>
        </table>

        <h4 style="font-style:italic; text-decoration:underline;">Chi tiết Đơn hàng</h4>
        <table style="width: 100%; border-collapse: collapse; border: 1px solid;">
            <tr style="border: 1px solid;">
                <th style="padding: 5px;">STT</th>
                <th style="border: 1px solid;">Sản phẩm</th>
                <th style="border: 1px solid;">Số lượng</th>
                <th style="border: 1px solid;">Đơn giá</th>
                <th style="border: 1px solid;">Thành tiền</th>
            </tr>
            <?php $stt = 1;?>
            <?php foreach($danhsachThongTinSanPham as $sp):?>
                <tr style="border: 1px solid;">
                    <td style="padding: 5px; text-align:center; border: 1px solid;"><?php echo $stt;?></td>
                    <td style="padding: 5px; border: 1px solid;"><?php echo '<b>' . $sp['sp_ten'] . '</b>' . '<br>' . '<i>' . $sp['lsp_ten'] . '</i>';?></td>
                    <td style="text-align: right; padding: 5px;border: 1px solid;"><?php echo $sp['sp_dh_soluong']?></td>
                    <td style="text-align: right; padding: 5px;border: 1px solid;"><?php echo number_format($sp['sp_dh_dongia'], 0, ',', '.')?></td>
                    <td style="text-align: right; padding: 5px;border: 1px solid;">
                        <?php $thanhtien = $sp['sp_dh_soluong'] * $sp['sp_dh_dongia'];?>
                        <?php echo number_format($thanhtien, 0, ',', '.')?>
                    </td>
                </tr>
            <?php $stt++;?>
            <?php endforeach; ?>
            <tr style="border: 1px solid;">
                <td colspan="4" style="text-align: right; padding: 5px; font-weight:bold; border: 1px solid;">
                    Tổng thành tiền
                </td>
                <td style="text-align: right; padding: 5px; border: 1px solid;"><?php echo number_format($danhsachdonhang['tongthanhtien'], 0, ',', '.')?> VND</td>
            </tr>
        </table>
    </section>
</body>
</html>