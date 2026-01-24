    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-info">
                    <h2><?php echo SITE_NAME; ?></h2>
                    <p style="margin-bottom: 10px;"><?php echo COMPANY_ADDRESS; ?></p>
                    <p style="margin-bottom: 10px;">電話：<a href="tel:<?php echo str_replace('-', '', COMPANY_PHONE); ?>" style="color: #fff; font-weight: bold;"><?php echo COMPANY_PHONE; ?></a></p>
                    <p style="font-size: 0.8rem; opacity: 0.7;">適格請求書登録番号：<?php echo COMPANY_INVOICE; ?></p>
                </div>
                
                <div class="footer-nav">
                    <ul>
                        <li><a href="index.php">ホーム</a></li>
                        <li><a href="services.php">工事内容</a></li>
                        <li><a href="works.php">施工事例</a></li>
                        <li><a href="about.php">事業者情報</a></li>
                        <li><a href="contact.php">お問い合わせ</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="copyright">
                &copy; <?php echo date('Y'); ?> <?php echo COMPANY_NAME; ?> All Rights Reserved.
            </div>
        </div>
    </footer>

    </div> <!-- End .main-content -->
</div> <!-- End .page-wrapper -->

<!-- Mobile Fixed Footer (Visible only on mobile) -->
<div class="fixed-cta" style="display: none;"> <!-- Controlled by CSS @media -->
    <div class="fixed-footer-grid">
        <a href="tel:<?php echo str_replace('-', '', COMPANY_PHONE); ?>" class="footer-btn footer-btn-tel">
            <span class="footer-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M20.01 15.38c-1.23 0-2.42-.2-3.53-.56a.977.977 0 0 0-1.01.24l-2.2 2.2a15.05 15.05 0 0 1-6.59-6.59l2.2-2.21a.96.96 0 0 0 .25-1.01A11.36 11.36 0 0 1 8.5 3.99c.92-.83 2.15-1.29 3.51-1.29 0 0-.75 0 0 0h.01c0 0 0 0 0 0 1.1 0 2 0.9 2 2v2.5c0 1.1-.9 2-2 2H9.01c.64 3.32 3.03 6.03 6.64 6.96V18c0 1.1.9 2 2 2h2.5c1.1 0 2-.9 2-2v-1.12c0-1.36-1.01-2.49-2.14-2.5zm-3.53-2.56c.71.24 1.48.38 2.27.38.16 0 .32-.01.48-.02V18c0 .28-.22.5-.5.5h-2.5c-.28 0-.5-.22-.5-.5v-1.63zM12 3v2.5c0 .28-.22.5-.5.5H8.04c.16-1.55 1.42-2.83 2.97-3l.99-.02z"/><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg>
            </span>
            <span class="footer-label">電話する</span>
            <span class="footer-tel-number"><?php echo COMPANY_PHONE; ?></span>
        </a>
        <a href="contact.php" class="footer-btn footer-btn-mail">
            <span class="footer-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
            </span>
            <span class="footer-label">無料見積・問い合わせ</span>
        </a>
        <a href="#line" class="footer-btn footer-btn-line">
            <span class="footer-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2z"/></svg>
            </span>
            <span class="footer-label">LINEでかんたん<br>問い合わせ</span>
        </a>
    </div>
</div>

<style>
@media (max-width: 900px) {
    .fixed-cta { display: block !important; position: fixed; bottom: 0; left: 0; width: 100%; z-index: 2000; box-shadow: 0 -2px 10px rgba(0,0,0,0.1); }
   
}
</style>

<script src="assets/js/lightbox.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const footer = document.querySelector('.fixed-footer-grid');
    const sidebar = document.getElementById('sidebar'); // Get reference to sidebar
    let isScrolling;

    if (footer) {
        const showFooter = function() {
            // If sidebar is active, do NOT show footer
            if (sidebar && sidebar.classList.contains('active')) {
                footer.classList.remove('visible');
                return;
            }

            // Show footer
            footer.classList.add('visible');

            // Clear our timeout throughout the scroll
            window.clearTimeout(isScrolling);

            // Set a timeout to run after scrolling ends
            isScrolling = setTimeout(function() {
                // Hide footer faster (1.5s)
                footer.classList.remove('visible');
            }, 1500);
        };

        window.addEventListener('scroll', showFooter, false);
        window.addEventListener('touchstart', showFooter, false);
    }
});
</script>


<!-- Admin Mode Toolbar (Only visible to logged-in admins) -->
<?php if (isset($_SESSION['admin_id'])): ?>
<div class="admin-toolbar">
    <div class="admin-toolbar-content">
        <span class="admin-status-icon">🔧</span>
        <span class="admin-status-text">管理者モードで閲覧中</span>
        <a href="/admin/index.php" class="admin-return-btn">管理画面に戻る</a>
    </div>
</div>
<style>
    .admin-toolbar {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: #343a40; /* Dark admin color */
        color: #fff;
        padding: 10px 20px;
        border-radius: 50px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        z-index: 9999; /* Highest priority */
        font-family: sans-serif;
        border: 2px solid rgba(255,255,255,0.2);
        animation: slideIn 0.5s ease-out;
    }
    .admin-toolbar-content {
        display: flex;
        align-items: center;
        gap: 15px;
    }
    .admin-status-icon {
        font-size: 1.2rem;
    }
    .admin-status-text {
        font-weight: bold;
        font-size: 0.9rem;
    }
    .admin-return-btn {
        background: #007bff;
        color: white;
        text-decoration: none;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 0.85rem;
        transition: background 0.2s, transform 0.2s;
        font-weight: bold;
    }
    .admin-return-btn:hover {
        background: #0056b3;
        transform: scale(1.05);
    }
    @keyframes slideIn {
        from { transform: translateY(100px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    /* Mobile adjustment to avoid overlapping with fixed footer */
    @media (max-width: 900px) {
        .admin-toolbar {
            bottom: 80px; /* Above the mobile footer menu */
            right: 10px;
            padding: 8px 15px;
        }
        .admin-status-text {
            font-size: 0.8rem;
        }
    }
</style>
<?php endif; ?>

</body>
</html>

