<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <!-- Styles -->
    <?php 
        include_once __DIR__ . '/../styles/styles.php';
    ?>

    <style>
        .panel-card {
            margin-bottom: 20px !important;
            border-radius: 4px;
            box-shadow: 0 1px 1px rgb(0 0 0 / 5%);
            position: relative;
            overflow: hidden; 
        }

        .panel-card-header {
            /*padding: 15px;*/
            position: relative;
        }

        .huge {
            font-size: 40px !important;
            line-height: normal !important;
            font-weight: bold !important;
        }

        .panel-card-footer {
            padding: 3px !important;
        }

        .panel-card-footer span {
            padding: 5px;
            font-size: 15px;
            line-height: 25px;
            font-weight: medium !important;
            opacity: 1;
        }

        .bg-pro {
            background: #00bae8;
        }

        .bg-cus {
            background: #16D39A;
        }

        .bg-don {
            background: #FF7588;
        }

        .bg-com {
            background: #FFA87D;
        }

        .bg-pro-dark {
            background: rgba(0, 0, 0, 0.15) !important;
        }

        .bg-cus-dark {
            background: rgba(0, 0, 0, 0.15) !important;
        }

        .bg-don-dark {
            background: rgba(0, 0, 0, 0.15) !important;
        }

        .bg-com-dark {
            background: rgba(0, 0, 0, 0.15) !important;
        }

        .icon {
            
            opacity: 0.3 !important;
            font-size: 80px !important;
            position: absolute !important;
            right: -8px !important;
            bottom: -16px !important;
            transform: rotate(-15deg);
            transform: all 0.7s ease-in-out !important;
            transition: 0.7s;
        }

        .panel-card:hover .icon {
            opacity: 0.5 !important;
            transform: rotate(0deg) scale(1.4) !important;
        }

        .panel-card-footer:hover{
            cursor: pointer;
            opacity: 0.3;
            color: red !important;
        }

    </style>

</head>
<body>
    <!-- Header -->
    <?php 
        include_once __DIR__ . '/layout/header.php';
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

    <!-- Main content -->
    <h1>This is the Dashboard</h1>
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <?php 
                    include_once __DIR__ . '/layout/slider.php';
                ?>
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-sm-3 mb-3 mb-md-0">
                        <div class="panel-card bg-pro">
                            <div class="panel-card-header bg-pro text-white">
                                <div class="card-body">
                                    
                                    <div id="baocaoSanPham" class="huge">0</div>
                                    <div>Tổng số mặt hàng</div>
                                    
                                    <div class="col text-right mt-0-7">
                                        <i class="fa fa-shopping-bag fa-4x text-white icon" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-card-footer bg-pro bg-pro-dark text-center text-white">
                                <span><i class="fa fa-refresh" aria-hidden="true"></i> Refresh</span>
                            </div>
                        </div>
                        
                    </div>
                    <div class="col-sm-3">
                        <div class="panel-card bg-cus">
                            <div class="panel-card-header bg-cus text-white">
                                <div class="card-body">
                                    
                                    <div id="baocaoKhachHang" class="huge">0</div>
                                    <div>Tổng số khách hàng</div>
                                    

                                    <div class="col text-right mt-0-7">
                                        <i class="fa fa-users fa-4x text-white icon" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-card-footer bg-cus bg-cus-dark text-center text-white">
                                <span><i class="fa fa-refresh" aria-hidden="true"></i> Refresh</span>
                            </div>
                            
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="panel-card bg-don">
                            <div class="panel-card-header bg-don text-white">
                                <div class="card-body">
                                    
                                    <div id="baocaoDonHang" class="huge">0</div>
                                    <div>Tổng số đơn hàng</div>

                                    <div class="col text-right mt-0-7">
                                        <i class="fa fa-pencil-square-o fa-4x text-white icon" aria-hidden="true"></i>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="panel-card-footer bg-don bg-don-dark text-center text-white">
                                    <span><i class="fa fa-refresh" aria-hidden="true"></i> Refresh</span>
                                </div>
                            
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="panel-card bg-com">
                            <div class="panel-card-header bg-com text-white">
                                <div class="card-body">
                                    
                                    <div id="baocaoGopY" class="huge">0</div>
                                    <div>Tổng số góp ý</div>
                                    
                                    <div class="col text-right mt-0-7">
                                        <i class="fa fa-commenting-o fa-4x text-white icon" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-card-footer bg-com bg-com-dark text-center text-white">
                                <span><i class="fa fa-refresh" aria-hidden="true"></i> Refresh</span>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="row">
                    <h2>Thống kê loại sản phẩm</h2>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <canvas id="chartthongkeloaisanpham"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>        
    <!-- Footer -->
    <?php 
        include_once __DIR__ . '/layout/footer.php';
    ?>

    <!-- Scripts -->
    <?php 
        include_once __DIR__ . '/../scripts/scripts.php';
    ?>

    <script src="/bloom/assets/vendors/chart-js/package/dist/chart.umd.js"></script>

    <script>
        $(function() {
            $.ajax('/bloom/backend/api/baocao-tongsomathang.php', {
                success: function(data) {
                    var obj = JSON.parse(data);
                    
                    $('#baocaoSanPham').html(obj.SoLuong);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $('#baocaoSanPham').html('Không thể lấy được thông tin!');
                }
            })
        });

        $(function() {
            $.ajax('/bloom/backend/api/baocao-tongsokhachhang.php', {
                success: function(data) {
                    var obj = JSON.parse(data);
                    
                    $('#baocaoKhachHang').html(obj.KhachHang);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $('#baocaoKhachHang').html('Không thể lấy được thông tin!');
                }
            })
        });

        $(function() {
            $.ajax('/bloom/backend/api/baocao-tongsodonhang.php', {
                success: function(data) {
                    var obj = JSON.parse(data);
                    
                    $('#baocaoDonHang').html(obj.DonHang);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $('#baocaoDonHang').html('Không thể lấy được thông tin!');
                }
            })
        });

        $(function() {
            $.ajax('/bloom/backend/api/baocao-tongsogopy.php', {
                success: function(data) {
                    var obj = JSON.parse(data);
                    
                    $('#baocaoGopY').html(obj.GopY);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $('#baocaoGopY').html('Không thể lấy được thông tin!');
                }
            })
        });

        $(function() {
            var $objchartthongkeloaisanpham;

            var $chartthongkeloaisanpham = document.getElementById('chartthongkeloaisanpham');

            $.ajax({
                url: '/bloom/backend/api/baocao-thongkeloaisanpham.php',
                type: 'GET',
                success: function(response) {
                    var data = JSON.parse(response);
                    var mylabels = [];
                    var mydata = [];
                    
                    $(data).each(function() {
                        mylabels.push(this.tenLoaiSanPham);
                        mydata.push(this.SoLuongSanPham);
                    })

                    mydata.push(0);
                    if (typeof $objchartthongkeloaisanpham !== "undefined") {
                        $objchartthongkeloaisanpham.destroy();
                    }
                    $objchartthongkeloaisanpham = new Chart($chartthongkeloaisanpham, {
                        type: 'bar',
                        data: {
                        labels: mylabels,
                        datasets: [{
                            
                            data: mydata,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(255, 159, 64, 0.2)',
                                'rgba(255, 205, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(153, 102, 255, 0.2)'
                                
                            ],
                            borderColor: [
                                'rgb(255, 99, 132)',
                                'rgb(255, 159, 64)',
                                'rgb(255, 205, 86)',
                                'rgb(75, 192, 192)',
                                'rgb(54, 162, 235)',
                                'rgb(153, 102, 255)'
                                
                            ],
                            borderWidth: 1
                        }]
                        },
                        options: {
                            
                            plugins: {
                                legend: {
                                    display: false
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        stepSize: 2
                                    }
                                }
                            }
                           
                        
                        }
                    })
                }
            })

        
        });
    </script>
</body>
</html>