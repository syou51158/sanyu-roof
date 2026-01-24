<?php
// public_html/config/mail_function.php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/config.php';

/**
 * Send email using PHPMailer with SMTP settings from DB/Config
 * 
 * @param string $to Recipient email
 * @param string $subject Subject
 * @param string $body Body content
 * @param string|null $replyTo Reply-To address (optional)
 * @return array ['success' => bool, 'message' => string]
 */
function send_mail_smtp($to, $subject, $body, $replyTo = null) {
    // DBからは取得せず、ここで固定設定を行う (クライアント様には非表示にするため)
    /*
    $pdo = get_db_connection();
    $stmt = $pdo->query("SELECT setting_key, setting_value FROM site_settings WHERE setting_key LIKE 'smtp_%'");
    $smtp_settings = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
    */

    // 固定設定 (Lolipop SMTP)
    $host = 'smtp.lolipop.jp';
    $port = 465; // SSL
    $user = 'info@sanyu-roof.jp';
    $pass = 'Ps4aO4d42-R-Mlb'; // User Provided Password


    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = $host;
        $mail->SMTPAuth   = true;
        $mail->Username   = $user;
        $mail->Password   = $pass;
        $mail->SMTPSecure = ($port == 465) ? PHPMailer::ENCRYPTION_SMTPS : PHPMailer::ENCRYPTION_STARTTLS; 
        $mail->Port       = $port;
        $mail->CharSet    = 'UTF-8';

        // Sender info
        $mail->setFrom($user, COMPANY_NAME); // 送信元はSMTPアカウントと一致させるのが無難

        // Multiple Recipients Handling
        if (strpos($to, ',') !== false) {
            $recipients = explode(',', $to);
            foreach ($recipients as $recipient) {
                $recipient = trim($recipient);
                if (!empty($recipient)) {
                    $mail->addAddress($recipient);
                }
            }
        } else {
            $mail->addAddress($to);
        }

        if ($replyTo) {
            $mail->addReplyTo($replyTo);
        }

        // Content
        $mail->isHTML(false); // Text mail
        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();
        return ['success' => true, 'message' => '送信しました'];
    } catch (Exception $e) {
        return ['success' => false, 'message' => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"];
    }
}
?>
