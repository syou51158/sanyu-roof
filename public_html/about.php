<?php
$page_title = "会社概要";
include 'partials/head.php';
include 'partials/header.php';
?>

<main>
    <div class="section-gray" style="padding: 40px 0;">
        <div class="container text-center">
            <h1>会社概要</h1>
            <p>About Us</p>
        </div>
    </div>

    <section class="section">
        <div class="container">
            <h2 class="section-title">事業者情報</h2>
            <table class="company-table">
                <tr>
                    <th>屋号</th>
                    <td><?php echo COMPANY_NAME; ?></td>
                </tr>
                <tr>
                    <th>代表者</th>
                    <td><?php echo COMPANY_OWNER; ?></td>
                </tr>
                <tr>
                    <th>住所</th>
                    <td>
                        〒612-8487<br>
                        <?php echo COMPANY_ADDRESS; ?>
                    </td>
                </tr>
                <tr>
                    <th>電話番号</th>
                    <td><?php echo COMPANY_PHONE; ?></td>
                </tr>
                <tr>
                    <th>事業内容</th>
                    <td>
                        屋根工事全般、雨漏り修理、葺き替え工事、<br>
                        カバー工法、雨樋工事、板金工事、漆喰工事
                    </td>
                </tr>
                <tr>
                    <th>適格請求書登録番号</th>
                    <td><?php echo COMPANY_INVOICE; ?></td>
                </tr>
                <tr>
                    <th>対応エリア</th>
                    <td>京都市伏見区、南区、向日市、長岡京市、宇治市など京都南部中心<br>※その他エリアもご相談ください</td>
                </tr>
            </table>

            <!-- Google Maps Embed (羽束師菱川町511-1) -->
            <div class="mt-20" style="height: 400px; background: #eee;">
                 <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3270.505362945234!2d135.7311145763138!3d34.92719617283995!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6001058c4c3b6d4b%3A0x123456789abcdef!2z44CSNjEyLTg0ODcg5Lqs6YO95bqc5Lqs6YO95biC5LyP6KaL5Yy657695p2f5bir6Iqx5bed55S6!5e0!3m2!1sja!2sjp!4v1700000000000!5m2!1sja!2sjp" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                 <p style="font-size:0.8rem; color:#666; text-align:right;">※地図はイメージです（実際の座標に合わせて調整してください）</p>
            </div>
        </div>
    </section>
</main>

<?php include 'partials/footer.php'; ?>
