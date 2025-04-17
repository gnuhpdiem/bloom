<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm đơn hàng</title>

    <?php 
        include_once __DIR__ . '/../../styles/styles.php';
    ?>
    
    
</head>
<body>
    

    <?php 

        include_once __DIR__ . '/../../dbconnect.php';

        // -------------- KHACH HANG ---------------------------------------

        $sqlKhachHang = "SELECT * FROM khachhang;";

        $resultKhachHang = mysqli_query($conn, $sqlKhachHang);

        $danhsachKhachHang = [];

        while ($row = mysqli_fetch_array($resultKhachHang, MYSQLI_ASSOC)) {

            $danhsachKhachHang[] = array(
                'kh_tendangnhap'    =>  $row['kh_tendangnhap'],
                'kh_ho'  =>  $row['kh_ho'],
                'kh_ten'  =>  $row['kh_ten'],
                'kh_dienthoai'  =>  $row['kh_dienthoai']
            );
        }
        
        
        // -------------- HINH THUC THANH TOAN ---------------------------------------
        $sqlHttt = "SELECT * FROM hinhthucthanhtoan;";

        $resultHttt = mysqli_query($conn, $sqlHttt);

        $danhsachHttt = [];

        while ($row = mysqli_fetch_array($resultHttt, MYSQLI_ASSOC)) {

            $danhsachHttt[] = array(
                'httt_ma'  =>  $row['httt_ma'],
                'httt_ten'  =>  $row['httt_ten']
            );
        }

        // -------------- SAN PHAM ---------------------------------------
        $sqlSanPham = "SELECT * FROM sanpham;";

        $resultSanPham = mysqli_query($conn, $sqlSanPham);

        $danhsachSanPham = [];

        while ($row = mysqli_fetch_array($resultSanPham, MYSQLI_ASSOC)) {

            $danhsachSanPham[] = array(
                'sp_ma'  =>  $row['sp_ma'],
                'sp_ten'  =>  $row['sp_ten'],
                'sp_gia'  =>  $row['sp_gia']
            );
        }

    
    ?>

    <?php 
        include_once __DIR__ . '/../layout/header.php';
    ?>

    <!-- ------------------------Check user ---------------------------------------- -->
    <?php 
        // không có đăng nhập
        if (!isset($_SESSION['dadangnhap'])) {
            echo 'Bạn chưa đăng nhập. ';
            echo '<a href="/bloom/dangnhap.php">Đăng nhập</a>';
            die;
        }

        if (isset($_SESSION['dadangnhap']) && $_SESSION['dadangnhap'] == false) {
            echo 'Bạn chưa đăng nhập. ';
            echo '<a href="/bloom/dangnhap.php">Đăng nhập</a>';
            die;
        }
        // không có quyền
        if (isset($_SESSION['kh_quantri']) && $_SESSION['kh_quantri'] == false) {
            echo 'Bạn không có quyền. ';
            echo '<a href="/bloom/">Quay về trang chủ.</a>';
            die;
        }
    
    ?>
    <!-- ----------------------------------------------------------------------------- -->

    <div class="container">
        <div class="row">
            
            </div>
            <div class="col-md-12">
                <h1 style="display: block;">Thêm đơn hàng</h1>
                <fieldset class="form-group border p-3">
                <legend class="w-auto px-2 text-uppercase"><strong>Thông tin đơn hàng</strong></legend>
                <form name="form_insert" id="form_insert" method="POST" action="">
                    <div class="form-group">
                        <label>Khách hàng</label>
                        <select name="kh_tendangnhap" class="form-control">
                            <?php foreach($danhsachKhachHang as $kh): ?>
                            <option value="<?= $kh['kh_tendangnhap']?>"><?= $kh['kh_ho'] . ' ' . $kh['kh_ten'] . ' (' . $kh['kh_dienthoai'] . ')'?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Ngày lập</label>
                                <input type="text" name="dh_ngaylap" id="dh_ngaylap" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Ngày giao</label>
                                <input type="text" name="dh_ngaygiao" id="dh_ngaygiao" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Nơi giao</label>
                                <input type="text" name="dh_noigiao" id="dh_noigiao" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6">
                            <legend style="font-size: 16px;">Trạng thái thanh toán</legend>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label" for="dh_trangthaithanhtoan_1">
                                <input class="form-check-input" type="radio" name="dh_trangthaithanhtoan" id="dh_trangthaithanhtoan_1" value="0" checked>
                                Chưa thanh toán
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label" for="dh_trangthaithanhtoan_2">
                                <input class="form-check-input" type="radio" name="dh_trangthaithanhtoan" id="dh_trangthaithanhtoan_2" value="1">
                                Đã thanh toán
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Hình thức thanh toán</label>
                                <select name="httt_ma" class="form-control">
                                    <?php foreach($danhsachHttt as $httt): ?>
                                    <option value="<?= $httt['httt_ma']?>"><?= $httt['httt_ten']?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <fieldset class="form-group border p-3">
                    <legend class="w-auto px-2 text-uppercase"><strong>Thông tin Chi tiết Đơn hàng</strong></legend>
                    <div class="form-row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="luachonsanpham">Sản phẩm</label>
                                <select id="luachonsanpham" class="form-control" name="donhang_sp_ma">
                                    <option value="-">-</option>
                                    <?php foreach($danhsachSanPham as $sp): ?>
                                    <option value="<?= $sp['sp_ma']?>" data-tensp="<?= $sp['sp_ten']?>" data-giasp="<?= $sp['sp_gia']?>"><?= $sp['sp_ten'] . ' (' . number_format($sp['sp_gia'], 0, ',', '.') . ' VND' . ')'?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Số lượng</label>
                                <input type="number" name="donhang_sp_dh_soluong" id="luachonsoluong" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Xử lý</label><br>
                                <button type="button" id="btnThemSanPham" class="btn btn-outline-secondary">Thêm vào đơn hàng</button>
                            </div>
                        </div>
                    </div>

                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Số lượng</th>
                                <th>Đơn giá</th>
                                <th>Thành tiền</th>
                                <th>Hàng động</th>
                            </tr>
                        </thead>
                        <tbody id="insert_here">
                            
                        </tbody>
                    </table>

                    <div class="form-group">
                        <button name="btnluu" class="btn btn-outline-primary">Lưu</button>
                        <a href="index.php" class="btn btn-outline-secondary" name="btnBack" id="btnBack">Quay về</a>
                    </div>
                </fieldset>
                </form>
            </div>
        </div>
    </div>

    <?php 
        if(isset($_POST['btnluu'])){
            // chi tiet khach hang
            $kh_tendangnhap = $_POST['kh_tendangnhap'];
            $dh_ngaylap = html_entity_decode(strip_tags($_POST['dh_ngaylap']));
            $dh_ngaygiao = html_entity_decode(strip_tags($_POST['dh_ngaygiao']));
            $dh_noigiao = html_entity_decode(strip_tags($_POST['dh_noigiao']));
            $dh_trangthaithanhtoan = $_POST['dh_trangthaithanhtoan'];
            $httt_ma = $_POST['httt_ma'];

        
            $sqlInsert = "INSERT INTO dondathang
                        (dh_ngaylap, dh_ngaygiao, dh_noigiao, dh_trangthaithanhtoan, httt_ma, kh_tendangnhap)
                        VALUES ('$dh_ngaylap', '$dh_ngaygiao', '$dh_noigiao', $dh_trangthaithanhtoan, $httt_ma, '$kh_tendangnhap');";

            mysqli_query($conn, $sqlInsert);

            //var_dump($sqlInsert);

            // lay id auto increment after sql command
            $dh_ma = $conn->insert_id; // insert id chua id moi nhat

            // chi tiet don hang
            $arrChiTietDonHang_sp_ma = $_POST['donhang_sp_ma'];
            $arrChiTietDonHang_sp_dh_soluong = $_POST['donhang_sp_dh_soluong'];
            $arrChiTietDonHang_sp_dh_dongia = $_POST['donhang_sp_dh_dongia'];

            $sodong = count($arrChiTietDonHang_sp_ma);

            for($i = 0; $i < $sodong; $i++) {
                $sp_ma = $arrChiTietDonHang_sp_ma[$i];
                $sp_dh_soluong = $arrChiTietDonHang_sp_dh_soluong[$i];
                $sp_dh_dongia = $arrChiTietDonHang_sp_dh_dongia[$i];

                $sqlInsertChiTietDonHang = "INSERT INTO sanpham_dondathang (sp_ma, dh_ma, sp_dh_soluong, sp_dh_dongia) 
                                            VALUES ($sp_ma, $dh_ma, $sp_dh_soluong, $sp_dh_dongia);";

                mysqli_query($conn, $sqlInsertChiTietDonHang);
            }

        }
    ?>
    


                
    <?php 
        include_once __DIR__ . '/../layout/footer.php';
    ?>

    <?php 
        include_once __DIR__ . '/../../scripts/scripts.php';
    ?>
    <script>

        $(function() {
            
            // Thêm vào đơn hàng
            $('#btnThemSanPham').on('click', function() {

                // find selected fields
                var sp_ten = $('#luachonsanpham option:selected').data('tensp');
                var sp_gia = $('#luachonsanpham option:selected').data('giasp');

                var sp_dh_soluong = $('#luachonsoluong').val();

                var thanhtien = sp_gia * sp_dh_soluong;

                var sp_ma = $('#luachonsanpham').val();
                
                var newrow = '<tr>';

                // col 1
                newrow += '<td>';
                newrow += sp_ten;
                newrow += '<input type="hidden" name="donhang_sp_ma[]" value="'+ sp_ma +'">';
                newrow += '</td>';
                // col 2
                newrow += '<td>';
                newrow += sp_dh_soluong;
                newrow += '<input type="hidden" name="donhang_sp_dh_soluong[]" value="'+ sp_dh_soluong +'">';
                newrow += '</td>';
                // col 3
                newrow += '<td>';
                newrow += sp_gia;
                newrow += '<input type="hidden" name="donhang_sp_dh_dongia[]" value="'+ sp_gia +'">';
                newrow += '</td>';
                // col 4
                newrow += '<td>';
                newrow += thanhtien;
                newrow += '</td>';
                // col 5
                newrow += '<td>';
                newrow += '<button type="button" class="btn btn-outline-danger btnDelete"><i class="fa fa-trash-o" aria-hidden="true"></i> Xóa</button>';
                newrow += '</td>';

                newrow += '</tr>';

                
                $('#insert_here').append(newrow);
                

            });

            // xoa
            $('#insert_here').on('click', '.btnDelete', function() {
                $(this).parent().parent().remove();
            });
        });


    </script>
    
</body>
</html>