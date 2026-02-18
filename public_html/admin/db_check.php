<?php
// public_html/admin/db_check.php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once '../config/config.php';

// Handle Setup
if (isset($_POST['run_setup'])) {
    try {
        $sql = "CREATE TABLE IF NOT EXISTS pages (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            slug TEXT UNIQUE NOT NULL,
            name TEXT NOT NULL,
            title TEXT,
            description TEXT,
            content TEXT,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )";
        $pdo = get_db_connection();
        $pdo->exec($sql);
        $msg = "Table created.";
        
        // Insert Default
        $default_content = json_encode([
            'hero_title' => "京都・伏見の\n屋根修理・雨漏り工事",
            'hero_subtitle' => "職人直営の「" . SITE_NAME . "」",
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

        $stmt = $pdo->prepare("INSERT OR IGNORE INTO pages (slug, name, title, description, content, updated_at) VALUES (?, ?, ?, ?, ?, CURRENT_TIMESTAMP)");
        $stmt->execute([
            'home',
            'トップページ',
            'トップページ', 
            '京都・伏見の屋根修理・雨漏り工事は山勇ルーフへ。', 
            $default_content
        ]);
        $msg .= " Default data inserted.";
        
    } catch (Exception $e) {
        $error = "Setup Failed: " . h($e->getMessage());
    }
}

echo "<!DOCTYPE html><html><head><meta charset='utf-8'><title>DB Check</title></head><body>";
echo "<h1>Database Diagnostic Tool</h1>";

if (isset($msg)) echo "<p style='color:green; font-weight:bold;'>$msg</p>";
if (isset($error)) echo "<p style='color:red; font-weight:bold;'>$error</p>";

try {
    $pdo = get_db_connection();
    if (!$pdo) throw new Exception("DB Connection Failed");
    echo "<p style='color:green'>Database Connection: OK</p>";
    
    // Check pages table
    $stmt = $pdo->query("SELECT name FROM sqlite_master WHERE type='table' AND name='pages'");
    if ($stmt->fetch()) {
        echo "<p style='color:green'>Table 'pages': EXISTS</p>";
        
        // Count rows
        $count = $pdo->query("SELECT COUNT(*) FROM pages")->fetchColumn();
        echo "<p>Row count in 'pages': $count</p>";
        
        // Show schema
        echo "<h3>Schema for 'pages'</h3>";
        $schema = $pdo->query("PRAGMA table_info(pages)")->fetchAll(PDO::FETCH_ASSOC);
        echo "<table border='1'><tr><th>cid</th><th>name</th><th>type</th></tr>";
        foreach ($schema as $col) {
            echo "<tr><td>{$col['cid']}</td><td>{$col['name']}</td><td>{$col['type']}</td></tr>";
        }
        echo "</table>";
        
    } else {
        echo "<p style='color:red; font-weight:bold;'>Table 'pages': MISSING</p>";
        echo "<p>The table required for SEO features is missing. Please run the setup.</p>";
        echo "<form method='post'><button type='submit' name='run_setup' style='padding:10px; font-size:1.2em;'>Create Table Now</button></form>";
    }

} catch (Exception $e) {
    echo "<p style='color:red'>Error: " . h($e->getMessage()) . "</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}

echo "</body></html>";
?>
