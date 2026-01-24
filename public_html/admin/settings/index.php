<?php
// public_html/admin/settings/index.php
require_once '../../config/config.php';
require_login();

$page_title = 'サイト設定';
$pdo = get_db_connection();
$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validate_csrf_token($_POST['csrf_token'])) {
        die('不正なリクエストです。');
    }
    
    // Save settings (Explicitly list allowed keys to prevent pollution if any)
    $settings_to_save = [
        'site_name', 'company_name', 'company_owner', 
        'company_address', 'company_phone', 'company_invoice',
        'mail_to', 'mail_from'
    ];

    $stmt = $pdo->prepare("INSERT OR REPLACE INTO site_settings (setting_key, setting_value, updated_at) VALUES (?, ?, CURRENT_TIMESTAMP)");
    
    foreach ($settings_to_save as $key) {
        if (isset($_POST[$key])) {
            $stmt->execute([$key, $_POST[$key]]);
        }
    }
    $msg = "設定を保存しました。";

    // Test Mail
    if (isset($_POST['test_mail'])) {
        require_once dirname(__DIR__, 2) . '/config/mail_function.php';
        $res = send_mail_smtp($_POST['mail_to'], 'SMTP Test Mail', 'これはテストメールです。設定は正しく行われています。');
        if ($res['success']) {
            $msg .= " テストメールを送信しました。";
        } else {
            $msg .= " テスト送信失敗: " . $res['message'];
        }
    }
}

// Fetch current settings
$stmt = $pdo->query("SELECT setting_key, setting_value FROM site_settings");
$current_settings = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

function get_setting($key, $default = '') {
    global $current_settings;
    return $current_settings[$key] ?? $default;
}

include __DIR__ . '/../inc/header.php';
?>

<div style="max-width: 800px; margin: 0 auto;">
    <?php if ($msg): ?>
        <div class="alert alert-success"><?php echo h($msg); ?></div>
    <?php endif; ?>

    <div class="card">
        <form method="post">
            <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
            
            <h3 style="margin-top: 0; border-bottom: 2px solid var(--primary-color); padding-bottom: 10px; margin-bottom: 20px;">基本情報</h3>
            
            <div class="form-group">
                <label class="form-label">サイト名</label>
                <input type="text" name="site_name" class="form-control" value="<?php echo h(get_setting('site_name', SITE_NAME)); ?>">
            </div>
            <div class="form-group">
                <label class="form-label">会社名 (屋号)</label>
                <input type="text" name="company_name" class="form-control" value="<?php echo h(get_setting('company_name', COMPANY_NAME)); ?>">
            </div>
            <div class="form-group">
                <label class="form-label">代表者名</label>
                <input type="text" name="company_owner" class="form-control" value="<?php echo h(get_setting('company_owner', COMPANY_OWNER)); ?>">
            </div>
            <div class="form-group">
                <label class="form-label">住所</label>
                <input type="text" name="company_address" class="form-control" value="<?php echo h(get_setting('company_address', COMPANY_ADDRESS)); ?>">
            </div>
            <div class="form-group">
                <label class="form-label">電話番号</label>
                <input type="text" name="company_phone" class="form-control" value="<?php echo h(get_setting('company_phone', COMPANY_PHONE)); ?>">
            </div>
             <div class="form-group">
                <label class="form-label">インボイス番号 (適格請求書発行事業者登録番号)</label>
                <input type="text" name="company_invoice" class="form-control" value="<?php echo h(get_setting('company_invoice', COMPANY_INVOICE)); ?>">
            </div>

            <h3 style="margin-top: 40px; border-bottom: 2px solid var(--primary-color); padding-bottom: 10px; margin-bottom: 20px;">メール設定</h3>
            <p style="color: #666; margin-bottom: 20px;">お問い合わせフォームに関する設定です。</p>
            
            <div class="form-group">
                <label class="form-label">通知先メールアドレス（受信）</label>
                <input type="text" name="mail_to" class="form-control" value="<?php echo h(get_setting('mail_to', MAIL_TO)); ?>" placeholder="例: main@example.com, sub@example.com">
                <p style="font-size: 0.85rem; color: #666; margin-top: 5px; background: #f8f9fa; padding: 10px; border-radius: 4px;">
                    <strong>💡 複数のアドレスに送りたい場合</strong><br>
                    カンマ(,)で区切って入力してください。<br>
                    例：<code>info@sanyu-roof.jp, manager@sanyu-roof.jp</code>
                </p>
            </div>

            <div class="form-group">
                <label class="form-label">送信元メールアドレス（固定）</label>
                <div style="background: #e9ecef; padding: 10px 15px; border-radius: 4px; border: 1px solid #ced4da; color: #495057; font-family: monospace;">
                    info@sanyu-roof.jp
                </div>
                <p style="font-size: 0.8rem; color: #888; margin-top: 5px;">
                    ※お客様や管理者への自動送信メールは、このアドレスから送信されます。<br>
                    システムの安定性のため、ここから変更することはできません。
                </p>
            </div>

            <div style="margin-top: 30px; border-top: 1px solid #eee; padding-top: 20px; text-align: center;">
                <button type="submit" class="btn btn-primary" style="min-width: 200px;">設定を保存する</button>
            </div>
            
            <div style="margin-top: 30px; text-align: center; background: #f9f9f9; padding: 20px; border-radius: 4px;">
                <p style="margin-bottom: 10px; font-size: 0.9rem;">メールの動作確認</p>
                <button type="submit" name="test_mail" value="1" class="btn btn-warning" onclick="return confirm('現在保存されている設定でテストメールを送信しますか？');">📩 テストメールを送信</button>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../inc/footer.php'; ?>
