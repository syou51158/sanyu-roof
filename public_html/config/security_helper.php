<?php
// public_html/config/security_helper.php

/**
 * Get detailed client information for security logging
 * @return array
 */
function get_client_details() {
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'Unknown';
    $ua = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';
    
    // 1. Get Location (using free ip-api.com)
    // Refactored to use cURL with timeout to prevent blocking login
    $geo_info = 'Location Unknown';
    if ($ip !== '127.0.0.1' && $ip !== '::1') {
        if (function_exists('curl_init')) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "http://ip-api.com/json/{$ip}?fields=status,country,city,isp");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 2); // 2 second timeout
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
            $json = curl_exec($ch);
            curl_close($ch);
            
            if ($json) {
                $data = json_decode($json, true);
                if ($data && isset($data['status']) && $data['status'] === 'success') {
                    $geo_info = "{$data['country']}, {$data['city']} ({$data['isp']})";
                }
            }
        } else {
             // Fallback if cURL is not available (try file_get_contents with error suppression)
             $context = stream_context_create(['http' => ['timeout' => 2]]);
             $json = @file_get_contents("http://ip-api.com/json/{$ip}?fields=status,country,city,isp", false, $context);
             if ($json) {
                $data = json_decode($json, true);
                if ($data && isset($data['status']) && $data['status'] === 'success') {
                    $geo_info = "{$data['country']}, {$data['city']} ({$data['isp']})";
                }
             }
        }
    } else {
        $geo_info = 'Localhost';
    }

    // 2. Parse User Agent (Simple robust detection)
    $os = 'Unknown OS';
    if (preg_match('/iphone/i', $ua)) $os = 'iPhone';
    elseif (preg_match('/android/i', $ua)) $os = 'Android';
    elseif (preg_match('/macintosh|mac os x/i', $ua)) $os = 'Mac OS';
    elseif (preg_match('/windows/i', $ua)) $os = 'Windows';
    elseif (preg_match('/linux/i', $ua)) $os = 'Linux';
    elseif (preg_match('/ipad/i', $ua)) $os = 'iPad';

    $browser = 'Unknown Browser';
    if (preg_match('/msie/i', $ua) || preg_match('/trident/i', $ua)) $browser = 'Internet Explorer';
    elseif (preg_match('/edge/i', $ua)) $browser = 'Edge';
    elseif (preg_match('/firefox/i', $ua)) $browser = 'Firefox';
    elseif (preg_match('/chrome/i', $ua)) $browser = 'Chrome';
    elseif (preg_match('/safari/i', $ua)) $browser = 'Safari';

    return [
        'ip' => $ip,
        'geo' => $geo_info,
        'os' => $os,
        'browser' => $browser,
        'ua_raw' => $ua
    ];
}

/**
 * Send Login Notification Email
 */
function send_login_notification($username) {
    if (!defined('MAIL_TO')) return;

    $info = get_client_details();
    $timestamp = date('Y/m/d H:i:s');
    
    $subject = "【セキュリティ通知】管理画面へのログインがありました";
    
    $body = <<<EOD
管理画面へのログインが検出されました。

■ログイン情報
--------------------------------------------------
ユーザー: {$username}
日時    : {$timestamp}
IPアドレス: {$info['ip']}
場所    : {$info['geo']}
端末/OS : {$info['os']}
ブラウザ: {$info['browser']}
--------------------------------------------------

■心当たりがない場合
不正アクセスの可能性があります。
直ちに管理画面にログインし、パスワードを変更してください。

■ユーザーエージェント (詳細)
{$info['ua_raw']}

EOD;

    // Send to Admin (MAIL_TO)
    // Using the existing mail function
    if (function_exists('send_mail_smtp')) {
        send_mail_smtp(MAIL_TO, $subject, $body);
        
        // Also send to the fixed sender address for double safety if different
        if (MAIL_TO !== 'info@sanyu-roof.jp') {
             send_mail_smtp('info@sanyu-roof.jp', $subject, $body);
        }
    }
}

/**
 * Generate Secure Token
 */
function generate_token() {
    return bin2hex(random_bytes(32));
}

/**
 * Send Invitation Email
 */
function send_invitation_email($email, $token) {
    if (!function_exists('send_mail_smtp')) return false;

    $url = SITE_URL . "/admin/reset_password.php?token=" . $token . "&action=invite";
    $subject = "【" . SITE_NAME . "】管理画面への招待";
    
    $body = <<<EOD
管理画面への招待が届いています。
以下のURLをクリックして、パスワードを設定しアカウントを有効化してください。

■アカウント有効化URL
{$url}

(有効期限: 24時間)
EOD;

    $result = send_mail_smtp($email, $subject, $body);
    if (is_array($result)) {
        return $result['success'];
    }
    return $result;
}

/**
 * Send Password Reset Email
 */
function send_password_reset_email($email, $token) {
    if (!function_exists('send_mail_smtp')) return false;

    $url = SITE_URL . "/admin/reset_password.php?token=" . $token;
    $subject = "【" . SITE_NAME . "】パスワードリセット";
    
    $body = <<<EOD
パスワードリセットのリクエストを受け付けました。
以下のURLをクリックして、新しいパスワードを設定してください。

■パスワードリセットURL
{$url}

(有効期限: 1時間)

心当たりがない場合は、このメールを破棄してください。
EOD;

    return send_mail_smtp($email, $subject, $body);
}
?>
