<?php 
    session_start();

    if(isset($_POST['btnDangNhap'])) {
        $kh_tendangnhap = $_POST['kh_tendangnhap'];
        // ma hoa
        $kh_matkhau = md5($_POST['kh_matkhau']);


        include_once __DIR__ . '/dbconnect.php';

        $sql = "SELECT * FROM khachhang WHERE kh_tendangnhap = '$kh_tendangnhap' AND kh_matkhau = '$kh_matkhau'; ";

        $result = mysqli_query($conn, $sql);

        $data = [];

        $data = mysqli_fetch_array($result, MYSQLI_ASSOC);

        if(!empty($data)) {
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
            // fail to log in
            $_SESSION['status'] = 'Thông tin không chính xác!';
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dang nhap</title>

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
        <div class="gradient"></div>
        <div class="row">
            
            <div class="col-md-6">
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-2">
                        <img src="/bloom/assets/img/Bloom Vertical white.png" width="104px" height="131px">
                    </div>
                    <div class="col-md-8 text-right my-4">
                        <p class="d-inline col_black">Chưa có tài khoản?</p>
                        <a href="/bloom/dangki.php" role="button" class="btn btn-outline-info btnDangKi col_black" style="border-radius: 32px; width: 150px; padding: 9px 7px 9px 7px;">Đăng kí ngay!</a>
                    </div>
                    <div class="col-md-2"></div>
                </div>

                <div class="row">
                    <div class="col-md-7">
                        <?php if (isset($_SESSION['status'])): ?>
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <strong>Thất bại!</strong> <?php echo $_SESSION['status']; ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <?php unset($_SESSION['status']); ?>
                        <?php endif; ?>
                    <h2>Đăng nhập</h2>
                            <form name="form_insert" id="form_insert" method="POST" action="">
                                <div class="form-group">
                                    <label for="kh_tendangnhap" class="col_black">Tên đăng nhập:</label>   
                                    <input type="text" class="form-control" name="kh_tendangnhap" id="kh_tendangnhap" placeholder="Tên tài khoản">
                                        
                                </div>
                                <div class="form-group">
                                    <label for="kh_matkhau" class="col_black">Mật khẩu:</label>
                                    <input type="password" class="form-control" name="kh_matkhau" id="kh_matkhau" placeholder="Nhập password">
                                </div>
                                
								<div class="input-group">
									<div class="custom-checkbox custom-control col-6">
										<input type="checkbox" name="remember" id="remember" class="custom-control-input">
										<label for="remember" class="custom-control-label col_black">Nhớ tôi</label>
									</div>
									<label class="col-6 text-right">
										<a href="#" class="ml-6">Quên mật khẩu?</a>
									</label>
								</div>
                                <div class="form-group row text-center">
                                    <div class="col text-center">
                                        <button name="btnDangNhap" type="submit" class="btn btn-primary-2" style="border-radius: 32px; width: 300px; padding: 9px 7px 9px 7px;">Đăng nhập</button>
                                    </div>
                                </div>
                                
                            </form>
                        <?php endif;?>
                    </div>
                    <div class="col-md-5">

                    </div>
                

                
                </div>
            </div>
            
        </div>
        
    </div>

    <?php 
        include_once __DIR__ . '/scripts/scripts.php';
    ?>
</body>
</html>