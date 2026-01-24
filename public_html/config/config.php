<?php
// セキュリティヘッダーの送出
header("X-Frame-Options: SAMEORIGIN");
header("X-XSS-Protection: 1; mode=block");
header("X-Content-Type-Options: nosniff");
header("Referrer-Policy: strict-origin-when-cross-origin");

// セッション開始（全ページ共通）
if (session_status() === PHP_SESSION_NONE) {
    // セッションクッキーのセキュリティ設定
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'domain' => '',
        'secure' => isset($_SERVER['HTTPS']), // HTTPS時のみSecure属性
        'httponly' => true, // JavaScriptからのアクセス禁止
        'samesite' => 'Lax'
    ]);
    session_start();
}

// データベース接続関数を先に定義 (定数定義で使うため)
function get_db_connection_early() {
    $db_path = dirname(__DIR__, 2) . '/db/sanyu_roof.sqlite';
    try {
        $pdo = new PDO("sqlite:" . $db_path);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdo;
    } catch (PDOException $e) {
        return null;
    }
}

// DBから設定取得
$settings = [];
$pdo = get_db_connection_early();
if ($pdo) {
    try {
        $stmt = $pdo->query("SELECT setting_key, setting_value FROM site_settings");
        $results = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
        if ($results) $settings = $results;
    } catch (Exception $e) { /* ignore if table missing */ }
}

// サイト情報 (DB優先, なければデフォルト)
define('SITE_NAME', $settings['site_name'] ?? '山勇ルーフ');
define('SITE_URL', (empty($_SERVER['HTTPS']) ? 'http://' : 'https://') . ($_SERVER['HTTP_HOST'] ?? 'localhost')); 
define('COMPANY_NAME', $settings['company_name'] ?? '山勇ルーフ');
define('COMPANY_OWNER', $settings['company_owner'] ?? '山本勇真');
define('COMPANY_ADDRESS', $settings['company_address'] ?? '〒612-8487 京都府京都市伏見区羽束師菱川町46番地'); // 更新
define('COMPANY_PHONE', $settings['company_phone'] ?? '080-5706-7681');
define('COMPANY_INVOICE', $settings['company_invoice'] ?? 'T4810438817670');

// メール設定
define('MAIL_TO', $settings['mail_to'] ?? 'info@sanyu-roof.jp'); 
define('MAIL_FROM', $settings['mail_from'] ?? 'info@sanyu-roof.jp'); 

// 既存のget_db_connectionはそのまま利用 (ただし二重定義避けるか、上記を使い回す)
// ここでは既存の定義位置を変えるため、下部の定義を維持しつつ、上記は初期化用とする


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

// データベース接続 (SQLite)
// ロリポップなどのレンタルサーバーでは、ファイルベースのSQLiteが便利です。
// データベース接続 (SQLite)
function get_db_connection() {
    // 複数のパス候補を試す（サーバー環境によってディレクトリ構造が異なる場合があるため）
    $candidates = [
        dirname(__DIR__, 2) . '/db/sanyu_roof.sqlite', // ローカル/推奨構成 (public_htmlの1つ上)
        dirname(__DIR__) . '/db/sanyu_roof.sqlite',    // public_htmlの中にdbフォルダがある場合 (Fallback)
        __DIR__ . '/db/sanyu_roof.sqlite'               // configフォルダ内 (緊急避難)
    ];

    $db_path = null;
    foreach ($candidates as $candidate) {
        if (file_exists($candidate)) {
            $db_path = $candidate;
            break;
        }
    }

    // 見つからない場合は最初の候補を使用（エラーメッセージ用）
    if (!$db_path) {
        $db_path = $candidates[0];
    }
    
    try {
        $pdo = new PDO("sqlite:" . $db_path);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdo;
    } catch (PDOException $e) {
        // 接続エラー時：デバッグ情報を表示
        echo "<h1>Database Connection Failed</h1>";
        echo "<p>データベースに接続できませんでした。</p>";
        echo "<ul>";
        echo "<li>Tried Path: " . h($db_path) . "</li>";
        echo "<li>File Exists: " . (file_exists($db_path) ? 'Yes' : 'No') . "</li>";
        echo "<li>Error Info: " . h($e->getMessage()) . "</li>";
        echo "</ul>";
        echo "<p><strong>解決策:</strong> <code>db</code> フォルダが <code>public_html</code> と同じ階層（または中）にアップロードされているか確認してください。</p>";
        exit;
    }
}

// 管理者認証チェック（管理画面用）
function require_login() {
    if (empty($_SESSION['admin_id'])) {
        header('Location: /admin/login.php');
        exit;
    }
}
?>