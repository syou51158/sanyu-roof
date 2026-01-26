<?php
// public_html/admin/reset_password.php
require_once '../config/config.php';

$token = $_GET['token'] ?? '';
$action = $_GET['action'] ?? 'reset'; // 'reset' or 'invite'

$error = '';
$success = '';
$valid_token = false;

$pdo = get_db_connection();

// Verify Token
if ($token) {
    $stmt = $pdo->prepare("SELECT id, username, email, token_expires_at FROM admins WHERE reset_token = ?");
    $stmt->execute([$token]);
    $user = $stmt->fetch();

    if ($user) {
        if (strtotime($user['token_expires_at']) > time()) {
            $valid_token = true;
        } else {
            $error = 'このリンクは有効期限切れです。再度手続きを行ってください。';
        }
    } else {
        $error = '無効なリンクです。';
    }
} else {
    $error = 'トークンが指定されていません。';
}

// Handle Password Update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $valid_token) {
    if (!validate_csrf_token($_POST['csrf_token'])) {
        $error = '不正なリクエストです。';
    } else {
        $new_pass = $_POST['new_pass'] ?? '';
        $confirm_pass = $_POST['confirm_pass'] ?? '';
        $username = trim($_POST['username'] ?? ''); // Allow setting username on invite

        if (strlen($new_pass) < 8) {
            $error = 'パスワードは8文字以上で設定してください。';
        } elseif ($new_pass !== $confirm_pass) {
            $error = '確認用パスワードが一致しません。';
        } elseif ($action === 'invite' && empty($username)) {
             $error = 'ログインIDを入力してください。';
        } else {
            // Update Password & Clear Token
            $hash = password_hash($new_pass, PASSWORD_DEFAULT);
            
            try {
                if ($action === 'invite') {
                    // Update username too if invite
                    $stmt = $pdo->prepare("UPDATE admins SET password = ?, username = ?, reset_token = NULL, token_expires_at = NULL WHERE id = ?");
                    $stmt->execute([$hash, $username, $user['id']]);
                } else {
                    $stmt = $pdo->prepare("UPDATE admins SET password = ?, reset_token = NULL, token_expires_at = NULL WHERE id = ?");
                    $stmt->execute([$hash, $user['id']]);
                }
                $success = 'パスワードを設定しました。ログインしてください。';
                $valid_token = false; // Hide form
            } catch (Exception $e) {
                $error = 'エラー: IDが既に使用されている可能性があります。';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>パスワード設定 - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <style>
        .login-container { max-width: 400px; margin: 100px auto; padding: 30px; background: #fff; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .login-title { text-align: center; margin-bottom: 20px; font-size: 1.5rem; }
        .form-group { margin-bottom: 20px; }
        .form-control { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        .btn-login { width: 100%; padding: 12px; background: var(--primary-color, #007bff); color: #fff; border: none; border-radius: 4px; cursor: pointer; transition: background 0.3s; }
        .btn-login:hover { background: #0056b3; }
        .error-msg { color: #d9534f; margin-bottom: 20px; text-align: center; background: #f9d6d5; padding: 10px; border-radius: 4px; }
        .success-msg { color: #155724; margin-bottom: 20px; text-align: center; background: #d4edda; padding: 10px; border-radius: 4px; }
    </style>
</head>
<body style="background: #f4f4f4;">

<div class="login-container">
    <h2 class="login-title">
        <?php echo $action === 'invite' ? 'アカウント有効化' : '新しいパスワードの設定'; ?>
    </h2>
    
    <?php if ($error): ?>
        <p class="error-msg"><?php echo h($error); ?></p>
    <?php endif; ?>
    <?php if ($success): ?>
        <p class="success-msg"><?php echo h($success); ?></p>
        <div style="text-align:center; margin-top:20px;">
            <a href="/admin/login.php" class="btn-login" style="display:block; text-decoration:none;">ログイン画面へ</a>
        </div>
    <?php endif; ?>

    <?php if ($valid_token && !$success): ?>
    <form method="post" action="">
        <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
        
        <?php if ($action === 'invite'): ?>
        <div class="form-group">
            <label>ログインID (お好きなIDを設定)</label>
            <input type="text" name="username" class="form-control" required placeholder="例: yamada" value="<?php echo h($user['username'] !== 'PENDING' ? $user['username'] : ''); ?>">
        </div>
        <?php endif; ?>

        <div class="form-group">
            <label>新しいパスワード (8文字以上)</label>
            <input type="password" name="new_pass" class="form-control" required>
        </div>
        <div class="form-group">
            <label>パスワード確認</label>
            <input type="password" name="confirm_pass" class="form-control" required>
        </div>
        <button type="submit" class="btn-login">設定を保存</button>
    </form>
    <?php endif; ?>

    <?php if (!$valid_token && !$success): ?>
        <div style="text-align:center; margin-top:20px;">
            <a href="/admin/login.php" style="font-size:0.9rem; color:#666;">ログイン画面に戻る</a>
        </div>
    <?php endif; ?>
</div>

</body>
</html>
