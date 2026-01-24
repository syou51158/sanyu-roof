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
                    熟練職人の<br>
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
</script>

    <!-- News Section -->
    <?php
    $pdo = get_db_connection_early(); // Use early connection if global not yet set or just reuse
    if (!$pdo) $pdo = get_db_connection();
    
    // Fetch latest 3 news
    $stmt = $pdo->query("SELECT * FROM news ORDER BY news_date DESC LIMIT 3");
    $news_list = $stmt->fetchAll();
    ?>
    <?php if (!empty($news_list)): ?>
    <section class="section" style="padding: 40px 0; background: #fff; border-bottom: 1px solid #eee;">
        <div class="container">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h2 style="font-size: 1.5rem; margin: 0;">お知らせ <span style="font-size: 1rem; color: #999; font-weight: normal;">NEWS</span></h2>
            </div>
            <ul class="news-list" style="list-style: none; padding: 0; margin: 0;">
                <?php foreach ($news_list as $news): ?>
                <li style="border-bottom: 1px solid #eee; padding: 10px 0; display: flex; flex-wrap: wrap; align-items: baseline;">
                    <span style="font-size: 0.9rem; color: #666; width: 100px;"><?php echo h(date('Y.m.d', strtotime($news['news_date']))); ?></span>
                    <?php if ($news['link_url']): ?>
                        <a href="<?php echo h($news['link_url']); ?>" style="color: #333; text-decoration: none; flex: 1;">
                            <?php echo h($news['title']); ?>
                        </a>
                    <?php else: ?>
                        <span style="flex: 1;"><?php echo h($news['title']); ?></span>
                    <?php endif; ?>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>
    <?php endif; ?>

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

    <!-- Solar Panel Feature Section (New) -->
    <section class="section"> <!-- White background to contrast with next gray section -->
        <div class="container">
            <h2 class="section-title">
                太陽光パネル脱着 × 屋根カバー工法
                <span>SOLAR PANEL & COVER</span>
            </h2>
            <div class="solar-feature" style="background: #f9f9f9; padding: 40px; border-radius: 8px; border: 1px solid #eee;">
                <div class="row" style="display: flex; flex-wrap: wrap; gap: 40px; align-items: center;">
                    <div class="col-txt" style="flex: 1; min-width: 300px;">
                        <h3 style="font-size: 1.5rem; color: var(--color-primary); margin-bottom: 20px; font-weight: bold;">
                            「太陽光パネルがあるから…」と<br>諦めていませんか？
                        </h3>
                        <p style="margin-bottom: 20px; line-height: 1.8;">
                            他社では断られることもある<strong>「太陽光パネル設置屋根」のカバー工法</strong>。<br>
                            山勇ルーフなら、パネルの取り外しから、屋根のカバー工事、そして再設置まで、すべて<strong style="color: var(--color-secondary); border-bottom: 2px solid var(--color-secondary);">自社職人のみ</strong>で完結可能です。
                        </p>
                        <p style="margin-bottom: 20px; line-height: 1.8;">
                            外部業者を挟まないため、余計な中間マージンをカット。<br>
                            大切なお住まいの発電機能を守りながら、屋根を新しく美しく生まれ変わらせます。
                        </p>
                        <div class="mt-20">
                            <a href="contact.php" class="btn btn-primary">まずは無料相談から</a>
                        </div>
                    </div>
                    <div class="col-img" style="flex: 1; min-width: 300px;">
                        <div style="display: flex; gap: 10px;">
                            <div style="flex: 1;">
                                <img src="assets/img/solar_before.jpg" alt="施工前：太陽光パネル設置屋根" style="width: 100%; border-radius: 4px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                                <p style="text-align: center; font-size: 0.9rem; margin-top: 5px; color: #666;">Before</p>
                            </div>
                            <div style="display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: var(--color-primary);">
                                ▶
                            </div>
                            <div style="flex: 1;">
                                <img src="assets/img/solar_after.jpg" alt="施工後：パネル再設置・カバー工法完了" style="width: 100%; border-radius: 4px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                                <p style="text-align: center; font-size: 0.9rem; margin-top: 5px; color: #666;">After</p>
                            </div>
                        </div>
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
                    <div class="card-img" style="padding: 0; display: flex; flex-direction: column;">
                        <img src="assets/img/galtecht_after.jpg" alt="After: スーパーガルテクト" style="width: 100%; height: 200px; object-fit: cover;">
                        <div style="display: flex; background: #f0f0f0; padding: 5px; align-items: center;">
                            <span style="font-size: 0.7rem; background: #666; color: white; padding: 2px 6px; border-radius: 3px; margin-right: 5px;">Before</span>
                            <img src="assets/img/galtecht_before.jpg" alt="Before" style="height: 40px; width: auto; object-fit: contain;">
                        </div>
                    </div>
                    <div class="card-body">
                        <h3 class="card-title">京都市南区 S様邸</h3>
                        <p>スーパーガルテクトカバー工法<br><span style="font-size: 0.9rem; color: #666;">（カラーベスト→IG工業 スーパーガルテクト）</span></p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-img" style="padding: 0; display: flex; flex-direction: column;">
                        <img src="assets/img/replacement_after.jpg" alt="After: 屋根葺き替え" style="width: 100%; height: 200px; object-fit: cover;">
                        <div style="display: flex; background: #f0f0f0; padding: 5px; align-items: center;">
                            <span style="font-size: 0.7rem; background: #666; color: white; padding: 2px 6px; border-radius: 3px; margin-right: 5px;">Before</span>
                            <img src="assets/img/replacement_before.jpg" alt="Before" style="height: 40px; width: auto; object-fit: contain;">
                        </div>
                    </div>
                    <div class="card-body">
                        <h3 class="card-title">京都市伏見区 N様邸</h3>
                        <p>屋根葺き替え工事<br><span style="font-size: 0.9rem; color: #666;">（日本瓦→軽量屋根材）</span></p>
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
