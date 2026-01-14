<?php
$page_title = "事業者情報";
include 'partials/head.php';
include 'partials/header.php';
?>

<main>
    <div class="section-gray" style="padding: 60px 0;">
        <div class="container text-center">
            <h1 class="section-title" style="margin-bottom: 0;">事業者情報<span>Business Information</span></h1>
        </div>
    </div>

    <!-- Representative Message -->
    <section class="section">
        <div class="container">
            <h2 class="section-title">代表挨拶<span>Message</span></h2>
            <div class="message-box" style="display: flex; gap: 40px; align-items: flex-start; flex-wrap: wrap;">
                 <div class="message-img" style="flex: 1; min-width: 300px;">
                    <!-- Placeholder for representative image -->
                    <div style="width: 100%; height: 300px; background: #eee; display: flex; align-items: center; justify-content: center; color: #aaa;">
                        代表写真<br>(後ほど差し替えます)
                    </div>
                 </div>
                 <div class="message-content" style="flex: 1.5; min-width: 300px;">
                    <h3 style="font-size: 1.4rem; margin-bottom: 20px; font-weight: bold;">「熟練職人」の確かな技術で、<br>地元の屋根を守り続けます。</h3>
                    <p style="margin-bottom: 15px; line-height: 1.8;">
                        ホームページをご覧いただきありがとうございます。<br>
                        山勇ルーフ代表の山本です。
                    </p>
                    <p style="margin-bottom: 15px; line-height: 1.8;">
                        私は京都・伏見を中心に、個人事業として屋根修理や雨漏り修理を行っております。<br>
                        大手のリフォーム会社や工務店とは違い、営業担当はおらず、私が直接お客様のご要望をお伺いし、現地調査から施工、アフターフォローまで一貫して担当させていただきます。
                    </p>
                    <p style="margin-bottom: 15px; line-height: 1.8;">
                        「職人直営」だからこそ、お客様の声をダイレクトに工事に反映でき、中間マージンをカットした適正価格でのご提供が可能です。<br>
                        見えない部分の下地処理から徹底的にこだわり、長く安心してお住まいいただける屋根工事をお約束いたします。
                    </p>
                    <p style="margin-bottom: 0; line-height: 1.8;">
                        屋根のことでお困りの際は、ぜひ山勇ルーフにご相談ください。<br>
                        地元の職人として、誠心誠意対応させていただきます。
                    </p>
                    <p style="margin-top: 30px; font-weight: bold; text-align: right;">
                        山勇ルーフ 代表<br>
                        <span style="font-size: 1.2rem;"><?php echo COMPANY_OWNER; ?></span>
                    </p>
                 </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="section section-gray">
        <div class="container">
            <h2 class="section-title">山勇ルーフが選ばれる理由<span>Why Choose Us</span></h2>
            <div class="card-grid">
                <div class="card">
                    <div class="card-body text-center">
                        <div style="font-size: 3rem; margin-bottom: 10px;">🔨</div>
                        <h3 class="card-title">完全自社施工</h3>
                        <p style="text-align: left;">ご相談から施工、アフターフォローまで代表自身が一貫して担当。伝達ミスがなく、中間マージンもカットできるため、高品質な施工を適正価格でご提供できます。</p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body text-center">
                        <div style="font-size: 3rem; margin-bottom: 10px;">🤝</div>
                        <h3 class="card-title">地域密着のスピード対応</h3>
                        <p style="text-align: left;">京都市伏見区を中心に活動しているため、急な雨漏りやトラブルにも迅速に駆けつけます。地元の気候や風土を知り尽くした職人にお任せください。</p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body text-center">
                        <div style="font-size: 3rem; margin-bottom: 10px;">🏅</div>
                        <h3 class="card-title">熟練職人の確かな技術</h3>
                        <p style="text-align: left;">豊富な経験と知識に裏打ちされた技術力で、どんな屋根の悩みも解決いたします。細部までこだわり、長く安心できる屋根に仕上げます。</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Business Info -->
    <section class="section">
        <div class="container">
            <h2 class="section-title">事業者情報<span>Outline</span></h2>
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

            <!-- Google Maps Embed -->
            <div class="mt-20" style="height: 400px; background: #eee;">
                 <iframe src="https://maps.google.co.jp/maps?output=embed&q=京都府京都市伏見区羽束師菱川町569-42&t=m&z=15" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>
    </section>
</main>

<?php include 'partials/footer.php'; ?>
