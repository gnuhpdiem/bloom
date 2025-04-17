<?php 

    session_start();

    unset($_SESSION['dadangnhap']);
    unset($_SESSION['kh_tendangnhap']);
    unset($_SESSION['kh_quantri']);

    session_destroy();

    echo '<script>location.href = "dangnhap.php";</script>';

?>