<footer class="py-3 bg-dark text-white" style="margin-top: auto;">
    <div class="container">
        <?php if (isset($_SESSION['dadangnhap']) && $_SESSION['dadangnhap'] == true): ?>
            
              
            <span>Bạn đang đăng nhập bằng tài khoản <b><?= $_SESSION['kh_tendangnhap']?></b> (<a href="#">Đăng xuất</a>)</span>
              
            <span><ul>Link nhanh:
                <li><a href="/bloom/">Home</a></li>
            </ul></span>
        <?php else: ?>
            <span>Bạn chưa đăng nhập! (<a href="/bloom/dangnhap.php" style="color: inherit;">Đăng nhập</a>)</span>
        <?php endif; ?>
        <p class="text-white text-center" style="margin: 0;">Copyright &copy; <script>document.write(new Date().getFullYear());</script>, Bloom.</p>
    </div>
</footer>