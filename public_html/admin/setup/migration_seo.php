<?php
// public_html/admin/setup/migration_seo.php
require_once __DIR__ . '/../../config/config.php';

echo "<h1>SEO & CMS Migration</h1>";

try {
    $pdo = get_db_connection();
    if (!$pdo) {
        throw new Exception("Database connection failed.");
    }

    // 1. Create pages table
    $sql = "CREATE TABLE IF NOT EXISTS pages (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        slug TEXT UNIQUE NOT NULL,
        name TEXT NOT NULL,
        title TEXT,
        description TEXT,
        content TEXT, -- JSON
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )";
    $pdo->exec($sql);
    echo "<p>Table 'pages' created (or already exists).</p>";

    // 2. Insert default 'home' page if not exists
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM pages WHERE slug = 'home'");
    $stmt->execute();
    if ($stmt->fetchColumn() == 0) {
        $default_content = json_encode([
            'hero_title' => "京都・伏見の\n屋根修理・雨漏り工事",
            'hero_subtitle' => "職人直営の「" . SITE_NAME . "」", // Use constant or literal
            'hero_description' => "屋根の点検、修理、葺き替え、雨どい掃除まで。\n地元の職人が、あなたの家の屋根を守ります。",
            'reason_1_title' => "1. 地域密着・迅速対応",
            'reason_1_text' => "京都市伏見区を中心に、地域密着で活動しています。急な雨漏りトラブルにも可能な限り迅速に駆けつけます。",
            'reason_2_title' => "2. 職人直営・適正価格",
            'reason_2_text' => "営業会社を挟まない「職人直営」だから、中間マージンが発生しません。高品質な施工を適正価格でご提供します。",
            'reason_3_title' => "3. 安心の提案力",
            'reason_3_text' => "お客様の予算や要望に合わせて、最適な修理プランをご提案。無理な営業は一切いたしません。",
            'solar_title' => "「太陽光パネルがあるから…」と\n諦めていませんか？",
            'solar_text' => "他社では断られることもある<strong>「太陽光パネル設置屋根」のカバー工法</strong>。\n山勇ルーフなら、パネルの取り外しから、屋根のカバー工事、そして再設置まで、すべて<strong style=\"color: var(--color-secondary); border-bottom: 2px solid var(--color-secondary);\">自社職人のみ</strong>で完結可能です。",
            'solar_text_2' => "外部業者を挟まないため、余計な中間マージンをカット。\n大切なお住まいの発電機能を守りながら、屋根を新しく美しく生まれ変わらせます。",
        ], JSON_UNESCAPED_UNICODE);

        $stmt = $pdo->prepare("INSERT INTO pages (slug, name, title, description, content, updated_at) VALUES (?, ?, ?, ?, ?, CURRENT_TIMESTAMP)");
        $stmt->execute([
            'home',
            'トップページ',
            'トップページ', // Default Title
            '京都・伏見の屋根修理・雨漏り工事は山勇ルーフへ。職人直営の適正価格で、急な雨漏りも迅速に対応します。', // Default Description
            $default_content
        ]);
        echo "<p>Inserted default 'home' page record.</p>";
    } else {
        echo "<p>'home' page record already exists.</p>";
    }

} catch (Exception $e) {
    echo "<div style='color:red'>Error: " . h($e->getMessage()) . "</div>";
}
?>
