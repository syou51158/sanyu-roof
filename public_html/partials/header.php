<?php 
// Ensure config is loaded if not already (header might be included standalone in some edge cases, though unlikely)
require_once __DIR__ . '/../config/config.php';
?>
<!-- Page Wrapper (Starts here, ends in footer.php) -->
<div class="page-wrapper">

    <!-- Mobile Header (Visible only on mobile) -->
    <header class="mobile-header">
        <div class="mobile-logo">
            <small>京都市伏見区の屋根修理</small>
            <a href="index.php"><?php echo SITE_NAME; ?></a>
        </div>
        <div class="mobile-header-actions">
            <a href="tel:<?php echo str_replace('-', '', COMPANY_PHONE); ?>" class="header-btn header-btn-tel">
                <span class="header-btn-icon">📞</span>
                <span>TEL</span>
            </a>
            <div class="header-btn header-btn-menu" id="menuToggle">
                <span class="header-btn-icon">☰</span>
                <span>MENU</span>
            </div>
        </div>
    </header>

    <!-- Sidebar (Navigation) -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <p class="site-area">京都市伏見区の屋根修理・雨漏り修理・屋根リフォーム<br>は山勇ルーフへ</p>
            <a href="index.php" class="site-logo-link">
                <img src="assets/img/logo.png" alt="<?php echo SITE_NAME; ?>" class="sidebar-logo-img">
            </a>
        </div>

        <div class="sidebar-cta-top">
            <a href="contact.php" class="btn-sidebar-mail">
                <span class="icon-mail">✉️</span>
                <span class="text-mail">
                    メールで無料お見積り・お<br>問い合わせ
                </span>
            </a>
        </div>

        <div class="sidebar-phone-section">
            <p class="phone-label">お電話でのお問い合わせ</p>
            <a href="tel:<?php echo str_replace('-', '', COMPANY_PHONE); ?>" class="sidebar-phone-number">
                <?php echo COMPANY_PHONE; ?>
            </a>
            <p class="phone-meta">通話無料 / 受付時間 8:00〜19:00 [土日祝対応]</p>
        </div>

        <nav class="sidebar-nav">
            <ul class="sidebar-menu">
                <li class="nav-item">
                    <a href="about.php" class="nav-link-banner">
                        <span class="nav-ja">お伝えしたいこと</span>
                        <span class="nav-main">山勇ルーフ<span class="small">について</span></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="services.php" class="nav-link-banner">
                        <span class="nav-ja">葺き替え・カバー工法</span>
                        <span class="nav-main"><span class="highlight">屋根修理</span>をしたい</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="services.php#rain-leak" class="nav-link-banner">
                        <span class="nav-ja">迅速確実な対応</span>
                        <span class="nav-main">雨漏り修理<span class="small">をしたい</span></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="services.php" class="nav-link-banner">
                        <span class="nav-ja">屋根のことならなんでもお任せ！</span>
                        <span class="nav-main">施工メニュー</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="works.php" class="nav-link-banner">
                        <span class="nav-ja">確かな技術をぜひご覧ください。</span>
                        <span class="nav-main">施工実績</span>
                    </a>
                </li>
            </ul>
        </nav>

        <div class="sidebar-footer-links">
            <ul class="footer-links-list">
                <li><a href="index.php">▶ トップページ</a></li>
                <li><a href="about.php">▶ 事業者情報</a></li>
                <li><a href="contact.php">▶ よくあるご質問</a></li>
                <li><a href="privacy.php">▶ プライバシーポリシー</a></li>
            </ul>
            <div class="sidebar-social">
                <a href="#" class="social-icon icon-instagram"><img src="assets/svg/instagram.svg" alt="Instagram" onerror="this.src=''; this.innerHTML='📷'"></a>
                <a href="#" class="social-icon icon-youtube"><img src="assets/svg/youtube.svg" alt="YouTube" onerror="this.src=''; this.innerHTML='▶️'"></a>
                <a href="#" class="social-icon icon-line"><img src="assets/svg/line.svg" alt="LINE" onerror="this.src=''; this.innerHTML='💬'"></a>
            </div>
            <div class="sidebar-social-labels">
                <span>Instagram</span>
                <span>Youtube</span>
                <span>LINE</span>
            </div>
        </div>
    </aside>

    <!-- Main Content Wrapper (Starts here, ends in footer.php) -->
    <div class="main-content">
        <!-- Overlay for mobile sidebar -->
        <div id="sidebarOverlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:999;" onclick="document.getElementById('sidebar').classList.remove('active'); this.style.display='none';"></div>

<script>
    document.getElementById('menuToggle').addEventListener('click', function() {
        var sidebar = document.getElementById('sidebar');
        var overlay = document.getElementById('sidebarOverlay');
        sidebar.classList.toggle('active');
        
        if (sidebar.classList.contains('active')) {
            overlay.style.display = 'block';
        } else {
            overlay.style.display = 'none';
        }
    });
</script>
