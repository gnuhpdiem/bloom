<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán</title>

    <?php 
        include_once __DIR__ . '/../styles/styles.php';
    ?>
    
</head>
<body>
    <?php 
        include_once __DIR__ . '/layout/header.php';
        
    ?>

    <!-- ------------------------Check user ---------------------------------------- -->
    <?php 
        // không có đăng nhập
        if (!isset($_SESSION['dadangnhap'])) {
            echo '<script>
            location.href="/bloom/dangnhap.php";
            </script>';
            die;
        }

        if (isset($_SESSION['dadangnhap']) && $_SESSION['dadangnhap'] == false) {
            echo '<script>
            location.href="/bloom/dangnhap.php";
            </script>';
            die;
        }
    
    ?>
    <!-- ----------------------------------------------------------------------------- -->

    <?php 

        if (isset($_SESSION['giohang'])) {
            $giohang = $_SESSION['giohang'];
        }

    ?>
    <?php 
        include_once __DIR__ . '/../dbconnect.php';

        $sqlHTTT = "SELECT * FROM hinhthucthanhtoan;";

        $result = mysqli_query($conn, $sqlHTTT);

        $DataHinhthucthanhtoan = [];

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $DataHinhthucthanhtoan[] = array(
                'httt_ma'  =>  $row['httt_ma'],
                'httt_ten'  =>  $row['httt_ten']
            );
        }

        $kh_tendangnhap = $_SESSION['kh_tendangnhap'];

        $sql = "SELECT * FROM khachhang WHERE kh_tendangnhap = '$kh_tendangnhap'; ";

        $result = mysqli_query($conn, $sql);

        $data = [];

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
            $data[] = array(
                'kh_ho' =>  $row['kh_ho'],
                'kh_ten' =>  $row['kh_ten'],
                'kh_diachi' =>  $row['kh_diachi'],
                'kh_dienthoai' =>  $row['kh_dienthoai']
            );
        };


        if (isset($_POST['submit'])) {

            $kh_ho = $_POST['kh_ho'];
            $kh_ten = $_POST['kh_ten'];
            $kh_diachi = html_entity_decode(strip_tags($_POST['kh_diachi']));
            $dh_noigiao = html_entity_decode(strip_tags($_POST['dh_noigiao']));
            $kh_dienthoai = html_entity_decode(strip_tags($_POST['kh_dienthoai']));
            $httt_ma_chon = $_POST['httt_ma'];

            // echo '<pre>';
            // print_r($_POST);
            // echo '</pre>';

            // nếu người dùng có sửa thông tin
            $sqlUpdate = "UPDATE khachhang
                        SET
                            kh_ho='$kh_ho',
                            kh_ten='$kh_ten',
                            kh_diachi='$kh_diachi',
                            kh_dienthoai='$kh_dienthoai'
                        WHERE kh_tendangnhap='$kh_tendangnhap';";
            
            $Update = mysqli_query($conn, $sqlUpdate);

            if ($Update) {
                $insertOrdersql = "INSERT INTO dondathang
                (dh_ngaylap, dh_ngaygiao, dh_noigiao, dh_trangthaithanhtoan, httt_ma, kh_tendangnhap)
                VALUES (NOW(), '', '$dh_noigiao', 0, $httt_ma_chon, '$kh_tendangnhap')";

                $insertOrder = mysqli_query($conn, $insertOrdersql);

                if ($insertOrder) {

                    $dh_ma = mysqli_insert_id($conn);
                    
                    foreach ($giohang as $index => $sp) {

                        $sqlSp = "SELECT *, MIN(hsp.hsp_tentaptin) FROM sanpham AS sp
                                    LEFT JOIN hinhsanpham AS hsp ON hsp.sp_ma = sp.sp_ma
                                    WHERE sp.sp_ma = $index;";

                                $result = mysqli_query($conn, $sqlSp);

                                $dssanpham = [];

                                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                        $sp_dh_soluong = $sp['sp_dh_soluong'];
                        $sp_gia = $row['sp_gia'];

                        $sql_insert_sp = "INSERT INTO sanpham_dondathang
                                            (sp_ma, dh_ma, sp_dh_soluong, sp_dh_dongia)
                                            VALUES ($index, $dh_ma, $sp_dh_soluong, $sp_gia);";

                        mysqli_query($conn, $sql_insert_sp);
                        
                        
                    }
                    echo '<script>alert("Đặt hàng thành công!");</script>';
                    
                }
            }
        }
    
    ?>

    <form name="formThanhToan" method="post" action="">
        <div class="container">
            <?php if (empty($giohang)): ?>
                    <h3>Giỏ hàng rỗng</h3>
                    Hãy <a href="/bloom/">click vào đây</a> để mua sắm.
                    <!-- Để hình vô --->
            <?php else: ?>   
                <div class="row">
                    <div class="col-md-6">
                    <h3>Thông tin khách hàng</h3>
                    
                        
                        <div class="form-row">
                        <?php foreach($data as $kh): ?>
                                <div class="form-group col-md-6">
                                <label for="kh_ho">Họ</label>
                                <input type="text" class="form-control" id="kh_ho" name="kh_ho" value="<?php echo $kh['kh_ho']; ?>">
                                </div>
                                <div class="form-group col-md-6">
                                <label for="kh_ten">Tên</label>
                                <input type="text" class="form-control" id="kh_ten" name="kh_ten" value="<?php echo $kh['kh_ten']; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="kh_dienthoai">Số điện thoại</label>
                                <input type="text" class="form-control" id="kh_dienthoai" name="kh_dienthoai" value="<?php echo $kh['kh_dienthoai']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="kh_diachi">Địa chỉ giao hàng</label>
                                <input type="text" class="form-control" id="kh_diachi" name="kh_diachi" value="<?php echo $kh['kh_diachi']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="dh_noigiao">Thành phố nơi giao hàng</label>
                                <input type="text" class="form-control" id="dh_noigiao" name="dh_noigiao">
                            </div>
                            <h5>Phương thức thanh toán</h5>
                            <?php foreach ($DataHinhthucthanhtoan as $httt):?>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="httt_ma" value="<?php echo $httt['httt_ma']; ?>">
                                            <?php echo $httt['httt_ten']?>
                                    </label>
                                </div>
                            <?php endforeach;?>
                        <?php endforeach; ?>


                    
                    </div>

                    
                    <div class="col-md-6">
                        <h3>Sản phẩm đã chọn</h3>
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
                                    <td><a href="/bloom/frontend/xemchitietsanpham.php?sp_ma=<?php echo $row['sp_ma'] ?>"><?php echo $row['sp_ten'];?></a></td>
                                    <td><?php echo $sp['sp_dh_soluong']; ?></td>
                                    <td><?php echo number_format($row['sp_gia'], 0, ',', '.');?></td>
                                    <td><?php echo number_format(($sp['sp_dh_soluong'] * $row['sp_gia']), 0, ',', '.');?></td>
                                    
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
                                <td class="text-right">Tổng:<p class="font-weight-bold" style="font-size: 25px;"><?php echo number_format($tong, 0, ',', '.');?>  VND</p></td>
                            </tr>
                        </tfoot>
                    </table>

                    
                <?php endif; ?>
                    </div>
                
            <?php endif; ?>
                </div>

                <div class="row">
                    <div class="col-md-12 d-flex justify-content-between mb-3">
                        <a href="/bloom/index.php#danh_sach_san_pham" class="btn btn-outline-primary">Tiếp tục mua hàng</a>
                        <input type="submit" name="submit" value="Đặt hàng" class="btn btn-outline-secondary">
                    </div>
                </div>
            </div>
            
        </div>
    </form>
    <?php 
        include_once __DIR__ . '/layout/footer.php';
    ?>

    <?php 
        include_once __DIR__ . '/../scripts/scripts.php';
    ?>
</body>
</html>