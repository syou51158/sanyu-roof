<?php
// public_html/admin/works/index.php
require_once '../../config/config.php';
require_login();

$pdo = get_db_connection();

// 削除処理
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    if (!validate_csrf_token($_POST['csrf_token'])) {
        die('不正なリクエストです。');
    }
    $stmt = $pdo->prepare("DELETE FROM works WHERE id = ?");
    $stmt->execute([$_POST['delete_id']]);
    header('Location: /admin/works/index.php?msg=deleted');
    exit;
}

// 一覧取得
$stmt = $pdo->query("SELECT * FROM works ORDER BY created_at DESC");
$works = $stmt->fetchAll();

$page_title = '施工事例管理';
include __DIR__ . '/../inc/header.php';
?>

<div style="margin-bottom: 20px; text-align: right;">
    <a href="/admin/works/edit.php" class="btn btn-primary">＋ 新規登録</a>
</div>

<?php if (isset($_GET['msg']) && $_GET['msg'] === 'deleted'): ?>
    <div class="alert alert-success">削除しました。</div>
<?php endif; ?>

<div class="card" style="padding: 0; overflow: hidden;">
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 60px;">ID</th>
                <th style="width: 100px;">画像</th>
                <th>タイトル</th>
                <th>カテゴリ</th>
                <th style="width: 120px;">更新日</th>
                <th style="width: 150px;">操作</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($works as $work): ?>
            <tr>
                <td><?php echo h($work['id']); ?></td>
                <td>
                    <?php if($work['image_path']): ?>
                        <img src="/<?php echo h($work['image_path']); ?>" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                    <?php else: ?>
                        <span style="color:#ccc;">No Img</span>
                    <?php endif; ?>
                </td>
                <td><?php echo h($work['title']); ?></td>
                <td><span style="background:#eee; padding:2px 6px; border-radius:3px; font-size:0.85rem;"><?php echo h($work['category']); ?></span></td>
                <td><?php echo h(date('Y/m/d', strtotime($work['created_at']))); ?></td>
                <td>
                    <a href="/admin/works/edit.php?id=<?php echo h($work['id']); ?>" class="btn btn-secondary" style="padding: 5px 10px; font-size: 0.85rem;">編集</a>
                    <form method="post" action="" style="display:inline;" onsubmit="return confirm('本当に削除しますか？');">
                        <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                        <input type="hidden" name="delete_id" value="<?php echo h($work['id']); ?>">
                        <button type="submit" class="btn btn-danger" style="padding: 5px 10px; font-size: 0.85rem;">削除</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include __DIR__ . '/../inc/footer.php'; ?>
