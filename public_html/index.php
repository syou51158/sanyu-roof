<?php
$page_title = "トップページ";
$page_description = "京都・伏見の屋根修理・雨漏り工事は山勇ルーフへ。職人直営の適正価格で、急な雨漏りも迅速に対応します。";
include 'partials/head.php';
include 'partials/header.php';
?>

<main>
    <!-- Hero Section -->
    <section class="hero-slider">
    <div class="hero-overlay"></div> <!-- Global overlay -->
    
    <!-- Slides Wrapper -->
    <div class="slides-container">
        
        <!-- Slide 1: Team (Original) -->
        <div class="slide active">
            <div class="slide-bg" style="background-image: url('assets/img/hero_slide_team_1767830650378.png');"></div>
            <div class="hero-content">
                <h1 class="hero-title">
                    京都・伏見の<br>
                    屋根修理・雨漏り工事
                </h1>
                <br>
                <div class="hero-subtitle">職人直営の「<?php echo SITE_NAME; ?>」</div>
                <p class="hero-description">
                    屋根の点検、修理、葺き替え、雨どい掃除まで。<br>
                    地元の職人が、あなたの家の屋根を守ります。
                </p>
                <a href="contact.php" class="btn btn-primary mt-20">無料現地調査・お見積もり</a>
            </div>
        </div>

        <!-- Slide 2: Work (Technical) -->
        <div class="slide">
            <div class="slide-bg" style="background-image: url('assets/img/hero_slide_work_1767830665270.png');"></div>
            <div class="hero-content">
                <h1 class="hero-title">
                    一級技能士の<br>
                    確かな技術
                </h1>
                <br>
                <div class="hero-subtitle">細部までこだわる「施工品質」</div>
                <p class="hero-description">
                    見えない下地から徹底的に。<br>
                    長持ちする屋根工事をお約束します。
                </p>
                <a href="contact.php" class="btn btn-primary mt-20">まずは無料相談から</a>
            </div>
        </div>

        <!-- Slide 3: House (Result) -->
        <div class="slide">
            <div class="slide-bg" style="background-image: url('assets/img/hero_slide_house_1767830680630.png');"></div>
            <div class="hero-content">
                <h1 class="hero-title">
                    強く美しい屋根で<br>
                    安心の暮らし
                </h1>
                <br>
                <div class="hero-subtitle">万全のアフターフォロー</div>
                <p class="hero-description">
                    工事後も安心。<br>
                    定期的なメンテナンスもお任せください。
                </p>
                <a href="contact.php" class="btn btn-primary mt-20">お住まいの診断はこちら</a>
            </div>
        </div>

    </div>
</section>

<!-- Simple Fade Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const slides = document.querySelectorAll('.slide');
    let currentSlide = 0;
    const slideInterval = 5000; // 5 seconds

    function nextSlide() {
        slides[currentSlide].classList.remove('active');
        currentSlide = (currentSlide + 1) % slides.length;
        slides[currentSlide].classList.add('active');
    }

    setInterval(nextSlide, slideInterval);
});
</script>

    <!-- 3つの安心ポイント -->
    <section class="section">
        <div class="container">
            <h2 class="section-title">
                選ばれる3つの理由
                <span>REASONS</span>
            </h2>
            <div class="card-grid">
                <div class="card text-center" style="border: none; box-shadow: none;">
                    <div style="font-size: 3rem; margin-bottom: 20px;">⏱️</div>
                    <div class="card-body" style="padding: 0;">
                        <h3 class="card-title">1. 地域密着・迅速対応</h3>
                        <p>京都市伏見区を中心に、地域密着で活動しています。急な雨漏りトラブルにも可能な限り迅速に駆けつけます。</p>
                    </div>
                </div>
                <div class="card text-center" style="border: none; box-shadow: none;">
                    <div style="font-size: 3rem; margin-bottom: 20px;">💰</div>
                    <div class="card-body" style="padding: 0;">
                        <h3 class="card-title">2. 職人直営・適正価格</h3>
                        <p>営業会社を挟まない「職人直営」だから、中間マージンが発生しません。高品質な施工を適正価格でご提供します。</p>
                    </div>
                </div>
                <div class="card text-center" style="border: none; box-shadow: none;">
                    <div style="font-size: 3rem; margin-bottom: 20px;">🤝</div>
                    <div class="card-body" style="padding: 0;">
                        <h3 class="card-title">3. 安心の提案力</h3>
                        <p>お客様の予算や要望に合わせて、最適な修理プランをご提案。無理な営業は一切いたしません。</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- サービス一覧 -->
    <section class="section section-gray">
        <div class="container">
            <h2 class="section-title">
                工事内容
                <span>SERVICE</span>
            </h2>
            <div class="card-grid">
                <div class="card">
                    <div class="card-img">📷 雨漏り修理</div>
                    <div class="card-body">
                        <h3 class="card-title">雨漏り修理</h3>
                        <p>原因を特定し、部分補修から全面改修まで最適な処置を行います。</p>
                        <div class="mt-20">
                           <a href="services.php" style="color: var(--color-primary); font-weight: bold;">詳しく見る &rarr;</a>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-img">🏠 葺き替え</div>
                    <div class="card-body">
                        <h3 class="card-title">屋根葺き替え</h3>
                        <p>古くなった屋根を新しい屋根材に交換。耐震性・断熱性が向上します。</p>
                        <div class="mt-20">
                           <a href="services.php" style="color: var(--color-primary); font-weight: bold;">詳しく見る &rarr;</a>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-img">🔧 漆喰・板金</div>
                    <div class="card-body">
                        <h3 class="card-title">漆喰・板金工事</h3>
                        <p>瓦のズレ防止や、谷板金の交換など、細かなメンテナンスも対応。</p>
                        <div class="mt-20">
                           <a href="services.php" style="color: var(--color-primary); font-weight: bold;">詳しく見る &rarr;</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-20" style="margin-top: 50px;">
                <a href="services.php" class="btn btn-outline">工事内容一覧を見る</a>
            </div>
        </div>
    </section>

    <!-- 施工事例 -->
    <section class="section">
        <div class="container">
            <h2 class="section-title">
                施工事例
                <span>WORKS</span>
            </h2>
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
            <div class="text-center mt-20" style="margin-top: 50px;">
                <a href="works.php" class="btn btn-outline">施工事例をもっと見る</a>
            </div>
        </div>
    </section>

    <!-- CTA Area -->
    <section class="section" style="background: var(--color-primary); color: white; text-align: center;">
        <div class="container">
            <h2 class="text-serif" style="color: white; font-size: 2rem; margin-bottom: 20px;">屋根のお困りごと、お気軽にご相談ください</h2>
            <p class="mt-20">お見積もりは無料です。しつこい営業はいたしません。</p>
            
            <div style="margin-top: 40px; display: flex; justify-content: center; gap: 20px; flex-wrap: wrap;">
                <a href="tel:<?php echo str_replace('-', '', COMPANY_PHONE); ?>" class="btn" style="background: #fff; color: var(--color-primary); min-width: 250px;">
                    📞 <?php echo COMPANY_PHONE; ?>
                </a>
                <a href="contact.php" class="btn" style="background: var(--color-secondary); color: #fff; min-width: 250px;">
                    ✉️ WEBからのお問い合わせ
                </a>
            </div>
        </div>
    </section>
</main>

<?php include 'partials/footer.php'; ?>
