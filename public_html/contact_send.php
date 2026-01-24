<?php
require_once 'config/config.php';

// POSTチェック & セッションチェック
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_SESSION['form_data'])) {
    header('Location: contact.php');
    exit;
}

// CSRFチェック
if (!validate_csrf_token($_POST['csrf_token'])) {
    die('不正なリクエストです。');
}

// レート制限 (簡易): 直近の送信から時間が経っているかチェック等はDBなしだと難しいので
// ここではセッションハイジャック防止程度に、トークン再生成を行う
session_regenerate_id(true);

$data = $_SESSION['form_data'];

// 1. データベースに保存
try {
    $pdo = get_db_connection();
    $stmt = $pdo->prepare("INSERT INTO inquiries (name, tel, address, email, contact_method, message) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $data['name'],
        $data['tel'],
        $data['address'],
        $data['email'] ?? '',
        $data['contact_method'],
        $data['message']
    ]);
} catch (PDOException $e) {
    // ログ保存失敗してもメールは送りたいので、ここではエラーログ等に出力するのみとする
    error_log("DB Insert Error: " . $e->getMessage());
}

// 2. 管理者宛メール作成
$subject_admin = "【" . SITE_NAME . "】Webからお問い合わせがありました";
$body_admin = <<<EOD
Webサイトから新しいお問い合わせがありました。

■お名前：{$data['name']}
■電話番号：{$data['tel']}
■地域：{$data['address']}
■希望連絡方法：{$data['contact_method']}
■メールアドレス：{$data['email']}

■ご相談内容：
{$data['message']}

--------------------------------------------------
送信日時：2026-01-06 (自動生成)
ユーザーエージェント：{$_SERVER['HTTP_USER_AGENT']}
--------------------------------------------------
EOD;

// 2. 自動返信メール作成 (メールアドレスがある場合)
if (!empty($data['email'])) {
    $subject_user = "【" . SITE_NAME . "】お問い合わせありがとうございます";
    $company_name = COMPANY_NAME;
    $company_address = COMPANY_ADDRESS;
    $company_phone = COMPANY_PHONE;
    $body_user = <<<EOD
{$data['name']} 様

この度は、{$data['site_name']}にお問い合わせいただきありがとうございます。
以下の内容で受け付けいたしました。
担当者より折り返しご連絡させていただきます。

--------------------------------------------------
■お名前：{$data['name']}
■電話番号：{$data['tel']}
■ご相談内容：
{$data['message']}
--------------------------------------------------

※このメールは自動送信されています。

==================================================
{$company_name}
住所：{$company_address}
電話：{$company_phone}
==================================================
EOD;
}

// メール部品の読み込み
require_once 'config/mail_function.php';

// メール送信設定
mb_language("Japanese");
mb_internal_encoding("UTF-8");

// 送信実行 (管理者へ)
$result_admin = send_mail_smtp(MAIL_TO, $subject_admin, $body_admin, $data['email'] ?? null);

// 送信実行 (ユーザーへ: メールアドレスがある場合)
$result_user = ['success' => true]; // デフォルト成功扱い
if (!empty($data['email'])) {
    $result_user = send_mail_smtp($data['email'], $subject_user, $body_user);
}

if ($result_admin['success']) {
    // セッションクリア
    unset($_SESSION['form_data']);
    unset($_SESSION['csrf_token']); // トークン使い切り
    
    header('Location: thanks.php');
    exit;
} else {
    // 送信失敗時 (管理者へのメールが失敗した場合)
    error_log("Mail Send Error: " . $result_admin['message']);
    echo "申し訳ありません。サーバーのエラーによりメールを送信できませんでした。<br>";
    echo "エラー詳細: " . h($result_admin['message']);
    // 実際にはもっと親切なエラーページへ誘導するか、電話番号を表示する
}
?>