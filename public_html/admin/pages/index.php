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

include __DIR__ . '/../inc/header.php';
?>

<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2 style="margin: 0;">ページ編集</h2>
    </div>

    <div class="card">
        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger" style="background:#fce8e6; border:1px solid #fadbd8; color:#7d2424; padding:15px; border-radius:4px; margin-bottom:20px;">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <table class="table">
            <thead>
                <tr>
                    <th>ページ名</th>
                    <th>スラッグ (ID)</th>
                    <th>タイトル (Title)</th>
                    <th>最終更新</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($pages)): ?>
                    <?php foreach ($pages as $p): ?>
                    <tr>
                        <td style="font-weight: bold;"><?php echo h($p['name']); ?></td>
                        <td><code><?php echo h($p['slug']); ?></code></td>
                        <td><?php echo h(mb_strimwidth($p['title'], 0, 40, '...')); ?></td>
                        <td style="font-size: 0.9rem; color: #666;"><?php echo h($p['updated_at']); ?></td>
                        <td>
                            <a href="edit.php?id=<?php echo h($p['id']); ?>" class="btn btn-sm btn-primary">編集</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 20px; color: #666;">
                            編集可能なページが見つかりません。
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        
        <div style="margin-top: 20px; font-size: 0.9rem; color: #666; background: #f9f9f9; padding: 15px; border-radius: 4px;">
            <p>※ ここに表示されていないページは、現在システムで管理されていません。</p>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../inc/footer.php'; ?>
