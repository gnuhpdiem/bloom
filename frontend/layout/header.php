<?php 
    session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  
  <link rel="stylesheet" type="text/css" href="/bloom/styles/header-user.css">
  <!-- Style -->
  <?php 
        include_once __DIR__ . '/../../styles/styles.php';
  ?>

  <?php 
    include_once __DIR__ . '/../../dbconnect.php';

    $sqlLoaiSP = "SELECT * FROM loaisanpham";
    $resultLoaiSP = mysqli_query($conn, $sqlLoaiSP);

    $dslsp = [];

    while ($row = mysqli_fetch_array($resultLoaiSP, MYSQLI_ASSOC)) {
        $dslsp[] = array(
            'lsp_ma'    =>  $row['lsp_ma'],
            'lsp_ten'    =>  $row['lsp_ten'],
            'lsp_tentaptin' =>  $row['lsp_tentaptin']
        );
    }
  
  ?>
  
</head>
<body class="body-header">
  <header>

    <nav class="header-nav">

      <!-- menu bar (appear when in mobile) -->
      <div id="menu-toggle">
        <input type="checkbox" name="checkbox"> <!-- a hidden checkbox to toggle -->
        
          <span></span>
          <span></span>
          <span></span>
  
        <ul id="header-menu-mobile">
          <li style="padding-top: 85px;"><a href="/bloom/#top_page">Trang chủ</a></li>
          <li><a href="/bloom/#danh_sach_san_pham">Sản phẩm</a></li>
          <li><a href="/bloom/#loai_san_pham">Loại sản phẩm</a></li>
          <li><a href="/bloom/#loai_san_pham">About</a></li>
          <li>Trang</li>
        </ul>
      </div>

      <!-- big logo -->
      <div class="logo">
        <a href="/bloom/">
          <img src="/bloom/assets/img/Bloom Horizontal white.png" style="width: 180px; height: auto-fit">
        </a>
        
        <!-- <a href="/bloom/">Bloom!</a> -->
        <div class="logo-overlay"></div>
      </div>

      <!-- menu list (dissappear when in mobile)-->
      <ul class="header-menu">
        <li><a href="/bloom/#top_page">Trang chủ</a></li>
        <li><a href="/bloom/#danh_sach_san_pham">Sản phẩm</a></li>
        <li class="dropdown-hover"><a href="/bloom/#loai_san_pham">Loại sản phẩm <i class="fa fa-caret-down" aria-hidden="true"></i></a>
          <ul class="dropdown_list">
            <?php foreach($dslsp as $lsp):?>
              <li><a href="/bloom/index.php?lsp_ma=<?php echo $lsp['lsp_ma']; ?>"><?php echo $lsp['lsp_ten']; ?></a></li>
            <?php endforeach; ?>
          </ul>
        </li>
        <li class="dropdown-hover"><a href="#">Trang <i class="fa fa-caret-down" aria-hidden="true"></i></a>
          <ul class="dropdown_list">
            <li><a href="/bloom/frontend/about.php">About</a></li>
            <li><a href="/bloom/frontend/contact.php">Liên hệ</a></li>
            <li><a href="/bloom/frontend/giohang.php">Giỏ hàng</a></li>
            <li><a href="/bloom/frontend/thanhtoan.php">Thanh toán</a></li>
          </ul>
        </li>
  
        <!--<li><a href="/bloom/backend/sanpham/">Giao hàng</a></li>-->
      </ul>

        
        
      <div class="icons">
      
        
        <div id="user-btn" class="user-btn">
          <div class="user-logo"><i class="fa fa-user-circle-o fa-fw fa-lg" aria-hidden="true"></i></div>
          <?php if (isset($_SESSION['dadangnhap']) && $_SESSION['dadangnhap'] == true): ?>
            <div class="user-info">
              <div class="display-username">
                  <span class="username"><li class="dropdown-hover" style="list-style: none; text-transform: none;">Hello, <?= $_SESSION['kh_tendangnhap']?> <i class="fa fa-caret-down" aria-hidden="true"></i>
                    <ul class="dropdown_list">
                      <li><a href="/bloom/dangxuat.php">Đăng xuất</a></li>
                    </ul>
                  </li></span>
              </div>
            </div>
          <?php else: ?>
            <span class="login text-decoration-none"><a href="/bloom/dangnhap.php" style="color: inherit;">Đăng nhập</a></span>
          <?php endif; ?>
        </div>

        
        <div class="cart-icon-desktop">

          <li class="dropdown-hover" style="list-style: none; text-transform: none;">
          <a href="/bloom/frontend/giohang.php" style="text-decoration: none;">
            <i class="fa fa-shopping-cart fa-fw fa-lg" aria-hidden="true"></i>
              <?php if (empty($_SESSION['giohang'])): ?>
                <?php $count = 0; ?> 
              <?php else: ?>
              <?php 
                  
                $giohang = $_SESSION['giohang'];
                $count = count($giohang);
                  
              ?>
              <?php endif; ?>
            <span>(<?php echo $count ?>)</span>
          </a>
          <?php if (empty($_SESSION['giohang'])): ?>
          <?php else: ?>
          <?php $tong = 0;?>
            
            <ul class="dropdown_list" style="right: 70px; min-width: 400px; background-color: white; overflow-y: scroll;
    height: 400px;">
              <?php foreach($giohang as $index => $sp): 
                $sql = "SELECT *, MIN(hsp.hsp_tentaptin) FROM sanpham AS sp
                    LEFT JOIN hinhsanpham AS hsp ON hsp.sp_ma = sp.sp_ma
                    WHERE sp.sp_ma = $index;";

                $result = mysqli_query($conn, $sql);

                $dssanpham = [];

                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
              ?>
                <li><a href="/bloom/frontend/xemchitietsanpham.php?sp_ma=<?php echo $row['sp_ma'] ?>">
                  
                  <div class="cart-detail">
                    <div class="cart-detail-img">
                    <?php if (empty($row['hsp_tentaptin'])):?>
                        <img src="/bloom/assets/img/default-thumbnail.jpg" class="img-fluid">
                    <?php else: ?>    
                        <img src="/bloom/assets/uploads/<?php echo $row['hsp_tentaptin'];?>" class="img-fluid">
                    <?php endif; ?>
                    </div>
                    <div class="cart-detail-product">
                      <p><?php echo $row['sp_ten'];?></p>
                      <span class="price text-info"> <?php echo number_format($row['sp_gia'], 0, ',', '.');?></span> <span class="count"> &#8226; Số lượng: <?php echo $sp['sp_dh_soluong']; ?></span>
                    </div>
                  </div>
                  </a>
                </li>
                <?php $tong += ($sp['sp_dh_soluong'] * $row['sp_gia']);?>
              <?php endforeach; ?>

              <div class="total-header-section">
                  <div class="total-price" style="display: flex; justify-content: space-around; align-items: center;">
                    <p>Sản phẩm: <span><?php echo $count?></span></p>
                  <p>Tổng: <span class="text-info"><?php echo number_format($tong, 0, ',', '.');?> VND</span></p>
                </div>
              </div>
            <hr style="border-top: 2px solid #ccc;">
            
            <div class="view-cart d-flex justify-content-between">
              <a href="/bloom/frontend/giohang.php" class="btn btn-primary-1">Xem giỏ hàng</a>
              <a href="/bloom/frontend/thanhtoan.php" class="btn btn-primary-2">Xác nhận</a>
            </div>
            
          </ul>
          <?php endif; ?>
          </li>
            
          
          
        </div>
        
      </div>

      
    </nav>

  </header>

  <!-- Scripts -->
  <?php 
      include_once __DIR__ . '/../../scripts/scripts.php';
  ?>

  <script>
  
  </script>
  
</body>
</html>
