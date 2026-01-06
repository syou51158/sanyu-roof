<?php
require_once 'config/config.php';

// POSTリクエスト以外はリダイレクト
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: contact.php');
    exit;
}

// CSRFチェック
if (!validate_csrf_token($_POST['csrf_token'])) {
    die('不正なリクエストです。');
}

// Honeypotチェック (入力されていたらスパムとみなして終了)
if (!empty($_POST['website_url'])) {
    die('Spam detected.');
}

// 入力データの取得
$input = [
    'name' => $_POST['name'] ?? '',
    'tel' => $_POST['tel'] ?? '',
    'address' => $_POST['address'] ?? '',
    'contact_method' => $_POST['contact_method'] ?? '',
    'email' => $_POST['email'] ?? '',
    'message' => $_POST['message'] ?? ''
];

// バリデーション
$errors = [];
if (empty($input['name'])) $errors[] = 'お名前を入力してください';
if (empty($input['tel'])) $errors[] = '電話番号を入力してください';
if (empty($input['address'])) $errors[] = '地域を入力してください';
if (empty($input['message'])) $errors[] = 'ご相談内容を入力してください';
if ($input['contact_method'] === 'メール' && empty($input['email'])) {
    $errors[] = 'メールでの連絡をご希望の場合は、メールアドレスを入力してください';
}

// エラーがある場合は戻る
if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    $_SESSION['input'] = $input;
    header('Location: contact.php');
    exit;
}

// セッションに入力を保存（送信画面用）
$_SESSION['form_data'] = $input;

$page_title = "お問い合わせ確認";
include 'partials/head.php';
include 'partials/header.php';
?>

<main>
    <div class="section-gray" style="padding: 40px 0;">
        <div class="container text-center">
            <h1>お問い合わせ確認</h1>
        </div>
    </div>

    <section class="section">
        <div class="container">
            <p class="text-center mb-40">以下の内容で送信してもよろしいですか？</p>

            <div style="max-width: 800px; margin: 0 auto; border: 1px solid #ddd; padding: 30px; border-radius: 8px;">
                <table class="company-table">
                    <tr>
                        <th>お名前</th>
                        <td><?php echo h($input['name']); ?></td>
                    </tr>
                    <tr>
                        <th>電話番号</th>
                        <td><?php echo h($input['tel']); ?></td>
                    </tr>
                    <tr>
                        <th>地域</th>
                        <td><?php echo h($input['address']); ?></td>
                    </tr>
                    <tr>
                        <th>希望連絡方法</th>
                        <td><?php echo h($input['contact_method']); ?></td>
                    </tr>
                    <tr>
                        <th>メールアドレス</th>
                        <td><?php echo h($input['email']); ?></td>
                    </tr>
                    <tr>
                        <th>ご相談内容</th>
                        <td><?php echo nl2br(h($input['message'])); ?></td>
                    </tr>
                </table>
            </div>

            <div class="text-center mt-20" style="display: flex; gap: 20px; justify-content: center;">
                <button type="button" onclick="history.back()" class="btn btn-outline">戻る</button>
                <form action="contact_send.php" method="post">
                    <input type="hidden" name="csrf_token" value="<?php echo h($_POST['csrf_token']); ?>">
                    <button type="submit" class="btn btn-primary">送信する</button>
                </form>
            </div>
        </div>
    </section>
</main>

<?php include 'partials/footer.php'; ?>
