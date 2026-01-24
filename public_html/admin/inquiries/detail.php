<?php
// public_html/admin/inquiries/detail.php
require_once '../../config/config.php';
require_login();

$id = $_GET['id'] ?? null;
if (!$id) die('IDが指定されていません');

$pdo = get_db_connection();

// 更新処理
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validate_csrf_token($_POST['csrf_token'])) {
        die('不正なリクエストです。');
    }
    $status = $_POST['status'];
    $memo = $_POST['memo'];
    $stmt = $pdo->prepare("UPDATE inquiries SET status = ?, memo = ? WHERE id = ?");
    $stmt->execute([$status, $memo, $id]);
    $msg = "状態を更新しました";
}

$stmt = $pdo->prepare("SELECT * FROM inquiries WHERE id = ?");
$stmt->execute([$id]);
$inquiry = $stmt->fetch();
if (!$inquiry) die('データが見つかりません');

$page_title = 'お問い合わせ詳細';
include __DIR__ . '/../inc/header.php';
?>

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
    <h2>ID: <?php echo h($inquiry['id']); ?> のお問い合わせ</h2>
    <a href="/admin/inquiries/index.php" class="btn btn-secondary">一覧に戻る</a>
</div>

<?php if($msg): ?><div class="alert alert-success"><?php echo h($msg); ?></div><?php endif; ?>

<div class="card" style="padding: 0; overflow: hidden;">
    <table class="data-table">
        <tr><th style="width: 200px;">受信日時</th><td><?php echo h($inquiry['created_at']); ?></td></tr>
        <tr><th>お名前</th><td><?php echo h($inquiry['name']); ?></td></tr>
        <tr><th>電話番号</th><td><?php echo h($inquiry['tel']); ?></td></tr>
        <tr><th>メールアドレス</th><td><?php echo h($inquiry['email']); ?></td></tr>
        <tr><th>住所</th><td><?php echo h($inquiry['address']); ?></td></tr>
        <tr><th>希望連絡方法</th><td><?php echo h($inquiry['contact_method']); ?></td></tr>
        <tr><th>ご相談内容</th><td><?php echo nl2br(h($inquiry['message'])); ?></td></tr>
    </table>
</div>

<div class="card" style="border-left: 5px solid var(--primary-color);">
    <h3 style="margin-top: 0;">社内管理用メモ</h3>
    <form method="post">
        <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
        
        <div class="form-group">
            <label class="form-label">対応状況</label>
            <select name="status" class="form-control" style="width: auto; display: inline-block;">
                <?php 
                $statuses = ['未対応', '対応中', '完了', '保留'];
                foreach ($statuses as $st) {
                    $selected = ($inquiry['status'] === $st) ? 'selected' : '';
                    echo "<option value='{$st}' {$selected}>{$st}</option>";
                }
                ?>
            </select>
        </div>
        
        <div class="form-group">
            <label class="form-label">社内メモ（お客様には公開されません）</label>
            <textarea name="memo" class="form-control" style="height:100px;"><?php echo h($inquiry['memo']); ?></textarea>
        </div>
        
        <button type="submit" class="btn btn-primary">更新する</button>
    </form>
</div>

<?php include __DIR__ . '/../inc/footer.php'; ?>
