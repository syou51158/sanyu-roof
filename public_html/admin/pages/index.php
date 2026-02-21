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
            <div class="card" style="padding: 25px; transition: transform 0.2s; border-top: 4px solid var(--primary-color);">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px;">
                    <h4 style="margin: 0; font-size: 1.3rem; color: #333; display: flex; align-items: center; gap: 8px;">
                        <span style="font-size: 1.1rem;">📄</span> <?php echo h($p['name']); ?>
                    </h4>
                    <?php if($p['slug'] === 'home'): ?>
                        <span style="background: #e6f4ea; color: #1e8e3e; padding: 3px 8px; border-radius: 12px; font-size: 0.75rem; font-weight: bold;">トップ</span>
                    <?php else: ?>
                        <span style="background: #f1f3f4; color: #5f6368; padding: 3px 8px; border-radius: 12px; font-size: 0.75rem;">下層ページ</span>
                    <?php endif; ?>
                </div>
                
                <!-- Google Search Snippet Preview -->
                <div style="background: #fff; border: 1px solid #dfe1e5; border-radius: 8px; padding: 15px; margin-bottom: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                    <div style="font-size: 0.75rem; color: #555; margin-bottom: 5px; font-family: sans-serif;">
                        <span style="background: #f1f3f4; padding: 2px 6px; border-radius: 4px; margin-right: 5px;">検索プレビュー</span>
                    </div>
                    <?php
                        // Construct absolute URL for preview
                        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
                        $host = $_SERVER['HTTP_HOST'];
                        $path = $p['slug'] === 'home' ? '' : $p['slug'] . '.php';
                        $full_url = "{$protocol}://{$host}/{$path}";
                        
                        $display_title = $p['title'] ?: $p['name'] . ' | ' . get_setting('company_name');
                        $display_desc = $p['description'] ?: 'ここにページの説明文（ディスクリプション）が表示されます。検索ユーザーがクリックしたくなるような魅力的な文章を設定しましょう。';
                    ?>
                    <div>
                        <div style="font-size: 0.85rem; color: #202124; margin-bottom: 2px; display: flex; align-items: center; gap: 5px;">
                            <img src="/assets/img/icon.svg" width="16" height="16" style="border-radius:50%; background:#f1f3f4; padding:2px;" onerror="this.style.display='none'">
                            <span style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 250px;"><?php echo h($full_url); ?></span>
                        </div>
                        <div style="color: #1a0dab; font-size: 1.25rem; margin-bottom: 3px; cursor: pointer; text-decoration: none; font-family: arial, sans-serif; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">
                            <?php echo h($display_title); ?>
                        </div>
                        <div style="color: #4d5156; font-size: 0.85rem; line-height: 1.58; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                            <?php echo h($display_desc); ?>
                        </div>
                    </div>
                </div>

                <div style="display: flex; gap: 10px;">
                    <a href="edit.php?id=<?php echo h($p['id']); ?>" class="btn btn-primary" style="flex:2; text-align:center; box-shadow: 0 2px 4px rgba(0,123,255,0.2);">✏️ 編集画面へ</a>
                    <a href="<?php echo htmlspecialchars($full_url); ?>" target="_blank" class="btn btn-outline-secondary" style="flex:1; text-align:center; padding: 10px 0;">実際の画面 ↗</a>
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
