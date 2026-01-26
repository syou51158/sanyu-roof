<?php
// public_html/admin/forgot_password.php
require_once '../config/config.php';
require_once '../config/mail_function.php';
require_once '../config/security_helper.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    
    // CSRF check
    $token = $_POST['csrf_token'] ?? '';
    if (!validate_csrf_token($token)) {
        $error = '不正なリクエストです。';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = '有効なメールアドレスを入力してください。';
    } else {
        $pdo = get_db_connection();
        $stmt = $pdo->prepare("SELECT id, username FROM admins WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        // ユーザーが存在する場合のみ処理 (セキュリティのため、存在しなくても成功メッセージを出すのがベストだが、
        // 社内ツールなので利便性重視でエラーは出さないが進める)
        if ($user) {
            $token = generate_token();
            $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
            
            // Update DB with token
            $stmt = $pdo->prepare("UPDATE admins SET reset_token = ?, token_expires_at = ? WHERE id = ?");
            if ($stmt->execute([$token, $expires, $user['id']])) {
                // Send Email
                if (send_password_reset_email($email, $token)) {
                    $success = 'パスワードリセット用のリンクをメールで送信しました。';
                } else {
                    $error = 'メールの送信に失敗しました。サーバーの設定をご確認ください。';
                }
            } else {
                $error = 'システムエラーが発生しました。';
            }
        } else {
            // ユーザーが見つからない場合も、セキュリティ上は「送信しました」と出すのが定石だが、
            // わかりやすく「登録されていないメールアドレスです」と出してもよい（要件次第）。
            // ここでは安全側に倒して「送信しました」とする（または、管理者ツールなので明確にエラーにするか）。
            // 今回は管理者ツールなので、明確にエラーを出す方が親切。
            $error = 'このメールアドレスは登録されていません。';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>パスワードリセット - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <style>
        .login-container { max-width: 400px; margin: 100px auto; padding: 30px; background: #fff; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .login-title { text-align: center; margin-bottom: 20px; font-size: 1.5rem; }
        .form-group { margin-bottom: 20px; }
        .form-control { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        .btn-login { width: 100%; padding: 12px; background: #333; color: #fff; border: none; border-radius: 4px; cursor: pointer; transition: background 0.3s; }
        .btn-login:hover { background: #555; }
        .error-msg { color: #d9534f; margin-bottom: 20px; text-align: center; background: #f9d6d5; padding: 10px; border-radius: 4px; }
        .success-msg { color: #155724; margin-bottom: 20px; text-align: center; background: #d4edda; padding: 10px; border-radius: 4px; }
    </style>
</head>
<body style="background: #f4f4f4;">

<div class="login-container">
    <h2 class="login-title">パスワードをお忘れの方</h2>
    
    <?php if ($error): ?>
        <p class="error-msg"><?php echo h($error); ?></p>
    <?php endif; ?>
    <?php if ($success): ?>
        <p class="success-msg"><?php echo h($success); ?></p>
    <?php endif; ?>

    <?php if (!$success): ?>
    <p style="margin-bottom: 20px; font-size: 0.9rem; color: #666;">
        登録しているメールアドレスを入力してください。<br>パスワードリセット用のリンクを送信します。
    </p>

    <form method="post" action="">
        <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
        <div class="form-group">
            <label>メールアドレス</label>
            <input type="email" name="email" class="form-control" required autofocus placeholder="example@sanyu-roof.jp">
        </div>
        <button type="submit" class="btn-login">送信する</button>
    </form>
    <?php endif; ?>

    <div style="text-align:center; margin-top:20px;">
        <a href="/admin/login.php" style="font-size:0.9rem; color:#666;">ログイン画面に戻る</a>
    </div>
</div>

</body>
</html>
