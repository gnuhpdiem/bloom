<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách loại sản phẩm</title>

    <?php 
        include_once __DIR__ . '/../../styles/styles.php';
    ?>
    
    
</head>
<body>
    

    <?php 

        include_once __DIR__ . '/../../dbconnect.php';


        $sql = "SELECT * FROM loaisanpham;";

        $result = mysqli_query($conn, $sql);

        $danhsachloaisanpham = [];

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

            $danhsachloaisanpham[] = array(
                'lsp_ma'  =>  $row['lsp_ma'],
                'lsp_ten'   => $row['lsp_ten'],
                'lsp_tentaptin' =>  $row['lsp_tentaptin']
            );
        }
        
        //var_dump($danhsachloaisanpham);
    
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
                <?php if (isset($_SESSION['status'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Thành công!</strong> <?php echo $_SESSION['status'];?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php unset($_SESSION['status']); ?>
                <?php endif; ?>
                <h1 style="display: block;">Danh sách loại sản phẩm</h1>

                <a href="create.php" class="btn btn-outline-primary mb-3 align-baseline"><i class="fa fa-plus" aria-hidden="true"></i> Thêm loại sản phẩm</a>

                <table id="danhsach" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Mã loại</th>
                            <th>Hình</th>
                            <th>Tên loại</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($danhsachloaisanpham as $lsp): ?>
                            <tr>
                                <td><?= $lsp['lsp_ma']?></td>
                                <td><img src="/bloom/assets/uploads/<?= $lsp['lsp_tentaptin']?>" style="width: 200px;"></td>
                                <td><?= $lsp['lsp_ten']?></td>
                            
                                <td><a href="edit.php?lsp_ma=<?= $lsp['lsp_ma']?>" class="btn btn-outline-primary mr-2"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Sửa</a>
                                <a href="#" class="btn btn-outline-danger btnDelete" data-lsp_ma="<?= $lsp['lsp_ma']?>"><i class="fa fa-trash-o" aria-hidden="true"></i> Xóa</a></td>
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
        
        // find every Delete buttons => yêu cầu
        $('#danhsach').on('click', '.btnDelete', function() {
                // current button being clicked
                var lsp_ma = $(this).data('lsp_ma');

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

                                location.href = "delete.php?lsp_ma=" + lsp_ma;
                            }
                        })
            });
        
    </script>
</body>
</html>