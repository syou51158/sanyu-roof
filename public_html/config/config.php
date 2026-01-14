<?php
// 設定ファイル：config/config.php

// サイト情報
define('SITE_NAME', '山勇ルーフ');
define('SITE_URL', (empty($_SERVER['HTTPS']) ? 'http://' : 'https://') . $_SERVER['HTTP_HOST']); // 自動取得
define('COMPANY_NAME', '山勇ルーフ');
define('COMPANY_OWNER', '山本勇真');
define('COMPANY_ADDRESS', '〒612-8487 京都府京都市伏見区羽束師菱川町５６９−４２');
define('COMPANY_PHONE', '080-5706-7681');
define('COMPANY_INVOICE', 'T4810438817670');

// メール設定
// 本番公開時はここを実際の受信メールアドレスに変更してください
define('MAIL_TO', 'info@example.com'); 
// 自動返信メールの送信元（レンタルサーバーのメールアドレス推奨）
define('MAIL_FROM', 'noreply@' . $_SERVER['HTTP_HOST']); 

// セッション開始（全ページ共通）
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ユーティリティ関数：XSS対策
function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

// ユーティリティ関数：CSRFトークン生成
function generate_csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// ユーティリティ関数：CSRFトークン検証
function validate_csrf_token($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}
?>