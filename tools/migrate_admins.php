<?php
// tools/migrate_admins.php
require_once __DIR__ . '/../public_html/config/config.php';

$pdo = get_db_connection();

echo "Starting migration...\n";

try {
    // Add email column
    try {
        $pdo->exec("ALTER TABLE admins ADD COLUMN email TEXT");
        echo "Added 'email' column.\n";
    } catch (PDOException $e) {
        echo "'email' column might already exist or error: " . $e->getMessage() . "\n";
    }

    // Add last_login_at column
    try {
        $pdo->exec("ALTER TABLE admins ADD COLUMN last_login_at DATETIME");
        echo "Added 'last_login_at' column.\n";
    } catch (PDOException $e) {
        echo "'last_login_at' column might already exist or error: " . $e->getMessage() . "\n";
    }

    // Add reset_token column
    try {
        $pdo->exec("ALTER TABLE admins ADD COLUMN reset_token TEXT");
        echo "Added 'reset_token' column.\n";
    } catch (PDOException $e) {
        echo "'reset_token' column might already exist or error: " . $e->getMessage() . "\n";
    }

    // Add token_expires_at column
    try {
        $pdo->exec("ALTER TABLE admins ADD COLUMN token_expires_at DATETIME");
        echo "Added 'token_expires_at' column.\n";
    } catch (PDOException $e) {
        echo "'token_expires_at' column might already exist or error: " . $e->getMessage() . "\n";
    }

    // Set default email for existing admin (using config value or fallback)
    $stmt = $pdo->prepare("UPDATE admins SET email = ? WHERE id = 1 AND (email IS NULL OR email = '')");
    $stmt->execute([MAIL_TO]); 
    if ($stmt->rowCount() > 0) {
        echo "Updated default admin email to: " . MAIL_TO . "\n";
    }

    echo "Migration completed.\n";

} catch (Exception $e) {
    echo "Migration failed: " . $e->getMessage() . "\n";
}
?>
