<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng</title>

    <?php 
        include_once __DIR__ . '/../styles/styles.php';
    ?>
    <style>
        table, th, tr {
            text-align: center;
        }
    </style>
    
</head>
<body>
    <?php 
        include_once __DIR__ . '/layout/header.php';

        // cap nhap so luong san pham
        if (isset($_POST["CapnhapSoLuong"])) {
            if (!empty($_SESSION['giohang'])) {
                $sp_ma = $_POST['sp_ma'];
                $_SESSION['giohang'][$sp_ma] = array('sp_dh_soluong'    =>  $_POST['sp_dh_soluong']); 
            }
        }
    ?>

    <div class="container">
        <!-- Vùng ALERT hiển thị thông báo -->
        <div id="alert-container" class="alert alert-warning alert-dismissible fade d-none" role="alert">
                <div id="thongbao">&nbsp;</div>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php if (empty($_SESSION['giohang'])): ?>
                    <div class="container d-flex justify-content-center">
                        <div class="empty-cart text-center">
                            <img src="/bloom/assets/img/empty_cart.jpg" style="width: 300px;">
                            <h3>Giỏ hàng rỗng</h3>
                            Hãy <a href="/bloom/">click vào đây</a> để mua sắm.
                        </div>
                    </div>
                    <!-- Để hình vô --->
                <?php else: ?>
                    <?php $giohang = $_SESSION['giohang']; ?>
                    <table id="giohangtable" class="table table-hover" style="width: 100%;">
                        <thead>
                            <tr style="text-align: center;">
                                <th>Số thứ tự</th>
                                <th>Hình</th>
                                <th>Sản phẩm</th>
                                <th>Số lượng</th>
                                <th>Giá tiền</th>
                                <th>Thành tiền</th>
                                <th>Xóa</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $stt = 1; $tong = 0;?>
                            <?php foreach($giohang as $index => $sp): 
                                $sql = "SELECT *, MIN(hsp.hsp_tentaptin) FROM sanpham AS sp
                                    LEFT JOIN hinhsanpham AS hsp ON hsp.sp_ma = sp.sp_ma
                                    WHERE sp.sp_ma = $index;";

                                $result = mysqli_query($conn, $sql);

                                $dssanpham = [];

                                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                            

                                ?>
                                <tr style="padding-top: 15px;">
                                    <td><?php echo $stt;?></td>
                                    <td>
                                    <?php if (empty($row['hsp_tentaptin'])):?>
                                        <img src="/bloom/assets/img/default-thumbnail.jpg" class="img-fluid" style="width: 130px">
                                    <?php else: ?>    
                                        <img src="/bloom/assets/uploads/<?php echo $row['hsp_tentaptin'];?>" class="img-fluid" style="width: 130px">
                                    <?php endif; ?></td>
                                    <td style='white-space: nowrap'><a href="/bloom/frontend/xemchitietsanpham.php?sp_ma=<?php echo $row['sp_ma'] ?>"><?php echo $row['sp_ten'];?></a></td>
                                    <td style='white-space: nowrap'>
                                        <form action="" method="post">
                                            <input type="hidden" value="<?php echo $index ?>" name="sp_ma">
                                        <input type="number" value="<?php echo $sp['sp_dh_soluong']; ?>" name="sp_dh_soluong"> <input class="btn btn-outline-primary" type="submit" value="Cập nhập" name="CapnhapSoLuong">
                                        </form>
                                    </td>
                                    <td><?php echo number_format($row['sp_gia'], 0, ',', '.');?></td>
                                    <td><?php echo number_format(($sp['sp_dh_soluong'] * $row['sp_gia']), 0, ',', '.');?></td>
                                    <td><a class="btn btn-outline-danger btnDelete" href="xoagiohang.php?sp_ma=<?php echo $index?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a></td>
                                </tr>
                                <?php $stt++; 
                                    $tong += ($sp['sp_dh_soluong'] * $row['sp_gia']);?>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="text-right">Tổng:<p class="font-weight-bold" style="font-size: 25px;"><?php echo number_format($tong, 0, ',', '.');?>  VND</p></td>
                            </tr>
                        </tfoot>
                    </table>

                    
                <?php endif; ?>
            </div>

        </div>
        <div class="row" style="margin-top: 10px;">
            <div class="col-md-6">
                <a href="/bloom/"><i class="fa fa-arrow-left" aria-hidden="true"></i> Tiếp tục mua hàng</a>
            </div>
            <div class="col-md-6">
                <a href="/bloom/frontend/thanhtoan.php" class="btn btn-outline-primary float-right">Tiến hành đặt hàng</a>
            </div>
        </div>
        
    </div>

    
    <?php 
        include_once __DIR__ . '/layout/footer.php';
    ?>

    <?php 
        include_once __DIR__ . '/../scripts/scripts.php';
    ?>
    
</body>
</html>