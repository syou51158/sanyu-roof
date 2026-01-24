<?php
// init_db.php

$dbDir = __DIR__ . '/db';
$dbFile = $dbDir . '/sanyu_roof.sqlite';

try {
    // Create (connect to) SQLite database
    $pdo = new PDO("sqlite:" . $dbFile);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Connected to database: " . $dbFile . "\n";

    // 1. Create 'admins' table
    $pdo->exec("CREATE TABLE IF NOT EXISTS admins (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        username TEXT NOT NULL UNIQUE,
        password TEXT NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");
    echo "Table 'admins' checked/created.\n";

    // 2. Create 'works' table
    $pdo->exec("CREATE TABLE IF NOT EXISTS works (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        title TEXT NOT NULL,
        content TEXT,
        category TEXT,
        image_path TEXT,
        before_image_path TEXT,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");
    echo "Table 'works' checked/created.\n";

    // 3. Create 'inquiries' table
    $pdo->exec("CREATE TABLE IF NOT EXISTS inquiries (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT,
        email TEXT,
        tel TEXT,
        address TEXT,
        contact_method TEXT,
        message TEXT,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");
    echo "Table 'inquiries' checked/created.\n";

    // Seed default admin
    // User: admin, Pass: password123
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM admins WHERE username = 'admin'");
    $stmt->execute();
    if ($stmt->fetchColumn() == 0) {
        $password = password_hash('password123', PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO admins (username, password) VALUES ('admin', ?)");
        $stmt->execute([$password]);
        echo "Default admin user created (admin / password123).\n";
    } else {
        echo "Admin user already exists.\n";
    }

    // Seed works data (from works.php)
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM works");
    $stmt->execute();
    if ($stmt->fetchColumn() == 0) {
        $worksData = [
            [
                'title' => '京都市伏見区 K様邸',
                'category' => '雨漏り修理・瓦一部差し替え',
                'content' => '台風の影響で瓦がズレ、雨漏りが発生していました。下地を補修し、割れた瓦を差し替えることで雨漏りが止まりました。',
                'image_path' => '', // Placeholder logic in original code
                'before_image_path' => ''
            ],
            [
                'title' => '京都市南区 S様邸',
                'category' => 'スーパーガルテクト（カバー工法）',
                'content' => '経年劣化したカラーベストから、耐久性・断熱性に優れた「スーパーガルテクト」へカバー工法で施工。見違えるほど美しくなりました。',
                'image_path' => 'assets/img/galtecht_after.jpg',
                'before_image_path' => 'assets/img/galtecht_before.jpg'
            ],
            [
                'title' => '京都市伏見区 N様邸',
                'category' => '屋根葺き替え工事',
                'content' => '重い日本瓦から、軽量でメンテナンスフリーな最新の屋根材へ葺き替え。耐震対策としても非常に有効なリフォームです。',
                'image_path' => 'assets/img/replacement_after.jpg',
                'before_image_path' => 'assets/img/replacement_before.jpg'
            ]
        ];

        $stmt = $pdo->prepare("INSERT INTO works (title, category, content, image_path, before_image_path) VALUES (:title, :category, :content, :image_path, :before_image_path)");
        
        foreach ($worksData as $work) {
            $stmt->execute($work);
        }
        echo "Seeded " . count($worksData) . " works entries.\n";
    } else {
        echo "Works data already exists.\n";
    }

} catch (PDOException $e) {
    die("DB Error: " . $e->getMessage() . "\n");
}
?>
