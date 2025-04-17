<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm sản phẩm</title>

    <?php 
        include_once __DIR__ . '/../../styles/styles.php';
    ?>
    
    
</head>
<body>
    

    <?php 

        include_once __DIR__ . '/../../dbconnect.php';

        // -------------- LOAI SAN PHAM ---------------------------------------

        $sqlLoaisanpham = "SELECT * FROM loaisanpham;";

        $resultLoaisanpham = mysqli_query($conn, $sqlLoaisanpham);

        $danhsachLoaisanpham = [];

        while ($row = mysqli_fetch_array($resultLoaisanpham, MYSQLI_ASSOC)) {

            $danhsachLoaisanpham[] = array(
                'lsp_ma'  =>  $row['lsp_ma'],
                'lsp_ten'  =>  $row['lsp_ten']
            );
        }
        
        
        // -------------- KHUYEN MAI ---------------------------------------
        $sqlKhuyenmai = "SELECT * FROM khuyenmai;";

        $resultKhuyenmai = mysqli_query($conn, $sqlKhuyenmai);

        $danhsachKhuyenmai = [];

        while ($row = mysqli_fetch_array($resultKhuyenmai, MYSQLI_ASSOC)) {

            $danhsachKhuyenmai[] = array(
                'km_ma'  =>  $row['km_ma'],
                'km_ten'  =>  $row['km_ten']
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
            <div class="col-md-12">
                <h1 style="display: block;">Thêm sản phẩm</h1>
                <form name="form_insert" id="form_insert" method="POST" action="">
                    <div class="form-group">
                        <label>Tên sản phẩm</label>
                        <input type="text" name="sp_ten" id="sp_ten" class="form-control">
                        <small class="form-text text-muted">Tên sản phẩm</small>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Giá sản phẩm</label>
                                <input type="text" name="sp_gia" id="sp_gia" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Giá cũ</label>
                                <input type="text" name="sp_giacu" id="sp_giacu" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Mô tả</label>
                        <textarea name="sp_mota" id="sp_mota" id="sp_mota" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Số lượng</label>
                        <input type="number" name="sp_soluong" id="sp_soluong" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Loại sản phẩm</label>
                        <select name="lsp_ma" class="form-control">
                            <?php foreach($danhsachLoaisanpham as $lsp): ?>
                            <option value="<?= $lsp['lsp_ma']?>"><?= $lsp['lsp_ten']?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Khuyến mãi</label>
                        <select name="km_ma" class="form-control">
                            <option value="">Không có</option>
                            <?php foreach($danhsachKhuyenmai as $km): ?>
                            <option value="<?= $km['km_ma']?>"><?= $km['km_ten']?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                    <div class="form-group">
                        <button name="btnluu" class="btn btn-outline-primary">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php 
        if(isset($_POST['btnluu'])){
            $sp_ten = $_POST['sp_ten'];
            $sp_gia = $_POST['sp_gia'];
            $sp_giacu = empty($_POST['sp_giacu']) ? 0 : $_POST['sp_giacu'];
            $sp_mota = html_entity_decode(strip_tags($_POST['sp_mota']));
            $sp_soluong = $_POST['sp_soluong'];
            $lsp_ma = $_POST['lsp_ma'];
            $km_ma = empty($_POST['km_ma']) ? 'NULL' : $_POST['km_ma'];


            // --------------------- VALIDATION ---------------------------------------
            
            $errors = []; // giả sử chưa vi phạm gì hết == null

            // _________ TÊN SP __________________
            //rule: required (nếu không nhập gì) -> lỗi đầu tiên
            if(empty($sp_ten)) {

                $errors['sp_ten'][] = [
                    // key => value
                    'rule'  =>  'required',
                    'rule_value'    =>  true,
                    'value' =>  $sp_ten,
                    'msg'   => 'Phải có tên sản phẩm'  
                ];
            }

            //rule: minlength 3 (quá ít kí tự) -> lỗi thứ 2
            else if(strlen($sp_ten) < 3) {

                $errors['sp_ten'][] = [
                    'rule'  =>  'minlength',
                    'rule_value'    =>  3,
                    'value' =>  $sp_ten,
                    'msg'   => 'Tên ngắn quá! (ít nhất là 3 ký tự)'  
                ];
            }
            
            
            //rule: maxlength 10 (quá nhiều kí tự) -> lỗi thứ 3
            else if(strlen($sp_ten) > 100) {
                $errors['sp_ten'][] = [
                    'rule'  =>  'maxlength',
                    'rule_value'    =>  100,
                    'value' =>  $sp_ten,
                    'msg'   => 'Tên quá dài! (nhiều nhất là 100 ký tự)'  
                ];
            }

            // _________ GIÁ SP __________________
            //rule: required
            if (empty($sp_gia)) {
                
                $errors['sp_gia'][] = [
                    // key => value
                    'rule'  =>  'required',
                    'rule_value'    =>  true,
                    'value' =>  $sp_gia,
                    'msg'   => 'Phải có giá tiền'  
                ];
            }
        

        
            // Nếu không có lỗi VALIDATE dữ liệu (tức là dữ liệu đã hợp lệ)
            // Tiến hành thực thi câu lệnh SQL Query Database    
            //--------------------------------------------------------
            // if THERE IS NO ERRORS
            if(count($errors) == 0) {

                    $sqlsanphaminsert = "INSERT INTO sanpham
                                        (sp_ten, sp_gia, sp_giacu, sp_mota, sp_soluong, lsp_ma, km_ma)
                                        VALUES ('$sp_ten', $sp_gia, $sp_giacu, '$sp_mota', $sp_soluong, $lsp_ma, $km_ma);";

            

                    if (mysqli_query($conn, $sqlsanphaminsert)) {
                        $_SESSION['status'] = 'Đã thêm một sản phẩm!';
                        echo '<script>location.href = "index.php"</script>';
                        
                    } else {
                        echo 'Thực hiện không thành công!' . '<br>Lỗi: ' . mysqli_error($conn);
                    }

                    //var_dump($sqlsanphaminsert);
                        
                }
        }
    ?>
    


        <!-- Nếu có lỗi VALIDATE dữ liệu thì hiển thị ra màn hình
         khi bấm nút và khi lỗi có tồn tại và khi có xuất hiệu 1 cái key nào trong biến lỗi đó -->
        <?php if(isset($_POST['btnluu']) && isset($errors) && count($errors) > 0): ?>
            <div class="alert alert-danger alert-dismissible fade show animate__animated animate__fadeInRight" role="alert">
                <strong>Có lỗi!</strong> Vui lòng kiểm tra các thông tin sau:
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <ul>
                    <?php foreach($errors as $fields): ?>
                        <?php foreach($fields as $f): ?>
                            <li><?= $f['msg']?>.</li>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </ul>
            </div>

        <?php endif; ?>


                
    <?php 
        include_once __DIR__ . '/../layout/footer.php';
    ?>

    <?php 
        include_once __DIR__ . '/../../scripts/scripts.php';
    ?>
    <script>

        ClassicEditor
            .create( document.querySelector( '#sp_mota' ) )
            .catch( error => {
                console.error( error );
        } );


        $(document).ready(function(){
            $('#form_insert').validate({
                rules: {
                    sp_ten: {
                        required: true,
                        minlength: 3,
                        maxlength: 100
                    },
                    sp_gia: {
                        required: true
                    }
                },
                messages: {
                    sp_ten: {
                        required: 'Phải có tên sản phẩm.',
                        minlength: 'Tên ngắn quá! (ít nhất là 3 ký tự)',
                        maxlength: 'Tên quá dài! (nhiều nhất là 100 ký tự)'
                    },
                    sp_gia: {
                        required: 'Phải có giá tiền.'
                    }
                }
            });
        });


    </script>
    
</body>
</html>