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

// 1. 管理者宛メール作成
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
{COMPANY_NAME}
住所：{COMPANY_ADDRESS}
電話：{COMPANY_PHONE}
==================================================
EOD;
}

// メール送信設定
mb_language("Japanese");
mb_internal_encoding("UTF-8");

$header_admin = "From: " . MAIL_FROM;
$header_user = "From: " . MAIL_FROM;

// 送信実行
$result = mb_send_mail(MAIL_TO, $subject_admin, $body_admin, $header_admin);

if ($result) {
    // ユーザーへの自動返信（メールアドレスがある場合）
    if (!empty($data['email'])) {
        mb_send_mail($data['email'], $subject_user, $body_user, $header_user);
    }
    
    // セッションクリア
    unset($_SESSION['form_data']);
    unset($_SESSION['csrf_token']); // トークン使い切り
    
    header('Location: thanks.php');
    exit;
} else {
    // 送信失敗時
    echo "メールの送信に失敗しました。設定を確認するか、お電話にてご連絡ください。";
    // 実際にはエラーページへ誘導するのが望ましい
}
?>