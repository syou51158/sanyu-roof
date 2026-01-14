<?php
$page_title = "施工事例";
include 'partials/head.php';
include 'partials/header.php';
?>

<main>
    <div class="section-gray" style="padding: 40px 0;">
        <div class="container text-center">
            <h1>施工事例</h1>
            <p>Works</p>
        </div>
    </div>

    <section class="section">
        <div class="container">
            <p class="text-center mb-40">当社の施工実績の一部をご紹介します。</p>
            
                <!-- 事例1 -->
                <div class="card">
                    <div class="card-img" style="height: 250px; position: relative;">
                        <!-- Using existing logic if image existed, or placeholder -->
                        <div style="width: 100%; height: 100%; background: #eee; display: flex; align-items: center; justify-content: center; color: #999;">
                            施工写真<br>（K様邸）
                        </div>
                    </div>
                    <div class="card-body">
                        <h3 class="card-title">京都市伏見区 K様邸</h3>
                        <p class="mb-20"><strong>工事内容：</strong>雨漏り修理・瓦一部差し替え</p>
                        <p>台風の影響で瓦がズレ、雨漏りが発生していました。下地を補修し、割れた瓦を差し替えることで雨漏りが止まりました。</p>
                    </div>
                </div>

                <!-- 事例2 -->
                <div class="card">
                    <div class="card-img" style="height: 250px; padding: 0; display: flex; flex-direction: column;">
                         <img src="assets/img/galtecht_after.jpg" class="lightbox-target" alt="After: スーパーガルテクト" style="width: 100%; height: 200px; object-fit: cover;">
                         <div style="display: flex; background: #f0f0f0; padding: 5px; align-items: center; height: 50px;">
                            <span style="font-size: 0.7rem; background: #666; color: white; padding: 2px 6px; border-radius: 3px; margin-right: 5px;">Before</span>
                            <img src="assets/img/galtecht_before.jpg" class="lightbox-target" alt="Before" style="height: 100%; width: auto; object-fit: contain;">
                         </div>
                    </div>
                    <div class="card-body">
                        <h3 class="card-title">京都市南区 S様邸</h3>
                        <p class="mb-20"><strong>工事内容：</strong>スーパーガルテクト（カバー工法）</p>
                        <p>経年劣化したカラーベストから、耐久性・断熱性に優れた「スーパーガルテクト」へカバー工法で施工。見違えるほど美しくなりました。</p>
                    </div>
                </div>

                <!-- 事例3 -->
                <div class="card">
                    <div class="card-img" style="height: 250px; padding: 0; display: flex; flex-direction: column;">
                         <img src="assets/img/replacement_after.jpg" class="lightbox-target" alt="After: 屋根葺き替え" style="width: 100%; height: 200px; object-fit: cover;">
                         <div style="display: flex; background: #f0f0f0; padding: 5px; align-items: center; height: 50px;">
                            <span style="font-size: 0.7rem; background: #666; color: white; padding: 2px 6px; border-radius: 3px; margin-right: 5px;">Before</span>
                            <img src="assets/img/replacement_before.jpg" class="lightbox-target" alt="Before" style="height: 100%; width: auto; object-fit: contain;">
                         </div>
                    </div>
                    <div class="card-body">
                        <h3 class="card-title">京都市伏見区 N様邸</h3>
                        <p class="mb-20"><strong>工事内容：</strong>屋根葺き替え工事</p>
                        <p>重い日本瓦から、軽量でメンテナンスフリーな最新の屋根材へ葺き替え。耐震対策としても非常に有効なリフォームです。</p>
                    </div>
                </div>
            </div>

            <!-- New Section: Detail Report -->
            <div class="mt-40" style="margin-top: 80px;">
                <h2 class="section-title">
                    【Pick Up】板金雨漏り修理 工事レポート
                    <span>CONSTRUCTION REPORT</span>
                </h2>
                <div style="background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                    <p class="mb-20">
                        複雑な形状の屋根部分から雨漏りが発生していた事例です。<br>
                        谷板金の腐食と取り合い部分の劣化が原因でした。詳細な現場状況と、丁寧な補修の様子をご覧ください。
                    </p>
                    <div class="gallery-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 15px;">
                        <?php for($i=1; $i<=10; $i++): 
                            $num = sprintf('%02d', $i);
                        ?>
                        <div class="gallery-item" style="overflow: hidden; border-radius: 4px; border: 1px solid #eee;">
                            <img src="assets/img/works/sheet_metal/<?php echo $num; ?>.jpg" 
                                 class="lightbox-target" 
                                 alt="板金雨漏り修理 工事写真<?php echo $i; ?>" 
                                 style="width: 100%; height: 150px; object-fit: cover; transition: transform 0.3s;">
                        </div>
                        <?php endfor; ?>
                    </div>
                    <p style="margin-top: 15px; font-size: 0.9rem; color: #666; text-align: right;">※画像をクリックすると拡大します</p>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include 'partials/footer.php'; ?>
