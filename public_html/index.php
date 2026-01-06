<?php
$page_title = "トップページ";
$page_description = "京都・伏見の屋根修理・雨漏り工事は山勇ルーフへ。職人直営の適正価格で、急な雨漏りも迅速に対応します。";
include 'partials/head.php';
include 'partials/header.php';
?>

<main>
    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1>京都・伏見の屋根修理・雨漏り工事<br>職人直営の「<?php echo SITE_NAME; ?>」</h1>
            <p>急な雨漏り、屋根の点検、葺き替えまで。<br>地域の皆様の安心な暮らしを守ります。</p>
            <a href="contact.php" class="btn btn-secondary">無料お見積もり・ご相談</a>
            <div class="mt-20">
                <a href="tel:<?php echo str_replace('-', '', COMPANY_PHONE); ?>" style="color: #fff; font-weight: bold; font-size: 1.5rem;">
                    📞 <?php echo COMPANY_PHONE; ?>
                </a>
            </div>
        </div>
    </section>

    <!-- 3つの安心ポイント -->
    <section class="section">
        <div class="container">
            <h2 class="section-title">選ばれる3つの理由</h2>
            <div class="card-grid">
                <div class="card text-center card-body">
                    <h3 class="card-title">1. 地域密着・迅速対応</h3>
                    <p>京都市伏見区を中心に、地域密着で活動しています。急な雨漏りトラブルにも可能な限り迅速に駆けつけます。</p>
                </div>
                <div class="card text-center card-body">
                    <h3 class="card-title">2. 職人直営・適正価格</h3>
                    <p>営業会社を挟まない「職人直営」だから、中間マージンが発生しません。高品質な施工を適正価格でご提供します。</p>
                </div>
                <div class="card text-center card-body">
                    <h3 class="card-title">3. 安心の提案力</h3>
                    <p>お客様の予算や要望に合わせて、最適な修理プランをご提案。無理な営業は一切いたしません。</p>
                </div>
            </div>
        </div>
    </section>

    <!-- サービス一覧 -->
    <section class="section section-gray">
        <div class="container">
            <h2 class="section-title">工事内容</h2>
            <div class="card-grid">
                <div class="card">
                    <div class="card-img">📷 雨漏り修理</div>
                    <div class="card-body">
                        <h3 class="card-title">雨漏り修理</h3>
                        <p>原因を特定し、部分補修から全面改修まで最適な処置を行います。</p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-img">🏠 葺き替え</div>
                    <div class="card-body">
                        <h3 class="card-title">屋根葺き替え</h3>
                        <p>古くなった屋根を新しい屋根材に交換。耐震性・断熱性が向上します。</p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-img">🔧 漆喰・板金</div>
                    <div class="card-body">
                        <h3 class="card-title">漆喰・板金工事</h3>
                        <p>瓦のズレ防止や、谷板金の交換など、細かなメンテナンスも対応。</p>
                    </div>
                </div>
            </div>
            <div class="text-center mt-20">
                <a href="services.php" class="btn btn-outline">工事内容を詳しく見る</a>
            </div>
        </div>
    </section>

    <!-- 施工事例 -->
    <section class="section">
        <div class="container">
            <h2 class="section-title">施工事例</h2>
            <div class="card-grid">
                <div class="card">
                    <div class="card-img">Before/After</div>
                    <div class="card-body">
                        <h3 class="card-title">京都市伏見区 K様邸</h3>
                        <p>雨漏り修理・瓦一部差し替え</p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-img">Before/After</div>
                    <div class="card-body">
                        <h3 class="card-title">京都市南区 S様邸</h3>
                        <p>屋根葺き替え工事（カラーベスト→ガルバリウム）</p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-img">Before/After</div>
                    <div class="card-body">
                        <h3 class="card-title">向日市 M様邸</h3>
                        <p>樋（とい）交換・清掃</p>
                    </div>
                </div>
            </div>
            <div class="text-center mt-20">
                <a href="works.php" class="btn btn-outline">施工事例をもっと見る</a>
            </div>
        </div>
    </section>

    <!-- CTA Area -->
    <section class="section" style="background: var(--color-primary); color: white; text-align: center;">
        <div class="container">
            <h2>屋根のお困りごと、お気軽にご相談ください</h2>
            <p class="mt-20">お見積もりは無料です。しつこい営業はいたしません。</p>
            <div class="mt-20">
                <a href="tel:<?php echo str_replace('-', '', COMPANY_PHONE); ?>" class="btn" style="background: #fff; color: var(--color-primary);">
                    📞 <?php echo COMPANY_PHONE; ?>
                </a>
            </div>
            <div class="mt-20">
                <a href="contact.php" class="btn btn-secondary">WEBからのお問い合わせはこちら</a>
            </div>
        </div>
    </section>
</main>

<?php include 'partials/footer.php'; ?>
