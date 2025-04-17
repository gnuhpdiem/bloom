<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết sản phẩm</title>

    <?php 
        include_once __DIR__ . '/../styles/styles.php';
    ?>
    <link rel="stylesheet" type="text/css" href="/bloom/styles/home.css">
    <style>
        .main-pic {
            width: 100%;
            height: auto;
            object-fit: cover;
            vertical-align: middle;
            border-radius: 0.5rem;
            margin-bottom: 10px;
        }
        .small-pic {
            width: 150px;
        }
        .gia-tien {
            font-size: 25.2px;
        }

        .list-group-item {
            float: left;
            border: 0 !important;
            margin: 0px;
            padding: 10px 0px;
        }

    </style>

</head>
<body>
    <?php 
        include_once __DIR__ . '/layout/header.php';
    ?>
    <?php 
        include_once __DIR__ . '/../dbconnect.php';

        // ---------SAN PHAM --------------------------------------------

        $sp_ma = $_GET['sp_ma'];

        $sql = "SELECT *, lsp.lsp_ten FROM sanpham AS sp
                JOIN loaisanpham AS lsp ON lsp.lsp_ma = sp.lsp_ma
                WHERE sp_ma = $sp_ma;";

        $result = mysqli_query($conn, $sql);

        $dataSanPham = [];

        $dataSanPham = mysqli_fetch_array($result, MYSQLI_ASSOC);

        //var_dump($dataSanPham);

        // --------- HINH SAN PHAM --------------------------------------------

        $sqlHinh = "SELECT * FROM hinhsanpham
                    WHERE sp_ma = $sp_ma;";

        $resultHinh = mysqli_query($conn, $sqlHinh);

        $dataHinhSanPham = [];

        while($row = mysqli_fetch_array($resultHinh, MYSQLI_ASSOC)) {
            $dataHinhSanPham[] = array(
                'hsp_ma'  =>  $row['hsp_ma'],
                'hsp_tentaptin'  =>  $row['hsp_tentaptin'],
                'sp_ma'  =>  $row['sp_ma']
            );
        }
        
        //var_dump($dataHinhSanPham);

        // --------- LOAI SAN PHAM LIEN QUAN --------------------------------------------

        $sqlSPlienquan = "SELECT sp.sp_ma, sp.sp_ten, sp.sp_gia, sp.sp_giacu, sp.sp_mota, sp.lsp_ma, lsp.lsp_ten, hsp.hsp_tentaptin FROM sanpham as sp
        left JOIN hinhsanpham as hsp ON sp.sp_ma = hsp.sp_ma 
        JOIN loaisanpham as lsp on lsp.lsp_ma = sp.lsp_ma
        WHERE sp.sp_ma <> $sp_ma
        GROUP BY sp.sp_ma, sp.sp_ten, sp.sp_gia, sp.sp_giacu, sp.sp_mota, sp.lsp_ma, lsp.lsp_ten
        ORDER BY RAND()
        LIMIT 4;";
        $resultSPlienquan = mysqli_query($conn, $sqlSPlienquan);

        $dataSPlienquan = [];

        while($row = mysqli_fetch_array($resultSPlienquan, MYSQLI_ASSOC)) {
            $dataSPlienquan[] = array(
                'sp_ma'  =>  $row['sp_ma'],
                'sp_ten'  =>  $row['sp_ten'],
                'sp_gia'  =>  $row['sp_gia'],
                'sp_giacu'  =>  $row['sp_giacu'],
                'sp_mota'  =>  $row['sp_mota'],
                'hsp_tentaptin'  =>  $row['hsp_tentaptin'],
                'lsp_ma'    =>  $row['lsp_ma'],
                'lsp_ten'    =>  $row['lsp_ten']
            );
        }
        //var_dump($dataSPlienquan);
    ?>

    <div class="container">
        <!-- Vùng ALERT hiển thị thông báo -->
        <?php if (isset($_SESSION['status'])): ?>
            <script>
                alert("Product added to cart");</script>
            <?php unset($_SESSION['status']); ?>
        <?php endif; ?>
        <div class="row">
            <div class="col-md-12">
                <h2>Chi tiết sản phẩm</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <!-- Hình -->
                <?php if (empty($dataHinhSanPham)):?>
                    <img src="/bloom/assets/img/default-thumbnail.jpg" class="main-pic">
                <?php else: ?>
                    <?php foreach ($dataHinhSanPham as $index => $hsp):?>
                        <?php if ($index == 0):?>
                            <img src="/bloom/assets/uploads/<?php echo $hsp['hsp_tentaptin'];?>" class="main-pic">
                        <?php else: ?>
                            <img src="/bloom/assets/uploads/<?php echo $hsp['hsp_tentaptin'];?>" class="small-pic">
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
                
            </div>
            <div class="col-md-6">
                
                    <h1><?php echo $dataSanPham['sp_ten'];?></h1>
                    


                    <p>
                        <?php if ($dataSanPham['sp_gia'] != $dataSanPham['sp_giacu']): ?>
                            <?php if ($dataSanPham['sp_giacu'] == 0):?>
                                <!-- Không show giá -->
                            <?php else: ?>
                                <span class="text-muted"><del><?php echo number_format($dataSanPham['sp_giacu'], 0, ',', '.');?> VND</del></span>
                            <?php endif; ?>
                        <?php endif; ?>
                            <b><span class="gia-tien"><?php echo number_format($dataSanPham['sp_gia'], 0, ',', '.');?></span> VND</b>
                    </p>
                    
                    <a href="/bloom/index.php?lsp_ma=<?php echo $dataSanPham['lsp_ma'];?>"><p><?php echo $dataSanPham['lsp_ten']?></p></a>
                <form action="/bloom/frontend/luugiohang.php">
                    <input type="hidden" name="sp_ma" value="<?php echo $dataSanPham['sp_ma'];?>">
                        <div class="form-group row">
                                <label for="sp_dh_soluong" class="col-sm-5 col-form-label">Số lượng:</label>
                                <input  id="sp_dh_soluong" type="number" class="form-control" name="sp_dh_soluong" style="margin-left: 15px;">
                        </div>
                    

                    
                    
                    <a href="/bloom/" class="btn btn-outline-secondary">Quay lại</a>
                    <button class="btn btn-outline-primary" type="submit">Thêm vào giỏ hàng</button>

                </form>
            </div>
            
        </div>
        <div class="row">
            <div>
                <span style="line-height: 1.5em;"><h2>Thông tin sản phẩm</h2></span>
                <p><?php echo $dataSanPham['sp_mota'];?></p>
            </div>
        </div>
        
    </div>
    <?php if(!empty($dataSPlienquan)): ?>
            
            <section class="sp_section">
                <div class="container">
                <h2 style="line-height: 1.5em;">Sản phẩm khác</h2>
                <div class="row">
                    
                        <?php foreach($dataSPlienquan as $splq): ?>
                            <li class="col-xs-3 list-group-item" style="margin-right: 50px;">
                            
                            <form name="splienquan_form" method="post" action="">
                                <!-- Lưu thông tin -------------------------------------------------->
                                <input type="hidden" name="sp_ma" id="sp_ma" value="<?php echo $splq['sp_ma'];?>">
                                <input type="hidden" name="sp_ten" id="sp_ten" value="<?php echo $splq['sp_ten'];?>">
                                <input type="hidden" name="sp_gia" id="sp_gia" value="<?php echo $splq['sp_gia'];?>">
                                <input type="hidden" name="sp_dh_soluong" id="sp_dh_soluong" value="1">
                                
                                
                                <?php if (!empty($splq['hsp_tentaptin'])):?>
                                    <input type="hidden" name="sp_hinhdaidien" value="/bloom/assets/uploads/<?php echo $splq['hsp_tentaptin'];?>">
                                <?php else: ?>
                                    <input type="hidden" name="sp_hinhdaidien" value="/bloom/assets/img/default-thumbnail.jpg">
                                <?php endif; ?>
                                    
                                
                                <!------------------------------------------------------------------->
                                <a href="/bloom/frontend/xemchitietsanpham.php?sp_ma=<?php echo $splq['sp_ma'];?>" style="text-decoration: none;">
                                    
                                        <div class="car_sp_img">
                                            <?php if (!empty($splq['hsp_tentaptin'])):?>
                                                <img class="img-fluid image" loading="lazy" src="/bloom/assets/uploads/<?php echo $splq['hsp_tentaptin'];?>">
                                            <?php else: ?>
                                                    <img class="img-fluid image" loading="lazy" src="/bloom/assets/img/default-thumbnail.jpg">
                                            <?php endif; ?>
                                        </div>
                                        <div class="card_sp_body">
                                            <p style="color: var(--black-80);"><?php echo $splq['sp_ten'];?></p>
                                            <p style="color: var(--black-60); font-size: 14px;">
                                                <?php echo $splq['lsp_ten'];?>
                                            </p>
                                        <div>
                                            <?php if($splq['sp_gia'] != $splq['sp_giacu']): ?>
                                                <?php if ($splq['sp_giacu'] == 0): ?>
                                                    <br>
                                                <?php else: ?>
                                                    <small><span class="text-muted"><del><?php echo number_format($splq['sp_giacu'], 0, ',', '.');?> VND</del></span></small><br>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </div>

                                        
                                        <div style="display: flex; justify-content: space-between;">
                                            <span style="font-size: 20px; line-height: 30px; font-weight: 700; color: var(--black-80)" class="text-center"><?php echo number_format($splq['sp_gia'], 0, ',', '.');?> VND</span>
                                            <button type="submit" name="add_to_cart" class="btn btnCart"><img src="/bloom/assets/img/cart_img.png" width="20px" height="20px"></button>
                                        </div>
                                        

                                    </div>
                                    
                                </a>
                            </form>
                        
                    </li>
                        <?php endforeach; ?>
                    
                </div>
                </div>
            </section>
        <?php endif; ?>
    
    <?php 
        include_once __DIR__ . '/layout/footer.php';
    ?>

    <?php 
        include_once __DIR__ . '/../scripts/scripts.php';
    ?>
    <script>
        
    </script>
</body>
</html>