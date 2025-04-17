<?php 
    session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php 
        include_once __DIR__ . '/../../styles/styles.php';
    ?>
  <link rel="stylesheet" type="text/css" href="/bloom/styles/header-admin.css">
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
            <li style="padding-top: 85px;"><a href="/bloom/backend/dashboard.php">Home</a></li>
            <li><a href="/bloom/backend/sanpham/">Sản phẩm</a></li>
            <li><a href="/bloom/backend/hinhsanpham/">Hình sản phẩm</a></li>
            <li><a href="/bloom/backend/loaisanpham/">Loại sản phẩm</a></li>
            <li><a href="/bloom/backend/dondathang/">Đơn hàng</a></li>
          </ul>
      </div>

      <!-- big logo -->
      <div class="logo">
        <a href="/bloom/backend/dashboard.php">
        <img src="/bloom/assets/img/Bloom Horizontal white.png" style="width: 180px; height: auto-fit">
        </a>
        <div class="logo-overlay"></div>
      </div>

      <!-- menu list (dissappear when in mobile)-->
      <ul class="header-menu">
        <li><a href="/bloom/backend/dashboard.php">Home</a></li>
        <li class="dropdown">Sản phẩm +
          <ul class="dropdown_list">
            <li><a href="/bloom/backend/sanpham/">Sản phẩm</a></li>
            <li><a href="/bloom/backend/hinhsanpham/">Hình sản phẩm</a></li>
          </ul>
        </li>
        <li><a href="/bloom/backend/loaisanpham/">Loại sản phẩm</a></li>
        <li><a href="/bloom/backend/dondathang/">Đơn hàng</a></li>
  
        <!--<li><a href="/bloom/backend/sanpham/">Giao hàng</a></li>-->
      </ul>

        
        
      <div class="icons">
      
        
        <div id="user-btn" class="user-btn">
          <div class="user-logo"><i class="fa fa-user-circle-o fa-fw fa-lg" aria-hidden="true"></i></div>
          <?php if (isset($_SESSION['dadangnhap']) && $_SESSION['dadangnhap'] == true): ?>
            <div class="user-info">
              <div class="display-username">
                  <span>Hello, <?= $_SESSION['kh_tendangnhap']?></span>
              </div>
            </div>
          <?php else: ?>
            <span class="login"><a href="/bloom/dangnhap.php" style="color: inherit;">Đăng nhập</a></span>
          <?php endif; ?>
          
        </div>

        <a href="/bloom/dangxuat.php" class="btn btn-primary-2">Đăng xuất</a>
        
      </div>

        
          
          

      
    </nav>

  </header>

  <!-- Scripts -->
  <?php 
      include_once __DIR__ . '/../../scripts/scripts.php';
  ?>

  
</body>
</html>
