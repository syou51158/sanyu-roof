<footer class="footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-info">
                <h2><?php echo SITE_NAME; ?></h2>
                <p><?php echo COMPANY_ADDRESS; ?></p>
                <p>電話：<a href="tel:<?php echo str_replace('-', '', COMPANY_PHONE); ?>"><?php echo COMPANY_PHONE; ?></a></p>
                <p style="margin-top: 10px; font-size: 0.8rem; opacity: 0.8;">適格請求書登録番号：<?php echo COMPANY_INVOICE; ?></p>
            </div>
            
            <div class="footer-nav">
                <ul>
                    <li><a href="index.php">ホーム</a></li>
                    <li><a href="services.php">工事内容</a></li>
                    <li><a href="works.php">施工事例</a></li>
                    <li><a href="about.php">会社概要</a></li>
                    <li><a href="contact.php">お問い合わせ</a></li>
                </ul>
            </div>
        </div>
        
        <div class="copyright">
            &copy; <?php echo date('Y'); ?> <?php echo COMPANY_NAME; ?> All Rights Reserved.
        </div>
    </div>
</footer>

<!-- モバイル用固定CTA -->
<div class="fixed-cta">
    <a href="tel:<?php echo str_replace('-', '', COMPANY_PHONE); ?>">
        📞 電話で相談する（見積無料）
    </a>
</div>

</body>
</html>
