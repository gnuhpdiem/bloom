<?php 
    session_start();
    if (isset($_GET['sp_ma'])) {
        $sp_ma = $_GET['sp_ma'];
        unset($_SESSION['giohang'][$sp_ma]);

        header('location:giohang.php');
    }

?>