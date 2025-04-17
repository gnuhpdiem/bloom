<?php 

    $hsp_ma = $_GET['hsp_ma'];

    include_once __DIR__ . '/../../dbconnect.php';

    $sqlSelect = "SELECT * FROM hinhsanpham WHERE hsp_ma = $hsp_ma;";

    $result = mysqli_query($conn, $sqlSelect);

    $dataSelect = [];

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

            $dataSelect = array(
                'hsp_ma'  =>  $row['hsp_ma'],
                'hsp_tentaptin'  =>  $row['hsp_tentaptin']
            );
        }
    


    // xoa file rac
    $uploaddir = __DIR__ . '/../../assets/uploads/';
    unlink($uploaddir . $dataSelect['hsp_tentaptin']);

    // xoa tren sql
    $sqlXoaHinhSanPham = "DELETE FROM hinhsanpham WHERE hsp_ma = $hsp_ma;";

    mysqli_query($conn, $sqlXoaHinhSanPham);

    echo '<script>
            location.href="index.php";
            </script>';

?>