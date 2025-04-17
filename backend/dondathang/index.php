<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách các đơn hàng</title>

    <?php 
        include_once __DIR__ . '/../../styles/styles.php';
    ?>
    
    <style>
        
        .done {
            background: rgba(22, 211, 154, 0.15);
            color: #02b07b;
            font-size: 14px;
        }

        .notdone {
            background: rgba(255, 117, 136, 0.15);
            color: #FF7588;
            font-size: 14px;
        }

        .btnIn {
            border-color: #02b07b;
            color: #02b07b;
        }
        .btnIn:hover {
            background-color: #02b07b;
            color: white;
        }

        .btnDelete {
            border-color: #FF7588;
            color: #FF7588;
        }

        .btnDelete:hover {
            background-color: #FF7588;
            color: white;
        }

        .btnSua {
            border-color: #FFA87D;
            color: #FFA87D;
        }

        .btnSua:hover {
            background-color: #FFA87D;
            color: white;
        }

        .httt {
            background: rgba(0, 186, 232, 0.15);
            color: #00bae8;
            font-size: 14px;
        }
    </style>
    
</head>
<body>
    

    <?php 

        include_once __DIR__ . '/../../dbconnect.php';


        $sql = "SELECT dh.dh_ma, dh.dh_ngaylap, dh.dh_ngaygiao, dh.dh_noigiao, dh.dh_trangthaithanhtoan, httt.httt_ten, kh.kh_ho, kh.kh_ten, kh.kh_dienthoai, sum(sp_dh.sp_dh_soluong * sp_dh.sp_dh_dongia) AS tongthanhtien
                FROM dondathang AS dh
                JOIN khachhang AS kh ON dh.kh_tendangnhap = kh.kh_tendangnhap
                JOIN hinhthucthanhtoan AS httt ON httt.httt_ma = dh.httt_ma
                JOIN sanpham_dondathang as sp_dh ON sp_dh.dh_ma = dh.dh_ma
                GROUP BY dh.dh_ma, dh.dh_ngaylap, dh.dh_ngaygiao, dh.dh_noigiao, dh.dh_trangthaithanhtoan, httt.httt_ten, kh.kh_ho, kh.kh_ten, kh.kh_dienthoai";

        $result = mysqli_query($conn, $sql);

        $danhsachdonhang = [];

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

            $danhsachdonhang[] = array(
                'dh_ma'  =>  $row['dh_ma'],
                'dh_ngaylap'  =>  $row['dh_ngaylap'],
                'dh_ngaygiao'  =>  $row['dh_ngaygiao'],
                'dh_noigiao'  =>  $row['dh_noigiao'],
                'dh_trangthaithanhtoan'  =>  $row['dh_trangthaithanhtoan'],
                'httt_ten'  =>  $row['httt_ten'],
                'kh_ho'   => $row['kh_ho'],
                'kh_ten'   => $row['kh_ten'],
                'kh_dienthoai'   => $row['kh_dienthoai'],
                'tongthanhtien'   => $row['tongthanhtien']
            );
        }
        
        //var_dump($danhsachdonhang);
    
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
            
            <div class="col-md-12">
                <h1 style="display: block;">Xử lý Đơn đặt hàng</h1>

                <a href="create.php" class="btn btn-outline-primary mb-3 align-baseline"><i class="fa fa-plus" aria-hidden="true"></i> Thêm đơn mới</a>

                <table id="danhsach" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Mã đơn hàng</th>
                            <th>Khách hàng</th>
                            <th>Ngày lập</th>
                            <th>Ngày giao</th>
                            <th>Nơi giao</th>
                            <th>Hình thức thanh toán</th>
                            <th>Tổng thành tiền</th>
                            <th>Trạng thái thanh toán</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($danhsachdonhang as $dh): ?>
                            <tr>
                                <td><?= $dh['dh_ma']?></td>
                                <td><b><?php echo $dh['kh_ho'] . ' ' . $dh['kh_ten']?></b><br>(<?= $dh['kh_dienthoai']?>)</td>
                                <td><?= date('d/m/Y H:i:s', strtotime($dh['dh_ngaylap']))?></td>
                                <td><?= date('d/m/Y H:i:s', strtotime($dh['dh_ngaygiao']))?></td>
                                <td><?= $dh['dh_noigiao']?></td>
                                <td><span class="badge badge-pill httt"><?= $dh['httt_ten']?></span></td>
                                <td><?= number_format($dh['tongthanhtien'], 0, ',', '.')?> VND</td>
                                <td><?php if ($dh['dh_trangthaithanhtoan'] == 0): ?>
                                        <span class="badge badge-pill notdone">Chưa xử lý</span>
                                    <?php else: ?>
                                        <span class="badge badge-pill done">Đã giao hàng</span>
                                    <?php endif; ?></td>
                                <td style='white-space: nowrap'><?php if ($dh['dh_trangthaithanhtoan'] == 0): ?>
                                        <a href="edit.php?dh_ma=<?= $dh['dh_ma']?>" class="btn btn-outline btnSua mr-2"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Cập nhập</a>
                                    <a href="#" class="btn btn-outline btnDelete" data-sp_ma="<?= $dh['dh_ma']?>"><i class="fa fa-trash-o" aria-hidden="true"></i> Xóa</a>
                                    <?php else: ?>
                                        <a href="print.php?dh_ma=<?= $dh['dh_ma']?>" class="btn btn-outline btnIn mr-2"><i class="fa fa-print" aria-hidden="true"></i> In</a>
                                    <?php endif; ?>
                                    </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php 
        include_once __DIR__ . '/../layout/footer.php';
    ?>

    <?php 
        include_once __DIR__ . '/../../scripts/scripts.php';
    ?>

    <script>
        
        // find the table
        $(document).ready(function() {
            

            // find every Delete buttons => yêu cầu
            $('#danhsach').on('click', '.btnDelete', function() {
                // current button being clicked
                var sp_ma = $(this).data('sp_ma');

                Swal.fire({
                        title: 'Bạn có chắc chắn xóa không?',
                        text: "Một khi xóa thì không thể phục hồi!!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'YESS!'
                        }).then((result) => {
                            if (result.isConfirmed) {

                                location.href = "delete.php?dh_ma=" + dh_ma;
                            }
                        })
            });
            
        });

        
    </script>
</body>
</html>