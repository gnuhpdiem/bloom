<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa thông tin sản phẩm</title>

    <?php 
        include_once __DIR__ . '/../../styles/styles.php';
    ?>
    
    
</head>
<body>
    

    <?php 

        include_once __DIR__ . '/../../dbconnect.php';

        // Tìm dữ liệu cũ ---------------------------------------
        $lsp_ma = $_GET['lsp_ma'];

        $sqlTimLoaiSanPhamCu = "SELECT *
                            FROM loaisanpham
                            WHERE lsp_ma=$lsp_ma;";

        $resultLoaiSanPhamCu = mysqli_query($conn, $sqlTimLoaiSanPhamCu);

        $danhsachLoaiSanPhamCu = [];

        while ($row = mysqli_fetch_array($resultLoaiSanPhamCu, MYSQLI_ASSOC)) {

            $danhsachLoaiSanPhamCu = array(
                'lsp_ma'  =>  $row['lsp_ma'],
                'lsp_ten'  =>  $row['lsp_ten'],
                'lsp_tentaptin' =>  $row['lsp_tentaptin']
            );
        }

        //var_dump($danhsachLoaiSanPhamCu);
    
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
                <h1 style="display: block;">Sửa thông tin loại sản phẩm</h1>
                <form name="form_insert" id="form_insert" method="POST" action="" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Tên loại sản phẩm</label>
                        <input type="text" name="lsp_ten" id="lsp_ten" class="form-control" value="<?= $danhsachLoaiSanPhamCu['lsp_ten']?>">
                        <small class="form-text text-muted">Tên loại sản phẩm</small>
                    </div>
                    <div class="form-group">
                        <label for="lsp_tentaptin">Hình ảnh:</label>
                        <input type="file" name="lsp_tentaptin" id="lsp_tentaptin">
                        <div>
                            <input type="hidden" name="lsp_tentaptin" value="<?php echo $danhsachLoaiSanPhamCu['lsp_tentaptin']?>">
                            <img src="/bloom/assets/uploads/<?php echo $danhsachLoaiSanPhamCu['lsp_tentaptin']?>" id="preview_img" style="width: 200px;">
                        </div>
                    </div>
                    <div class="form-group">
                        <a href="index.php" class="btn btn-outline-secondary">Quay lại</a>
                        <button name="btnluu" class="btn btn-outline-primary">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php 
        if(isset($_POST['btnluu'])){
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $lsp_ten = $_POST['lsp_ten'];
            $lsp_tentaptin = $_POST['lsp_tentaptin'];


            // --------------------- VALIDATION ---------------------------------------
            
            $errors = []; // giả sử chưa vi phạm gì hết == null

            // _________ TÊN SP __________________
            //rule: required (nếu không nhập gì) -> lỗi đầu tiên
            if(empty($lsp_ten)) {

                $errors['lsp_ten'][] = [
                    // key => value
                    'rule'  =>  'required',
                    'rule_value'    =>  true,
                    'value' =>  $lsp_ten,
                    'msg'   => 'Phải có tên loại sản phẩm'  
                ];
            }

            //rule: minlength 3 (quá ít kí tự) -> lỗi thứ 2
            else if(strlen($lsp_ten) < 3) {

                $errors['sp_ten'][] = [
                    'rule'  =>  'minlength',
                    'rule_value'    =>  3,
                    'value' =>  $lsp_ten,
                    'msg'   => 'Tên ngắn quá! (ít nhất là 3 ký tự)'  
                ];
            }
            
            
            //rule: maxlength 10 (quá nhiều kí tự) -> lỗi thứ 3
            else if(strlen($lsp_ten) > 100) {
                $errors['lsp_ten'][] = [
                    'rule'  =>  'maxlength',
                    'rule_value'    =>  100,
                    'value' =>  $lsp_ten,
                    'msg'   => 'Tên quá dài! (nhiều nhất là 100 ký tự)'  
                ];
            }
        

        
            // Nếu không có lỗi VALIDATE dữ liệu (tức là dữ liệu đã hợp lệ)
            // Tiến hành thực thi câu lệnh SQL Query Database    
            //--------------------------------------------------------
            // if THERE IS NO ERRORS
            if(count($errors) == 0) {

                // neu nhan duoc hinh
                if (!empty($_FILES['lsp_tentaptin']['name'])){

                    $uploaddir = __DIR__ . '/../../assets/uploads/';

                    $newfilename = date('Ymd_His') . '_' . $_FILES['lsp_tentaptin']['name']; // doi ten

                    move_uploaded_file($_FILES['lsp_tentaptin']['tmp_name'], $uploaddir . $newfilename);


                    // xoá file cũ
                    unlink($uploaddir . $lsp_tentaptin);

                    // update tên hình
                    $lsp_tentaptin = $newfilename;
                }


                $sqlloaisanphamUpdate = "UPDATE loaisanpham
                                    SET
                                        lsp_ten='$lsp_ten',
                                        lsp_tentaptin='$lsp_tentaptin'
                                    WHERE lsp_ma=$lsp_ma;";



                if(mysqli_query($conn, $sqlloaisanphamUpdate)) {
                    $_SESSION['status'] = 'Đã sửa một loại sản phẩm!';
                    echo '<script>location.href = "index.php"</script>';
                } else {
                    echo 'Thực hiện không thành công!' . '<br>Lỗi: ' . mysqli_error($conn);
                }

                //var_dump($sqlloaisanphamUpdate);

                    
            }
        }
    ?>
    


        <!-- Nếu có lỗi VALIDATE dữ liệu thì hiển thị ra màn hình
         khi bấm nút và khi lỗi có tồn tại và khi có xuất hiệu 1 cái key nào trong biến lỗi đó -->
        <?php if(isset($_POST['btnluu']) && isset($errors) && count($errors) > 0): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Có lỗi!</strong> Vui lòng kiểm tra cái thông tin sau:
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


        $(document).ready(function(){
            $('#form_insert').validate({
                rules: {
                    lsp_ten: {
                        required: true,
                        minlength: 3,
                        maxlength: 100
                    }
                },
                messages: {
                    lsp_ten: {
                        required: 'Phải có tên sản phẩm.',
                        minlength: 'Tên ngắn quá! (ít nhất là 3 ký tự)',
                        maxlength: 'Tên quá dài! (nhiều nhất là 100 ký tự)'
                    }
                }
            });

            // Hiển thị ảnh preview (xem trước) khi người dùng chọn Ảnh
            const reader = new FileReader();
            const fileInput = document.getElementById("lsp_tentaptin");
            const img = document.getElementById("preview_img");
            reader.onload = e => {
            img.src = e.target.result;
            }
            fileInput.addEventListener('change', e => {
            const f = e.target.files[0];
            reader.readAsDataURL(f);
            })
        });

    </script>
    
</body>
</html>