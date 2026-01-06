<header class="header">
    <div class="header-inner">
        <div class="site-logo">
            <a href="index.php"><?php echo SITE_NAME; ?></a>
        </div>
        
        <nav>
            <div class="menu-toggle" id="menuToggle">☰</div>
            <ul class="nav-menu" id="navMenu">
                <li class="nav-item"><a href="index.php">ホーム</a></li>
                <li class="nav-item"><a href="services.php">工事内容</a></li>
                <li class="nav-item"><a href="works.php">施工事例</a></li>
                <li class="nav-item"><a href="about.php">会社概要</a></li>
                <li class="nav-item"><a href="contact.php" class="btn btn-secondary" style="padding: 5px 15px; font-size: 0.9rem;">お問い合わせ</a></li>
            </ul>
        </nav>

        <div class="header-cta">
            <div class="tel-icon">📞</div>
            <div class="header-tel">
                <a href="tel:<?php echo str_replace('-', '', COMPANY_PHONE); ?>"><?php echo COMPANY_PHONE; ?></a>
            </div>
        </div>
    </div>
</header>

<script>
    // 簡易的なスマホメニュー
    document.getElementById('menuToggle').addEventListener('click', function() {
        document.getElementById('navMenu').classList.toggle('active');
    });
</script>
