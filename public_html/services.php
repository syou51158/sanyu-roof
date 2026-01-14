<?php
$page_title = "工事内容";
include 'partials/head.php';
include 'partials/header.php';
?>

<main>
    <div class="section-gray" style="padding: 40px 0;">
        <div class="container text-center">
            <h1>工事内容</h1>
            <p>Service</p>
        </div>
    </div>

    <section class="section">
        <div class="container">
            <div class="mb-40">
                <h2 style="color: var(--color-primary); border-bottom: 2px solid var(--color-secondary); padding-bottom: 10px; margin-bottom: 20px;">雨漏り修理</h2>
                <p>天井のシミ、壁紙の剥がれは雨漏りのサインです。原因を徹底的に調査し、最適な修理方法をご提案します。</p>
                <ul style="margin-top: 15px; margin-left: 20px; list-style-type: disc;">
                    <li>天井からの水漏れ修理</li>
                    <li>瓦のズレ・割れ補修</li>
                    <li>コーキング補修</li>
                </ul>
                <div class="mt-20">
                     <img src="assets/img/solar_before.jpg" class="lightbox-target" alt="雨漏り・屋根診断" style="width: 100%; max-width: 400px; border-radius: 4px; height: auto;">
                     <p style="font-size: 0.9rem; color: #666;">※屋根の状態を詳細に調査いたします。</p>
                </div>
            </div>

            <div class="mb-40">
                <h2 style="color: var(--color-primary); border-bottom: 2px solid var(--color-secondary); padding-bottom: 10px; margin-bottom: 20px;">屋根葺き替え・カバー工法</h2>
                <p>古い屋根材を撤去して新しい屋根にする「葺き替え」や、既存の屋根の上に新しい屋根を被せる「カバー工法」など、建物の状況と予算に合わせてご提案します。</p>
                <div class="row mt-20" style="display: flex; gap: 20px; flex-wrap: wrap;">
                    <div style="flex: 1; min-width: 250px;">
                        <h4 style="font-weight: bold; margin-bottom: 10px;">屋根葺き替え工事</h4>
                        <img src="assets/img/replacement_after.jpg" class="lightbox-target" alt="屋根葺き替え後" style="width: 100%; border-radius: 4px; height: 180px; object-fit: cover;">
                        <p style="font-size: 0.9rem; color: #666; margin-top: 5px;">日本瓦から軽量屋根材へ。耐震性が向上します。</p>
                    </div>
                    <div style="flex: 1; min-width: 250px;">
                        <h4 style="font-weight: bold; margin-bottom: 10px;">スーパーガルテクト（カバー工法）</h4>
                        <img src="assets/img/galtecht_after.jpg" class="lightbox-target" alt="スーパーガルテクト施工後" style="width: 100%; border-radius: 4px; height: 180px; object-fit: cover;">
                        <p style="font-size: 0.9rem; color: #666; margin-top: 5px;">既存屋根に新しい屋根を重ね張り。断熱性・遮音性に優れています。</p>
                    </div>
                </div>
            </div>

            <div class="mb-40">
                <h2 style="color: var(--color-primary); border-bottom: 2px solid var(--color-secondary); padding-bottom: 10px; margin-bottom: 20px;">雨樋（あまどい）工事</h2>
                <p>雨樋の詰まりや破損は、外壁の劣化や雨漏りの原因になります。清掃から交換まで承ります。</p>
            </div>

            <div class="mb-40">
                <h2 style="color: var(--color-primary); border-bottom: 2px solid var(--color-secondary); padding-bottom: 10px; margin-bottom: 20px;">板金工事・漆喰工事</h2>
                <p>谷板金のサビによる穴あきや、漆喰（しっくい）の崩れを補修し、屋根の寿命を延ばします。</p>
            </div>
        </div>
    </section>
</main>

<?php include 'partials/footer.php'; ?>
