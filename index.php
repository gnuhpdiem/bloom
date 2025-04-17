<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title>Bloom</title>

    <!-- Styles -->
    <?php 
        include_once __DIR__ . '/styles/styles.php';
    ?>
    <link rel="stylesheet" type="text/css" href="/bloom/styles/home.css">

</head>
<body class="body_home">
    <!-- Header -->
    <?php 
        include_once __DIR__ . '/frontend/layout/header.php';
    ?>

    <?php 

        include_once __DIR__ . '/dbconnect.php';

        $sql = "SELECT sp.sp_ma, sp.sp_ten, sp.sp_gia, sp.sp_giacu, sp.sp_mota, sp.lsp_ma, lsp.lsp_ten, MIN(hsp.hsp_tentaptin) AS hsp_tentaptin
                FROM sanpham AS sp
                LEFT JOIN hinhsanpham AS hsp ON hsp.sp_ma = sp.sp_ma
                JOIN loaisanpham as lsp on lsp.lsp_ma = sp.lsp_ma
                GROUP BY sp.sp_ma, sp.sp_ten, sp.sp_gia, sp.sp_giacu, sp.sp_mota, sp.lsp_ma, lsp.lsp_ten";

        // kiểm người dùng có chọn 1 loại sản phẩm nào đó không 
        if (isset($_GET['lsp_ma'])) {
            $lsp_ma = $_GET['lsp_ma'];
            $sql .= " HAVING sp.lsp_ma = $lsp_ma;";
        }

        $result = mysqli_query($conn, $sql);

        $dssanpham = [];

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $dssanpham[] = array(
                'sp_ma'  =>  $row['sp_ma'],
                'sp_ten'  =>  $row['sp_ten'],
                'sp_gia'  =>  $row['sp_gia'],
                'sp_giacu'  =>  $row['sp_giacu'],
                'sp_mota'  =>  $row['sp_mota'],
                'lsp_ma'   => $row['lsp_ma'],
                'lsp_ten'   => $row['lsp_ten'],
                'hsp_tentaptin'  =>  $row['hsp_tentaptin']
            );
        }

        //var_dump($dssanpham);
        
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
    <?php if (isset($_SESSION['status'])): ?>
        <script>
            alert("Product added to cart");</script>
        <?php unset($_SESSION['status']); ?>
    <?php endif; ?>
    <section class="hero-section">
        <div class="container-fluid">
            <span id="top_page" class="hero_span">&nbsp;</span>
            <div class="hero-content">
                        
                <span class="w-auto px-2 text-uppercase"><h2>Bloom</h2></span>
                <div class="container-hero">
            
                    <p>Some paragraphs maybe</p>
                    
                    <button class="btn btnHome btn-lg">shop now</button>
                    
                </div>
                    
            </div>
        </div>
    </section>
    <span id="loai_san_pham">&nbsp;</span>
    <section class="lsp_section">
        <h2>Danh sách loại sản phẩm</h2>
        <div class="lsp">
            <?php foreach ($dslsp as $lsp): ?>
                <div style="background-image: url(/bloom/assets/uploads/<?php echo $lsp['lsp_tentaptin']; ?>);" onclick="location.href='/bloom/index.php?lsp_ma=<?php echo $lsp['lsp_ma']; ?>'">
                    <div class="img_overlay img_overlay--blur">
                        <div class="lsp_ten"><?php echo $lsp['lsp_ten']; ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
    </section>
    <span id="danh_sach_san_pham">&nbsp;</span>
    <section class="sp_section">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12"><h2>Danh sách sản phẩm</h2></div>
            </div>
            <div class="row">
                    <?php foreach($dssanpham as $sp): ?>
                        <div class="col-md-3">
                            <div class="col-md-12 mb-3">

                                <a href="/bloom/frontend/xemchitietsanpham.php?sp_ma=<?php echo $sp['sp_ma'];?>" style="text-decoration: none;">
                                    <li class="card_sp p-3">
                                        <div class="car_sp_img">
                                            <?php if (!empty($sp['hsp_tentaptin'])):?>
                                                <img class="img-fluid image" loading="lazy" src="/bloom/assets/uploads/<?php echo $sp['hsp_tentaptin'];?>">
                                            <?php else: ?>
                                                    <img class="img-fluid image" loading="lazy" src="/bloom/assets/img/default-thumbnail.jpg">
                                            <?php endif; ?>
                                        </div>
                                        <div class="card_sp_body">
                                                <p style="color: var(--black-80);"><?php echo $sp['sp_ten'];?></p>
                                                <p style="color: var(--black-60); font-size: 14px;">
                                                    <?php echo $sp['lsp_ten'];?>
                                                </p>
                                            <div>
                                                <?php if($sp['sp_gia'] != $sp['sp_giacu']): ?>
                                                    <?php if ($sp['sp_giacu'] == 0): ?>
                                                        <br>
                                                    <?php else: ?>
                                                        <small><span class="text-muted"><del><?php echo number_format($sp['sp_giacu'], 0, ',', '.');?> VND</del></span></small><br>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </div>

                                            
                                            <div style="display: flex; justify-content: space-between;">
                                                <span style="font-size: 20px; line-height: 30px; font-weight: 700; color: var(--black-80)" class="text-center"><?php echo number_format($sp['sp_gia'], 0, ',', '.');?> VND</span>
                                                <a href="/bloom/frontend/luugiohang.php?sp_ma=<?php echo $sp['sp_ma']; ?>" class="btn btnCart"><img src="/bloom/assets/img/cart_img.png" width="20px" height="20px"></a>
                                            </div>
                                        

                                        </div>
                                    </li>
                                </a>
                               
                            </div>
                        </div>
                    <?php endforeach; ?>
                    
            </div>
        </div>
    </section>
    
    <!-- Footer -->
    <?php 
        include_once __DIR__ . '/frontend/layout/footer.php';
    ?>

    <!-- Scripts -->
    <?php 
        include_once __DIR__ . '/scripts/scripts.php';
    ?>

</body>
    <script>
        
    </script>
</html>