<?php 
    session_start();

    if(isset($_POST['btnDangKi'])) {
        $kh_ho = $_POST['kh_ho'];
        $kh_ten = $_POST['kh_ten'];
        $kh_tendangnhap = $_POST['kh_tendangnhap'];
        // ma hoa
        $kh_matkhau = md5($_POST['kh_matkhau']);
        $kh_diachi = html_entity_decode(strip_tags($_POST['kh_diachi']));
        $kh_dienthoai = html_entity_decode(strip_tags($_POST['kh_dienthoai']));

        // --------------------- VALIDATION ---------------------------------------
            
        $errors = []; // giả sử chưa vi phạm gì hết == null

        // _________ TÊN SP __________________
        //rule: required (nếu không nhập gì) -> lỗi đầu tiên
        if(empty($kh_ho)) {

            $errors['kh_ho'][] = [
                // key => value
                'rule'  =>  'required',
                'rule_value'    =>  true,
                'value' =>  $kh_ho,
                'msg'   => 'Phải có họ'  
            ];
        }

        if(empty($kh_ten)) {

            $errors['kh_ten'][] = [
                // key => value
                'rule'  =>  'required',
                'rule_value'    =>  true,
                'value' =>  $kh_ten,
                'msg'   => 'Phải có tên'  
            ];
        }

        if(empty($kh_tendangnhap)) {

            $errors['kh_tendangnhap'][] = [
                // key => value
                'rule'  =>  'required',
                'rule_value'    =>  true,
                'value' =>  $kh_tendangnhap,
                'msg'   => 'Phải có tên đăng nhập'  
            ];
        }

        if(empty($kh_matkhau)) {

            $errors['kh_matkhau'][] = [
                // key => value
                'rule'  =>  'required',
                'rule_value'    =>  true,
                'value' =>  $kh_matkhau,
                'msg'   => 'Phải có mật khẩu'  
            ];
        }

        if(empty($kh_diachi)) {

            $errors['kh_diachi'][] = [
                // key => value
                'rule'  =>  'required',
                'rule_value'    =>  true,
                'value' =>  $kh_diachi,
                'msg'   => 'Phải có mật khẩu'  
            ];
        }

        if(empty($kh_dienthoai)) {

            $errors['kh_dienthoai'][] = [
                // key => value
                'rule'  =>  'required',
                'rule_value'    =>  true,
                'value' =>  $kh_dienthoai,
                'msg'   => 'Phải có mật khẩu'  
            ];
        }

        
        include_once __DIR__ . '/dbconnect.php';

        // Nếu không có lỗi VALIDATE dữ liệu (tức là dữ liệu đã hợp lệ)
        // Tiến hành thực thi câu lệnh SQL Query Database    
        //--------------------------------------------------------
        // if THERE IS NO ERRORS
        if(count($errors) == 0) {

            // Check whether this username exists
            $existSql = "SELECT * FROM khachhang WHERE kh_tendangnhap = '$kh_tendangnhap'";
            $result = mysqli_query($conn, $existSql);
            $numExistRows = mysqli_num_rows($result);
            if($numExistRows > 0){
                // $exists = true;
                $_SESSION['status'] = 'Tên đăng nhập đã tồn tại!';
    }

            $sqluserinsert = "INSERT INTO khachhang
                                (kh_tendangnhap, kh_matkhau, kh_ho, kh_ten, kh_diachi, kh_dienthoai, kh_quantri)
                                VALUES ('$kh_tendangnhap', '$kh_matkhau', '$kh_ho', '$kh_ten', '$kh_diachi', '$kh_dienthoai', 0)";

    

            if (mysqli_query($conn, $sqluserinsert)) {
                $_SESSION['status'] = 'Đăng kí thành công!';
                // log in successfully
                $_SESSION['dadangnhap'] = true;
                $_SESSION['kh_tendangnhap'] = $kh_tendangnhap;
                $_SESSION['kh_quantri'] = $data['kh_quantri'];


                if ($_SESSION['kh_quantri'] == true) {
                    // nếu là quản trị viên
                    echo '<script>location.href = "/bloom/backend/dashboard.php";</script>';
                } else {
                    // nếu là người dùng thường
                    echo '<script>location.href = "/bloom/";</script>';
                }
                
            } else {
                //echo 'Đăng kí không thành công!' . '<br>Lỗi: ' . mysqli_error($conn);
            }

            //var_dump($sqluserinsert);
                
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dang ki</title>

    <?php 
        include_once __DIR__ . '/styles/styles.php';
    ?>
    
    <link rel="stylesheet" type="text/css" href="styles/dangnhap_dangki.css">
    
</head>
<body>

    <div class="container-fluid">
        <?php if(isset($_SESSION['dadangnhap']) && $_SESSION['dadangnhap'] == true): ?>
            <?php
                $bg_col = 'var(--white-100)';
                $text_col = 'var(--black-80)';
                $bg_img = 'url(/bloom/assets/img/flowers-174817_1280.jpg)';
                 $styleBlock = sprintf('
                 <style type="text/css">
                    body {
                      background-color:%s;
                      color:%s;
                      background-image:%s;
                    }
                    * > a {
                        color: var(--primary-1);
                    }
                    * > a:hover {
                        color: var(--primary-1);
                    }
                 </style>
               ', $bg_col, $text_col, $bg_img);
               echo $styleBlock;
            ?>
            <h2>Xin chào <?php echo $_SESSION['kh_tendangnhap']; ?>.</h2>
            Hãy bấm vào <?php 
                if ($_SESSION['kh_quantri'] == true) {
                    // nếu là quản trị viên
                    echo '<a href = "/bloom/backend/dashboard.php">đây</a>';
                } else {
                    // nếu là người dùng thường
                    echo '<a href = "/bloom/">đây</a>';
                }
            ?> để quay về trang chủ.<br>

            <a href="dangxuat.php" class="btn btn-outline-danger btnDelete">Đăng xuất</a>
        <?php else:?>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <img src="/bloom/assets/img/Bloom Vertical white.png" width="104px" height="131px">
            </div>
            <div class="col-md-6 text-right my-4">
                <p class="d-inline col_black">Đã có tài khoản rồi?</p>
                <a href="/bloom/dangnhap.php" role="button" class="btn btn-outline-info btnDangKi text-center col_black" style="border-radius: 32px; width: 150px; padding: 9px 7px 9px 7px;">Đăng nhập ngay!</a>
            </div>
        </div>
        <div class="row">
            
            <div class="col-md-12">
                <?php if (isset($_SESSION['status'])): ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Thất bại!</strong> <?php echo $_SESSION['status']; ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php unset($_SESSION['status']); ?>
                <?php endif; ?>
            <h2>Đăng kí</h2>
                
                
                    <form name="form_insert" id="form_insert" method="POST" action="">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                            <label for="kh_ho" class="col_black">Họ</label>
                            <input type="text" class="form-control" id="kh_ho" name="kh_ho">
                            </div>
                            <div class="form-group col-md-6">
                            <label for="kh_ten" class="col_black">Tên</label>
                            <input type="text" class="form-control" id="kh_ten" name="kh_ten">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="kh_tendangnhap" class="col_black">Tên tài khoản:</label> 
                            <input type="text" class="form-control" name="kh_tendangnhap" id="kh_tendangnhap" placeholder="Tên tài khoản">
                                
                        </div>
                        <div class="form-group">
                            <label for="kh_matkhau" class="col_black">Mật khẩu:</label>
                                
                            <input type="password" class="form-control" name="kh_matkhau" id="kh_matkhau" placeholder="Nhập password">
                            <small id="passwordHelpBlock" class="form-text text-muted">Mật khẩu của bạn phải dài 8-20 ký tự, chứa chữ cái và số và không được chứa dấu cách hoặc ký tự đặc biệt.</small>
                        </div>
                        <div class="form-group">
                            <label for="kh_diachi" class="col_black">Địa chỉ</label>
                            <input type="text" class="form-control" id="kh_diachi" name="kh_diachi">
                        </div>
                        <div class="form-group">
                            <label for="kh_dienthoai" class="col_black">Số điện thoại</label>
                            <input type="text" class="form-control" id="kh_dienthoai" name="kh_dienthoai">
                        </div>
                        
                        <div class="form-group row text-center">
                            <div class="col text-center">
                                <button name="btnDangKi" type="submit" class="btn btn-primary-2" style="border-radius: 32px; width: 300px; padding: 9px 7px 9px 7px;">Đăng kí</button>
                            </div>
                        </div>
                        
                    </form>
                <?php endif;?>
            </div>

            
        </div>
    </div>

    <?php 
        include_once __DIR__ . '/scripts/scripts.php';
    ?>

    <script>
        $(document).ready(function(){
            $('#form_insert').validate({
                rules: {
                    kh_ho: {
                        required: true
                    },
                    kh_ten: {
                        required: true
                    },
                    kh_tendangnhap: {
                        required: true
                    },
                    kh_matkhau: {
                        required: true
                    },
                    kh_diachi: {
                        required: true
                    },
                    kh_dienthoai: {
                        required: true
                    }
                },
                messages: {
                    kh_ho: {
                        required: 'Vui lòng nhập họ'
                    },
                    kh_ten: {
                        required: 'Vui lòng nhập tên'
                    },
                    kh_tendangnhap: {
                        required: 'Vui lòng nhập tên đăng nhập'
                    },
                    kh_matkhau: {
                        required: 'Vui lòng nhập mật khẩu'
                    },
                    kh_diachi: {
                        required: 'Vui lòng nhập địa chỉ'
                    },
                    kh_dienthoai: {
                        required: 'Vui lòng nhập số điện thoại'
                    }
                }
            });
        });
    </script>
</body>
</html>