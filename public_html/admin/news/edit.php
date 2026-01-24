<?php
// public_html/admin/news/edit.php
require_once '../../config/config.php';
require_login();

$pdo = get_db_connection();
$id = $_GET['id'] ?? null;
$news = ['news_date' => date('Y-m-d'), 'title' => '', 'content' => '', 'link_url' => ''];
$page_title = 'お知らせの新規作成';

if ($id) {
    $stmt = $pdo->prepare("SELECT * FROM news WHERE id = ?");
    $stmt->execute([$id]);
    $news = $stmt->fetch();
    if (!$news) die('データが見つかりません');
    $page_title = 'お知らせの編集';
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validate_csrf_token($_POST['csrf_token'])) {
        die('不正なリクエストです。');
    }

    $news_date = $_POST['news_date'] ?? date('Y-m-d');
    $title = $_POST['title'] ?? '';
    $link_url = $_POST['link_url'] ?? '';
    $content = $_POST['content'] ?? ''; 

    if (!$title) $errors[] = 'タイトルは必須です。';

    if (empty($errors)) {
        if ($id) {
            $stmt = $pdo->prepare("UPDATE news SET news_date=?, title=?, content=?, link_url=? WHERE id=?");
            $stmt->execute([$news_date, $title, $content, $link_url, $id]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO news (news_date, title, content, link_url) VALUES (?, ?, ?, ?)");
            $stmt->execute([$news_date, $title, $content, $link_url]);
        }
        header('Location: /admin/news/index.php');
        exit;
    }
}

include __DIR__ . '/../inc/header.php';
?>

<div style="max-width: 800px; margin: 0 auto;">
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul style="margin: 0; padding-left: 20px;">
                <?php foreach ($errors as $e) echo "<li>" . h($e) . "</li>"; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="card">
        <form method="post">
            <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
            
            <div class="form-group">
                <label class="form-label">日付</label>
                <input type="date" name="news_date" class="form-control" value="<?php echo h($news['news_date']); ?>" required>
            </div>
            
            <div class="form-group">
                <label class="form-label">タイトル</label>
                <input type="text" name="title" class="form-control" value="<?php echo h($news['title']); ?>" required placeholder="例：夏季休業のお知らせ">
            </div>
            
            <div class="form-group">
                <label class="form-label">詳細 (任意)</label>
                <textarea name="content" class="form-control" style="height:150px;"><?php echo h($news['content']); ?></textarea>
            </div>
            
            <div class="form-group">
                <label class="form-label">リンクURL (任意)</label>
                <input type="text" name="link_url" class="form-control" value="<?php echo h($news['link_url']); ?>" placeholder="例：/works.php (特定のページに飛ばしたい場合)">
            </div>

            <div style="margin-top: 30px; border-top: 1px solid #eee; padding-top: 20px; text-align: right;">
                <a href="/admin/news/index.php" class="btn btn-secondary" style="margin-right: 10px;">一覧に戻る</a>
                <button type="submit" class="btn btn-primary">保存する</button>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../inc/footer.php'; ?>
