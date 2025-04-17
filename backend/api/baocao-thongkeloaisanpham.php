<?php 

    include_once __DIR__ . '/../../dbconnect.php';

    $sql = "SELECT lsp.lsp_ten, COUNT(*) AS tongSanPham
            FROM sanpham AS sp 
            JOIN loaisanpham AS lsp ON sp.lsp_ma = lsp.lsp_ma
            GROUP BY lsp.lsp_ten;";

    $result = mysqli_query($conn, $sql);

    $data = [];

    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $data[] = array(
            'tenLoaiSanPham'    =>  $row['lsp_ten'],
            'SoLuongSanPham'    =>  $row['tongSanPham']
        );
    }
    //var_dump($data);

    // array -> json
    $json = json_encode($data);

    echo $json;

?>