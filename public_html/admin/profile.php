<?php
// public_html/admin/profile.php
require_once '../config/config.php';
require_login();

$page_title = 'アカウント設定';
$errors = [];
$success = '';

$pdo = get_db_connection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validate_csrf_token($_POST['csrf_token'])) {
        die('不正なリクエストです。');
    }

    $username = $_POST['username'] ?? ''; // New ID
    $current_pass = $_POST['current_pass'] ?? '';
    $new_pass = $_POST['new_pass'] ?? '';
    $confirm_pass = $_POST['confirm_pass'] ?? '';

    // Verify current password first
    $stmt = $pdo->prepare("SELECT * FROM admins WHERE id = ?");
    $stmt->execute([$_SESSION['admin_id']]);
    $admin = $stmt->fetch();

    if (!password_verify($current_pass, $admin['password'])) {
        $errors[] = '現在のパスワードが間違っています。';
    }

    // Prepare Update logic
    if (empty($errors)) {
        if (!$username) {
            $errors[] = 'ログインIDは必須です。';
        }

        // If new password is entered
        $hash = $admin['password'];
        if (!empty($new_pass)) {
            if (strlen($new_pass) < 8) {
                $errors[] = '新しいパスワードは8文字以上で設定してください。';
            } elseif ($new_pass !== $confirm_pass) {
                $errors[] = '確認用パスワードが一致しません。';
            } else {
                $hash = password_hash($new_pass, PASSWORD_DEFAULT);
            }
        }

        if (empty($errors)) {
            try {
                $stmt = $pdo->prepare("UPDATE admins SET username = ?, password = ? WHERE id = ?");
                $stmt->execute([$username, $hash, $_SESSION['admin_id']]);
                
                // Update session
                $_SESSION['admin_username'] = $username;
                $success = 'アカウント情報を更新しました。';
            } catch (Exception $e) {
                $errors[] = 'エラー: このIDは既に使用されている可能性があります。';
            }
        }
    }
} else {
    // Initial Load
    $stmt = $pdo->prepare("SELECT username FROM admins WHERE id = ?");
    $stmt->execute([$_SESSION['admin_id']]);
    $admin = $stmt->fetch();
    $username = $admin['username'];
}

include __DIR__ . '/inc/header.php';
?>

<div style="max-width: 600px; margin: 0 auto;">
    <?php if ($success): ?>
        <div class="alert alert-success"><?php echo h($success); ?></div>
    <?php endif; ?>
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
            
            <h3 style="margin-top: 0; border-bottom: 2px solid var(--primary-color); padding-bottom: 15px; margin-bottom: 25px;">アカウント情報の変更</h3>

            <div class="form-group">
                <label class="form-label">ログインID</label>
                <input type="text" name="username" class="form-control" value="<?php echo h($username); ?>" required>
                <p style="font-size: 0.8rem; color: #666; margin-top: 5px;">ログイン時に使用するIDです。</p>
            </div>

            <div class="form-group" style="margin-top: 30px;">
                <label class="form-label">現在のパスワード <span style="color:red; font-size:0.8rem;">(必須)</span></label>
                <input type="password" name="current_pass" class="form-control" required placeholder="変更のために現在のパスワードを入力してください">
            </div>

            <hr style="margin: 30px 0; border: 0; border-top: 1px dashed #ddd;">
            <p style="font-size: 0.9rem; font-weight: bold; margin-bottom: 15px;">👇 パスワードを変更する場合のみ入力</p>
            
            <div class="form-group">
                <label class="form-label">新しいパスワード (8文字以上)</label>
                <input type="password" name="new_pass" class="form-control">
            </div>

            <div class="form-group">
                <label class="form-label">新しいパスワード (確認)</label>
                <input type="password" name="confirm_pass" class="form-control">
            </div>

            <div style="margin-top: 30px; border-top: 1px solid #eee; padding-top: 20px; text-align: center;">
                <button type="submit" class="btn btn-primary" style="padding: 10px 40px;">保存する</button>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/inc/footer.php'; ?>
