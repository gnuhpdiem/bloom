<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm hình sản phẩm</title>

    <?php 
        include_once __DIR__ . '/../../styles/styles.php';
    ?>
    
    
</head>
<body>
    

    <?php 

        include_once __DIR__ . '/../../dbconnect.php';


        $sqlselectsanpham = "SELECT sp_ma, sp_ten FROM sanpham;";

        $resultselectsanpham = mysqli_query($conn, $sqlselectsanpham);

        $danhsachselectsanpham = [];

        while ($row = mysqli_fetch_array($resultselectsanpham, MYSQLI_ASSOC)) {

            $danhsachselectsanpham[] = array(
                'sp_ma'  =>  $row['sp_ma'],
                'sp_ten'  =>  $row['sp_ten']
            );
        }

        $hsp_ma = $_GET['hsp_ma'];

        
        $sqlSelectDulieuCu = "SELECT * FROM hinhsanpham WHERE hsp_ma = $hsp_ma;";

        $result = mysqli_query($conn, $sqlSelectDulieuCu);

        $dataDulieuCu = [];

            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

                $dataDulieuCu = array(
                    'hsp_ma'  =>  $row['hsp_ma'],
                    'hsp_tentaptin'  =>  $row['hsp_tentaptin'],
                    'sp_ma'  =>  $row['sp_ma']
                );
            }
        //var_dump($dataDulieuCu);
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
                <h1 style="display: block;">Sửa hình sản phẩm</h1>
                <form name="form_insert" id="form_insert" method="POST" action="" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="sp_ma">Sản phẩm:</label>
                        <select name="sp_ma" id="sp_ma" class="form-control">
                            <?php foreach($danhsachselectsanpham as $sp):?>
                                <?php if($sp['sp_ma'] == $dataDulieuCu['sp_ma']): ?>
                                    <option value="<?php echo $sp['sp_ma']?>" selected><?php echo $sp['sp_ten']?></option>
                                <?php else: ?>
                                    <option value="<?php echo $sp['sp_ma']?>"><?php echo $sp['sp_ten']?></option>
                                <?php endif;?>
                            <?php endforeach;?>
                        
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="hsp_tentaptin">Hình ảnh:</label>
                        <input type="file" name="hsp_tentaptin" id="hsp_tentaptin">
                        <div>
                            <input type="hidden" name="hsp_tentaptin" value="<?php echo $dataDulieuCu['hsp_tentaptin']?>">
                            <img src="/bloom/assets/uploads/<?php echo $dataDulieuCu['hsp_tentaptin']?>" id="preview_img" style="width: 200px;">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <a href="index.php" class="btn btn-outline-secondary">Quay lại</a>
                        <button name="btnLuu" type="submit" class="btn btn-outline-primary">Lưu</button>
                    </div>
                    
                </form>
            </div>

            <?php 
                if (isset($_POST['btnLuu'])) {
                    date_default_timezone_set('Asia/Ho_Chi_Minh');
                    $sp_ma = $_POST['sp_ma'];
                    $hsp_tentaptin = $_POST['hsp_tentaptin'];


                    // neu nhan duoc hinh
                    if (!empty($_FILES['hsp_tentaptin']['name'])){

                        $uploaddir = __DIR__ . '/../../assets/uploads/';

                        $newfilename = date('Ymd_His') . '_' . $_FILES['hsp_tentaptin']['name']; // doi ten

                        move_uploaded_file($_FILES['hsp_tentaptin']['tmp_name'], $uploaddir . $newfilename);


                        // xoá file cũ
                        unlink($uploaddir . $hsp_tentaptin);

                        // update tên hình
                        $hsp_tentaptin = $newfilename;
                    }

                    // update database
                    $sqlUpdate = "UPDATE hinhsanpham
                                    SET
                                        hsp_tentaptin='$hsp_tentaptin',
                                        sp_ma=$sp_ma
                                    WHERE hsp_ma = $hsp_ma;";
                    
                    if (mysqli_query($conn, $sqlUpdate)) {
                        $_SESSION['status'] = 'Đã sửa một hình sản phẩm!';
                        echo '<script>
                        location.href="index.php";
                        </script>';
                    } else {
                        echo 'Thực hiện không thành công!' . '<br>Lỗi: ' . mysqli_error($conn);
                    }

                }
            
            ?>
        </div>
    </div>

    


                
    <?php 
        include_once __DIR__ . '/../layout/footer.php';
    ?>

    <?php 
        include_once __DIR__ . '/../../scripts/scripts.php';
    ?>
    <script>

        $(document).ready(function() {

            // Hiển thị ảnh preview (xem trước) khi người dùng chọn Ảnh
            const reader = new FileReader();
            const fileInput = document.getElementById("hsp_tentaptin");
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