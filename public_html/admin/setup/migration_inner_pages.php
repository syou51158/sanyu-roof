<?php
// public_html/admin/setup/migration_inner_pages.php
require_once __DIR__ . '/../../config/config.php';

echo "<h1>Inner Pages Migration</h1>";

try {
    $pdo = get_db_connection();
    if (!$pdo) {
        throw new Exception("Database connection failed.");
    }

    // List of pages to add
    $pages_to_add = [
        [
            'slug' => 'works',
            'name' => '施工事例一覧',
            'title' => '施工事例',
            'description' => '山勇ルーフの施工事例一覧です。屋根修理、雨漏り修理、葺き替え工事などの実績をご紹介します。',
            'content' => json_encode(['lead_text' => '当社の施工実績の一部をご紹介します。'], JSON_UNESCAPED_UNICODE)
        ],
        [
            'slug' => 'services',
            'name' => '工事内容',
            'title' => '工事内容',
            'description' => '山勇ルーフの工事内容です。雨漏り修理、屋根葺き替え、カバー工法、雨樋工事、板金・漆喰工事など幅広く対応します。',
            'content' => json_encode(['lead_text' => '屋根に関するあらゆるお困りごとに対応いたします。'], JSON_UNESCAPED_UNICODE)
        ],
        [
            'slug' => 'contact',
            'name' => 'お問い合わせ',
            'title' => 'お問い合わせ',
            'description' => '山勇ルーフへのお問い合わせはこちらから。お見積もりは無料です。お気軽にご相談ください。',
            'content' => json_encode(['lead_text' => 'お急ぎの方はお電話にてご連絡ください。'], JSON_UNESCAPED_UNICODE)
        ],
        [
            'slug' => 'about',
            'name' => '事業者情報',
            'title' => '事業者情報',
            'description' => '山勇ルーフの事業者情報です。代表挨拶、会社概要などをご紹介します。',
            'content' => json_encode([
                'lead_text' => '地域密着、職人直営の屋根工事店です。',
                'representative_message_title' => '「熟練職人」の確かな技術で、<br>地元の屋根を守り続けます。',
                'representative_message_text' => "ホームページをご覧いただきありがとうございます。\n山勇ルーフ代表の山本です。\n\n私は京都・伏見を中心に、個人事業として屋根修理や雨漏り修理を行っております。\n大手のリフォーム会社や工務店とは違い、営業担当はおらず、私が直接お客様のご要望をお伺いし、現地調査から施工、アフターフォローまで一貫して担当させていただきます。\n\n「職人直営」だからこそ、お客様の声をダイレクトに工事に反映でき、中間マージンをカットした適正価格でのご提供が可能です。\n見えない部分の下地処理から徹底的にこだわり、長く安心してお住まいいただける屋根工事をお約束いたします。\n\n屋根のことでお困りの際は、ぜひ山勇ルーフにご相談ください。\n地元の職人として、誠心誠意対応させていただきます。"
            ], JSON_UNESCAPED_UNICODE)
        ]
    ];

    $stmt_check = $pdo->prepare("SELECT COUNT(*) FROM pages WHERE slug = ?");
    $stmt_insert = $pdo->prepare("INSERT INTO pages (slug, name, title, description, content, updated_at) VALUES (?, ?, ?, ?, ?, CURRENT_TIMESTAMP)");

    foreach ($pages_to_add as $page) {
        $stmt_check->execute([$page['slug']]);
        if ($stmt_check->fetchColumn() == 0) {
            $stmt_insert->execute([
                $page['slug'],
                $page['name'],
                $page['title'],
                $page['description'],
                $page['content']
            ]);
            echo "<p>Inserted page: {$page['slug']}</p>";
        } else {
            echo "<p>Page already exists: {$page['slug']}</p>";
        }
    }
    
    echo "<p>Migration completed.</p>";

} catch (Exception $e) {
    echo "<div style='color:red'>Error: " . h($e->getMessage()) . "</div>";
}
?>
