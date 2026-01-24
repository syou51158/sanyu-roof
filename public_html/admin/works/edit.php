<?php
// public_html/admin/works/edit.php
require_once '../../config/config.php';
require_login();

$pdo = get_db_connection();
$id = $_GET['id'] ?? null;
$work = ['title' => '', 'category' => '', 'content' => '', 'image_path' => '', 'before_image_path' => ''];
$page_title = '施工事例の新規登録';

if ($id) {
    $stmt = $pdo->prepare("SELECT * FROM works WHERE id = ?");
    $stmt->execute([$id]);
    $work = $stmt->fetch();
    if (!$work) {
        die('データが見つかりません');
    }
    $page_title = '施工事例の編集';
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // CSRF Check
    if (!validate_csrf_token($_POST['csrf_token'])) {
        die('不正なリクエストです。');
    }

    $title = $_POST['title'] ?? '';
    $category = $_POST['category'] ?? '';
    $content = $_POST['content'] ?? '';
    
    // File Upload Handling
    $image_path = $work['image_path']; 
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $filename = 'work_' . time() . '_after.' . $ext;
        $upload_dir = dirname(__DIR__, 2) . '/public_html/assets/img/uploads/';
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);
        move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $filename);
        $image_path = 'assets/img/uploads/' . $filename;
    }

    $before_image_path = $work['before_image_path'];
    if (isset($_FILES['before_image']) && $_FILES['before_image']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['before_image']['name'], PATHINFO_EXTENSION);
        $filename = 'work_' . time() . '_before.' . $ext;
        $upload_dir = dirname(__DIR__, 2) . '/public_html/assets/img/uploads/';
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);
        move_uploaded_file($_FILES['before_image']['tmp_name'], $upload_dir . $filename);
        $before_image_path = 'assets/img/uploads/' . $filename;
    }

    // Validation
    if (!$title) $errors[] = 'タイトルは必須です。';
    if (!$category) $errors[] = '工事内容は必須です。';

    if (empty($errors)) {
        if ($id) {
            $stmt = $pdo->prepare("UPDATE works SET title=?, category=?, content=?, image_path=?, before_image_path=? WHERE id=?");
            $stmt->execute([$title, $category, $content, $image_path, $before_image_path, $id]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO works (title, category, content, image_path, before_image_path) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$title, $category, $content, $image_path, $before_image_path]);
        }
        header('Location: /admin/works/index.php');
        exit;
    }
}

include __DIR__ . '/../inc/header.php';
?>

<div style="max-width: 800px; margin: 0 auto;">
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul style="margin: 0; padding-left: 20px;">
                <?php foreach ($errors as $e): ?>
                    <li><?php echo h($e); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="card">
        <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
            
            <div class="form-group">
                <label class="form-label">タイトル (お客様名など)</label>
                <input type="text" name="title" class="form-control" value="<?php echo h($work['title']); ?>" required placeholder="例：京都市伏見区 K様邸">
            </div>
            
            <div class="form-group">
                <label class="form-label">工事内容 (カテゴリ)</label>
                <input type="text" name="category" class="form-control" value="<?php echo h($work['category']); ?>" required placeholder="例：屋根葺き替え工事">
            </div>
            
            <div class="form-group">
                <label class="form-label">詳細説明</label>
                <textarea name="content" class="form-control" style="min-height: 150px;"><?php echo h($work['content']); ?></textarea>
            </div>
            
            <div class="form-group">
                <label class="form-label">After画像 (完成)</label>
                <input type="file" name="image" class="form-control">
                <?php if ($work['image_path']): ?>
                    <div style="margin-top: 10px; background: #f8f9fa; padding: 10px; border-radius: 4px; display: inline-block;">
                        <p style="margin: 0 0 5px 0; font-size: 0.8rem; color: #666;">現在の登録画像</p>
                        <img src="/<?php echo h($work['image_path']); ?>" style="max-width: 200px; border: 1px solid #ddd;">
                    </div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label class="form-label">Before画像 (施工前)</label>
                <input type="file" name="before_image" class="form-control">
                <?php if ($work['before_image_path']): ?>
                    <div style="margin-top: 10px; background: #f8f9fa; padding: 10px; border-radius: 4px; display: inline-block;">
                        <p style="margin: 0 0 5px 0; font-size: 0.8rem; color: #666;">現在の登録画像</p>
                        <img src="/<?php echo h($work['before_image_path']); ?>" style="max-width: 200px; border: 1px solid #ddd;">
                    </div>
                <?php endif; ?>
            </div>

            <div style="margin-top: 30px; border-top: 1px solid #eee; padding-top: 20px; text-align: right;">
                <a href="/admin/works/index.php" class="btn btn-secondary" style="margin-right: 10px;">一覧に戻る</a>
                <button type="submit" class="btn btn-primary">保存する</button>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../inc/footer.php'; ?>
