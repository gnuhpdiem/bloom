<?php 

    $sp_ma = $_GET['sp_ma'];

    include_once __DIR__ . '/../../dbconnect.php';

    $sqlXoaSanPham = "DELETE FROM sanpham WHERE sp_ma=$sp_ma;";

    mysqli_query($conn, $sqlXoaSanPham);

    echo '<script>
            location.href="index.php";
            </script>';

?>