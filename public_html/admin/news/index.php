<?php
// public_html/admin/news/index.php
require_once '../../config/config.php';
require_login();

$pdo = get_db_connection();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    if (!validate_csrf_token($_POST['csrf_token'])) {
        die('不正なリクエストです。');
    }
    $stmt = $pdo->prepare("DELETE FROM news WHERE id = ?");
    $stmt->execute([$_POST['delete_id']]);
    header('Location: /admin/news/index.php?msg=deleted');
    exit;
}

$stmt = $pdo->query("SELECT * FROM news ORDER BY news_date DESC, created_at DESC");
$news_list = $stmt->fetchAll();

$page_title = 'お知らせ管理';
include __DIR__ . '/../inc/header.php';
?>

<div style="margin-bottom: 20px; text-align: right;">
    <a href="/admin/news/edit.php" class="btn btn-primary">＋ お知らせ新規作成</a>
</div>

<?php if (isset($_GET['msg']) && $_GET['msg'] === 'deleted'): ?>
    <div class="alert alert-success">削除しました。</div>
<?php endif; ?>

<div class="card" style="padding: 0; overflow: hidden;">
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 120px;">日付</th>
                <th>タイトル</th>
                <th style="width: 150px;">操作</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($news_list as $item): ?>
            <tr>
                <td><?php echo h(date('Y/m/d', strtotime($item['news_date']))); ?></td>
                <td><?php echo h($item['title']); ?></td>
                <td>
                    <a href="/admin/news/edit.php?id=<?php echo h($item['id']); ?>" class="btn btn-secondary" style="padding: 5px 10px; font-size: 0.85rem;">編集</a>
                    <form method="post" action="" style="display:inline;" onsubmit="return confirm('本当に削除しますか？');">
                        <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                        <input type="hidden" name="delete_id" value="<?php echo h($item['id']); ?>">
                        <button type="submit" class="btn btn-danger" style="padding: 5px 10px; font-size: 0.85rem;">削除</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include __DIR__ . '/../inc/footer.php'; ?>
