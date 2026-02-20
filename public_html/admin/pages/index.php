<?php
// public_html/admin/pages/index.php
require_once '../../config/config.php';
require_login();

$page_title = 'ページ管理';
$pdo = get_db_connection();

// Fetch all pages
try {
    $stmt = $pdo->query("SELECT * FROM pages ORDER BY id ASC");
    $pages = $stmt->fetchAll();
} catch (PDOException $e) {
    // If table doesn't exist, treat as empty or show specific error (but don't crash 500)
    $pages = [];
    $error_message = "データベースエラー: " . h($e->getMessage()) . "<br>まだ初期設定が完了していない可能性があります。<a href='/admin/setup/migration_seo.php'>こちらのセットアップ</a>を実行してください。";
}

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'save_gsc') {
    if (!validate_csrf_token($_POST['csrf_token'])) die('Invalid Request');
    $tag = $_POST['google_search_console_tag'] ?? '';
    
    $stmt = $pdo->prepare("INSERT OR REPLACE INTO site_settings (setting_key, setting_value, updated_at) VALUES (?, ?, CURRENT_TIMESTAMP)");
    $stmt->execute(['google_search_console_tag', $tag]);
    $msg = "Google Search Console 認証タグを保存しました。";
}

// Fetch GSC Setting
try {
    $stmt = $pdo->query("SELECT setting_value FROM site_settings WHERE setting_key = 'google_search_console_tag'");
    $gsc_tag = $stmt->fetchColumn() ?: '';
} catch (Exception $e) {
    $gsc_tag = '';
}

include __DIR__ . '/../inc/header.php';
?>

<div class="container" style="max-width: 1000px; margin: 0 auto;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2 style="margin: 0;">ページ・SEO管理</h2>
    </div>

    <?php if (isset($error_message)): ?>
        <div class="alert alert-danger" style="background:#fce8e6; border:1px solid #fadbd8; color:#7d2424; padding:15px; border-radius:4px; margin-bottom:20px;">
            <?php echo $error_message; ?>
        </div>
    <?php endif; ?>

    <?php if ($msg): ?>
        <div class="alert alert-success"><?php echo h($msg); ?></div>
    <?php endif; ?>

    <!-- GSC Section -->
    <div class="card" style="margin-bottom: 40px; border-left: 5px solid #28a745;">
        <h3 style="margin-top:0;">🌐 Google Search Console 認証設定</h3>
        <p style="color: #666; font-size: 0.9rem; margin-bottom: 15px;">Googleにサイトを登録・認識させるためのタグをここに設定します。（業者様用）</p>
        <form method="post">
            <input type="hidden" name="action" value="save_gsc">
            <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
            <div class="form-group" style="margin-bottom: 15px;">
                <label class="form-label">認証用HTMLタグ</label>
                <input type="text" name="google_search_console_tag" class="form-control" value="<?php echo h($gsc_tag); ?>" placeholder='例: <meta name="google-site-verification" content="..." />' style="width: 100%;">
                <p style="font-size:0.85rem; color:#888; margin-top:5px;">※ <code>&lt;meta name="google-site-verification" content="..." /&gt;</code> の形式のタグをそのまま貼り付けてください。</p>
            </div>
            <button type="submit" class="btn btn-primary">タグを保存</button>
        </form>
    </div>

    <h3 style="margin-bottom: 20px; border-bottom: 2px solid var(--primary-color); padding-bottom: 10px;">📄 ページ文章・SEOタグの編集</h3>
    <p style="color: #666; font-size: 0.9rem; margin-bottom: 20px;">各ページの<strong>タイトル(title)</strong>、<strong>ディスクリプション(description)</strong>、および<strong>ページ内のテキスト</strong>を編集できます。</p>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px;">
        <?php if (!empty($pages)): ?>
            <?php foreach ($pages as $p): ?>
            <div class="card" style="padding: 20px; transition: transform 0.2s;">
                <h4 style="margin: 0 0 5px 0; font-size: 1.25rem;"><?php echo h($p['name']); ?></h4>
                <p style="font-size: 0.85rem; color: #666; margin-bottom: 15px;">
                    URL: <a href="/<?php echo h($p['slug'] === 'home' ? '' : $p['slug'] . '.php'); ?>" target="_blank" style="color:#007bff; text-decoration:none;">/<?php echo h($p['slug'] === 'home' ? '' : $p['slug']); ?></a>
                </p>
                <div style="font-size: 0.85rem; color: #444; margin-bottom: 15px; background: #f8f9fa; border: 1px solid #eee; padding: 10px; border-radius: 4px; height: 60px; overflow: hidden;">
                    <strong style="color: #888; font-size: 0.75rem; display:block; margin-bottom:3px;">現在のTitleタグ</strong>
                    <?php echo h(mb_strimwidth($p['title'], 0, 40, '...')) ?: '<span style="color:#999">システムデフォルト</span>'; ?>
                </div>
                <div style="display: flex; gap: 10px;">
                    <a href="edit.php?id=<?php echo h($p['id']); ?>" class="btn btn-primary" style="flex:2; text-align:center;">✏️ 編集画面へ</a>
                    <a href="/<?php echo h($p['slug'] === 'home' ? '' : $p['slug'] . '.php'); ?>" target="_blank" class="btn btn-outline-secondary" style="flex:1; text-align:center; padding: 10px 0;">確認 ↗</a>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="card" style="grid-column: 1 / -1; text-align: center; padding: 40px; color: #666;">
                編集可能なページが見つかりません。
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include __DIR__ . '/../inc/footer.php'; ?>
