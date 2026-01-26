<?php
// public_html/config/mail_function.php

require_once __DIR__ . '/config.php';

/**
 * Send email using standard PHP mail function (mb_send_mail)
 * Optimized for Lolipop server
 * 
 * @param string $to Recipient email
 * @param string $subject Subject
 * @param string $body Body content
 * @param string|null $replyTo Reply-To address (optional)
 * @return array ['success' => bool, 'message' => string]
 */
function send_mail_smtp($to, $subject, $body, $replyTo = null) {
    // 言語設定: UTF-8で送信するために 'uni' を設定
    mb_language("uni");
    mb_internal_encoding("UTF-8");

    // 送信元設定
    $from_email = 'info@sanyu-roof.jp'; // ロリポップで作成したメールアドレス
    $from_name = COMPANY_NAME;

    // ヘッダー作成
    $headers = [];
    $headers[] = "From: " . mb_encode_mimeheader($from_name) . " <{$from_email}>";
    
    if ($replyTo) {
        $headers[] = "Reply-To: {$replyTo}";
    }
    
    $headers[] = "MIME-Version: 1.0";
    $headers[] = "Content-Type: text/plain; charset=UTF-8";
    $headers[] = "X-Mailer: PHP/" . phpversion();

    // 複数宛先対応
    $recipients = [];
    if (strpos($to, ',') !== false) {
        $recipients = array_map('trim', explode(',', $to));
    } else {
        $recipients[] = trim($to);
    }

    // ★ Localhost Mocking (for development)
    if ($_SERVER['REMOTE_ADDR'] === '127.0.0.1' || $_SERVER['REMOTE_ADDR'] === '::1') {
        $log_file = __DIR__ . '/../debug_emails.log';
        $log_content = "To: " . implode(', ', $recipients) . "\nSubject: $subject\nDate: " . date('Y-m-d H:i:s') . "\n\n$body\n--------------------------------------------------\n";
        file_put_contents($log_file, $log_content, FILE_APPEND);
        return ['success' => true, 'message' => '送信しました (テスト環境: log保存)'];
    }

    $success_count = 0;
    foreach ($recipients as $recipient) {
        if (!empty($recipient)) {
            if (mb_send_mail($recipient, $subject, $body, implode("\r\n", $headers))) {
                $success_count++;
            }
        }
    }

    if ($success_count > 0) {
        return ['success' => true, 'message' => '送信しました'];
    } else {
        return ['success' => false, 'message' => '送信に失敗しました'];
    }
}
?>
