<?php 

    include_once __DIR__ . '/../../dbconnect.php';

    $sql = "SELECT COUNT(*) as DonHang FROM dondathang;";

    $result = mysqli_query($conn, $sql);

    $data = mysqli_fetch_array($result, MYSQLI_ASSOC);

    //var_dump($data);

    // array -> json
    $json = json_encode($data);

    echo $json;

?>