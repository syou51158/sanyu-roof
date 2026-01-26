<?php
// public_html/admin/users/index.php
require_once '../../config/config.php';
require_once '../../config/mail_function.php';
require_once '../../config/security_helper.php';
require_login();

$page_title = '管理者一覧';
$pdo = get_db_connection();

// Create new invite
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'invite') {
    if (!validate_csrf_token($_POST['csrf_token'])) die('Invalid Request');
    
    $email = $_POST['email'] ?? '';
    // Check duplication
    $stmt = $pdo->prepare("SELECT id FROM admins WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        $error = "このメールアドレスは既に登録されています。";
    } else {
        $token = generate_token();
        $expires = date('Y-m-d H:i:s', strtotime('+24 hours'));
        
        // Insert PENDING admin
        $stmt = $pdo->prepare("INSERT INTO admins (username, password, email, reset_token, token_expires_at) VALUES ('PENDING', 'PENDING', ?, ?, ?)");
        if ($stmt->execute([$email, $token, $expires])) {
            require_once '../../config/security_helper.php';
            if (send_invitation_email($email, $token)) {
                $success = "招待メールを送信しました。";
            } else {
                $error = "メール送信に失敗しました。";
            }
        } else {
            $error = "DBエラーが発生しました。";
        }
    }
}

// Fetch Admins
$stmt = $pdo->query("SELECT * FROM admins ORDER BY id ASC");
$admins = $stmt->fetchAll();

include '../inc/header.php';
?>

<div style="max-width: 1000px; margin: 0 auto;">
    <?php if (isset($success)) echo '<div class="alert alert-success">'.h($success).'</div>'; ?>
    <?php if (isset($error)) echo '<div class="alert alert-danger">'.h($error).'</div>'; ?>

    <div class="card">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
            <h3 style="margin:0;">管理者アカウント一覧</h3>
            <button onclick="document.getElementById('invite-form').style.display='block'" class="btn btn-primary" style="font-size:0.9rem;">＋ 新規招待</button>
        </div>

        <!-- Invite Form (Hidden by default) -->
        <div id="invite-form" style="display:none; background:#f8f9fa; padding:20px; border-radius:4px; margin-bottom:20px;">
            <h4>新規管理者の招待</h4>
            <form method="post">
                <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                <input type="hidden" name="action" value="invite">
                <div style="display:flex; gap:10px;">
                    <input type="email" name="email" class="form-control" placeholder="相手のメールアドレス" required>
                    <button type="submit" class="btn btn-primary">招待メールを送る</button>
                </div>
            </form>
        </div>

        <div style="overflow-x:auto;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>ユーザー名</th>
                        <th>メールアドレス</th>
                        <th>最終ログイン</th>
                        <th>ステータス</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($admins as $admin): ?>
                    <tr>
                        <td><?php echo h($admin['id']); ?></td>
                        <td>
                            <?php if ($admin['username'] === 'PENDING'): ?>
                                <span style="color:#999;">(未設定)</span>
                            <?php else: ?>
                                <strong><?php echo h($admin['username']); ?></strong>
                            <?php endif; ?>
                            <?php if ($admin['id'] == $_SESSION['admin_id']) echo ' <span style="font-size:0.8rem; color:green;">(あなた)</span>'; ?>
                        </td>
                        <td><?php echo h($admin['email']); ?></td>
                        <td>
                            <?php echo $admin['last_login_at'] ? h($admin['last_login_at']) : '<span style="color:#ccc;">-</span>'; ?>
                        </td>
                        <td>
                            <?php if ($admin['username'] === 'PENDING'): ?>
                                <span style="background:orange; color:white; padding:2px 6px; border-radius:3px; font-size:0.8rem;">招待中</span>
                            <?php else: ?>
                                <span style="background:#28a745; color:white; padding:2px 6px; border-radius:3px; font-size:0.8rem;">有効</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($admin['id'] != $_SESSION['admin_id']): ?>
                            <form method="post" action="delete.php" style="display:inline;" id="delete-form-<?php echo h($admin['id']); ?>">
                                <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                                <input type="hidden" name="id" value="<?php echo h($admin['id']); ?>">
                                <button type="button" class="btn btn-danger" style="padding:4px 8px; font-size:0.8rem;" onclick="if(confirm('本当に削除しますか？')){ document.getElementById('delete-form-<?php echo h($admin['id']); ?>').submit(); }">削除</button>
                            </form>
                            <?php else: ?>
                                <span style="color:#ccc; font-size:0.8rem;">削除不可</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include '../inc/footer.php'; ?>
