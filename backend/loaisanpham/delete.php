<?php 

    $lsp_ma = $_GET['lsp_ma'];

    include_once __DIR__ . '/../../dbconnect.php';

    $sqlSelect = "SELECT * FROM loaisanpham WHERE lsp_ma = $lsp_ma;";

    $result = mysqli_query($conn, $sqlSelect);

    $dataSelect = [];

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

            $dataSelect = array(
                'lsp_ma'  =>  $row['lsp_ma'],
                'lsp_tentaptin'  =>  $row['lsp_tentaptin']
            );
        }



    // xoa file rac
    $uploaddir = __DIR__ . '/../../assets/uploads/';
    unlink($uploaddir . $dataSelect['lsp_tentaptin']);

    // xoa tren sql
    $sqlXoaLoaiSanPham = "DELETE FROM loaisanpham WHERE lsp_ma = $lsp_ma;";

    mysqli_query($conn, $sqlXoaLoaiSanPham);

    echo '<script>
            location.href="index.php";
            </script>';

?>