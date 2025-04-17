<?php 
    session_start();

    if (isset($_GET['sp_ma'])) {
        if(isset($_GET['sp_dh_soluong'])) {
            $sp_dh_soluong = $_GET['sp_dh_soluong']; // in xem chi tiet san pham
        } else {
            $sp_dh_soluong = 1; // in index // mỗi lần lấy 1
        }

        $sp_ma = $_GET['sp_ma'];
        if (array_key_exists($sp_ma, $_SESSION['giohang'])) {
            //print_r($_SESSION['giohang'][$sp_ma]['sp_dh_soluong'] + 1);
            $_SESSION['giohang'][$sp_ma] = array('sp_dh_soluong'    =>  $_SESSION['giohang'][$sp_ma]['sp_dh_soluong'] + 1);
        } else {
            $_SESSION['giohang'][$sp_ma] = array('sp_dh_soluong'    =>  $sp_dh_soluong);
        }

        $_SESSION['status'] = 'Done';

        // redirect
        if(isset($_GET['sp_dh_soluong'])) {
            header('location:xemchitietsanpham.php?sp_ma=' . $sp_ma); // in xem chi tiet san pham
        } else {
            header('location:../'); // in index
        }
    }

    
    
?>