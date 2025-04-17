<!-- Trang khi người dùng admin nhập sai địa chỉ/ địa chỉ không tồn tại -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php 
        include_once __DIR__ . '/../styles/styles.php';
    ?>
</head>
<body>
    <?php 
        include_once __DIR__ . '/layout/header.php';
    ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="error_page">
                    <h1>404</h1>
                    <h5>Trang không tồn tại!</h5>
                    <a class="btn btn-outline-primary" href="/bloom/backend/dashboard.php">Quay trở về trang chủ</a>
                </div>
            </div>
        </div>
    </div>
    <?php 
        include_once __DIR__ . '/layout/footer.php';
    ?>

    <?php 
        include_once __DIR__ . '/../scripts/scripts.php';
    ?>
</body>
</html>