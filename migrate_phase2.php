<?php
// migrate_phase2.php
require_once 'public_html/config/config.php';

echo "Starting Phase 2 Migration...\n";

$pdo = get_db_connection();

try {
    // 1. Add status and memo columns to inquiries table
    // SQLite doesn't support "IF NOT EXISTS" for ADD COLUMN nicely in one go, 
    // so we wrap in try-catch or check existence. 
    // A simple way in SQLite is just allow it to fail if exists, or check via PRAGMA.
    
    // Check columns first
    $stmt = $pdo->query("PRAGMA table_info(inquiries)");
    $columns = $stmt->fetchAll(PDO::FETCH_COLUMN, 1);
    
    if (!in_array('status', $columns)) {
        $pdo->exec("ALTER TABLE inquiries ADD COLUMN status TEXT DEFAULT '未対応'");
        echo "Added 'status' column to inquiries.\n";
    }
    if (!in_array('memo', $columns)) {
        $pdo->exec("ALTER TABLE inquiries ADD COLUMN memo TEXT DEFAULT ''");
        echo "Added 'memo' column to inquiries.\n";
    }

    // 2. Create site_settings table
    $pdo->exec("CREATE TABLE IF NOT EXISTS site_settings (
        setting_key TEXT PRIMARY KEY,
        setting_value TEXT,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");
    echo "Table 'site_settings' checked/created.\n";
    
    // Seed default settings if empty
    $stmt = $pdo->query("SELECT COUNT(*) FROM site_settings");
    if ($stmt->fetchColumn() == 0) {
        $defaults = [
            'site_name' => SITE_NAME,
            'company_name' => COMPANY_NAME,
            'company_owner' => COMPANY_OWNER,
            'company_address' => COMPANY_ADDRESS,
            'company_phone' => COMPANY_PHONE,
            'company_invoice' => COMPANY_INVOICE,
            'mail_from' => MAIL_FROM,
            'mail_to' => MAIL_TO,
        ];
        $insert = $pdo->prepare("INSERT INTO site_settings (setting_key, setting_value) VALUES (?, ?)");
        foreach ($defaults as $k => $v) {
            $insert->execute([$k, $v]);
        }
        echo "Seeded default site settings.\n";
    }

    // 3. Create news table
    $pdo->exec("CREATE TABLE IF NOT EXISTS news (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        news_date DATE NOT NULL,
        title TEXT NOT NULL,
        content TEXT,
        link_url TEXT,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");
    echo "Table 'news' checked/created.\n";

    echo "Migration Phase 2 Completed Successfully.\n";

} catch (PDOException $e) {
    echo "Migration Error: " . $e->getMessage() . "\n";
}
?>
