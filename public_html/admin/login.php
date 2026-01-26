<?php
// public_html/admin/login.php
require_once '../config/config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    // CSRF check
    $token = $_POST['csrf_token'] ?? '';
    if (!validate_csrf_token($token)) {
        $error = '不正なリクエストです。';
    } else {
        $pdo = get_db_connection();
        $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = :username");
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // Login success
            session_regenerate_id(true); // Prevent session fixation
            $_SESSION['admin_id'] = $user['id'];
            $_SESSION['admin_username'] = $user['username'];

            // Update Last Login Time
            $update_stmt = $pdo->prepare("UPDATE admins SET last_login_at = ? WHERE id = ?");
            $update_stmt->execute([date('Y-m-d H:i:s'), $user['id']]);

            // ■ Security Notification
            try {
                // Send email asynchronously if possible, but for simplicity we send it synchronously here
                if (file_exists('../config/mail_function.php') && file_exists('../config/security_helper.php')) {
                    require_once '../config/mail_function.php';
                    require_once '../config/security_helper.php';
                    send_login_notification($user['username']);
                }
            } catch (Throwable $e) {
                // error_log("Login notification failed: " . $e->getMessage());
                // Do not stop login process even if notification fails
            }

            header('Location: /admin/index.php');
            exit;
        } else {
            $error = 'ユーザー名またはパスワードが間違っています。';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理者ログイン - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <style>
        .login-container { max-width: 400px; margin: 100px auto; padding: 30px; background: #fff; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .login-title { text-align: center; margin-bottom: 20px; }
        .form-group { margin-bottom: 20px; }
        .form-control { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        .btn-login { width: 100%; padding: 12px; background: #333; color: #fff; border: none; border-radius: 4px; cursor: pointer; }
        .btn-login:hover { background: #555; }
        .error-msg { color: #d9534f; margin-bottom: 20px; text-align: center; }
    </style>
</head>
<body style="background: #f4f4f4;">

<div class="login-container">
    <h2 class="login-title">管理画面ログイン</h2>
    
    <?php if ($error): ?>
        <p class="error-msg"><?php echo h($error); ?></p>
    <?php endif; ?>

    <form method="post" action="">
        <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
        <div class="form-group">
            <label>ユーザー名</label>
            <input type="text" name="username" class="form-control" require autofocus>
            <div style="text-align:right; margin-top:5px;">
                <a href="/admin/forgot_password.php" style="font-size:0.8rem; color:#007bff; text-decoration:none;">パスワードをお忘れの方</a>
            </div>
        </div>
        <div class="form-group">
            <label>パスワード</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn-login">ログイン</button>
    </form>
    <div style="text-align:center; margin-top:20px;">
        <a href="/" style="font-size:0.9rem; color:#666;">← サイトへ戻る</a>
    </div>
</div>

</body>
</html>
