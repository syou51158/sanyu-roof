<?php
// download.php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$name = isset($_POST['name']) && !empty($_POST['name']) ? $_POST['name'] : $_POST['email'];
$email = $_POST['email'];
$password = $_POST['password'];

if (empty($email) || empty($password)) {
    die("Error: Email and Password are required.");
}

// Generate unique IDs
function gen_uuid() {
    return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
        mt_rand( 0, 0xffff ),
        mt_rand( 0, 0x0fff ) | 0x4000,
        mt_rand( 0, 0x3fff ) | 0x8000,
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
    );
}

$payloadUUID = gen_uuid();
$profileUUID = gen_uuid();
$identifier = "jp.sanyu-roof.mail." . time();

// Clean the name for XML
$safeName = htmlspecialchars($name, ENT_XML1, 'UTF-8');
$safeEmail = htmlspecialchars($email, ENT_XML1, 'UTF-8');
$safePassword = htmlspecialchars($password, ENT_XML1, 'UTF-8');

// XML Content
$xml = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE plist PUBLIC "-//Apple//DTD PLIST 1.0//EN" "http://www.apple.com/DTDs/PropertyList-1.0.dtd">
<plist version="1.0">
<dict>
    <key>PayloadContent</key>
    <array>
        <dict>
            <key>EmailAccountDescription</key>
            <string>Sanyu Roof ($safeEmail)</string>
            <key>EmailAccountName</key>
            <string>$safeName</string>
            <key>EmailAccountType</key>
            <string>EmailTypeIMAP</string>
            <key>EmailAddress</key>
            <string>$safeEmail</string>
            <key>IncomingMailServerAuthentication</key>
            <string>EmailAuthPassword</string>
            <key>IncomingMailServerHostName</key>
            <string>imap.lolipop.jp</string>
            <key>IncomingMailServerPortNumber</key>
            <integer>993</integer>
            <key>IncomingMailServerUseSSL</key>
            <true/>
            <key>IncomingMailServerUsername</key>
            <string>$safeEmail</string>
            <key>IncomingPassword</key>
            <string>$safePassword</string>
            <key>OutgoingMailServerAuthentication</key>
            <string>EmailAuthPassword</string>
            <key>OutgoingMailServerHostName</key>
            <string>smtp.lolipop.jp</string>
            <key>OutgoingMailServerPortNumber</key>
            <integer>465</integer>
            <key>OutgoingMailServerUseSSL</key>
            <true/>
            <key>OutgoingMailServerUsername</key>
            <string>$safeEmail</string>
            <key>OutgoingPassword</key>
            <string>$safePassword</string>
            <key>PayloadDescription</key>
            <string>Configures email settings for Sanyu Roof account.</string>
            <key>PayloadDisplayName</key>
            <string>Email: $safeEmail</string>
            <key>PayloadIdentifier</key>
            <string>$identifier.email</string>
            <key>PayloadType</key>
            <string>com.apple.mail.managed</string>
            <key>PayloadUUID</key>
            <string>$payloadUUID</string>
            <key>PayloadVersion</key>
            <integer>1</integer>
        </dict>
    </array>
    <key>PayloadDisplayName</key>
    <string>Sanyu Roof Email Setup</string>
    <key>PayloadIdentifier</key>
    <string>$identifier</string>
    <key>PayloadOrganization</key>
    <string>Sanyu Roof Co., Ltd.</string>
    <key>PayloadRemovalDisallowed</key>
    <false/>
    <key>PayloadType</key>
    <string>Configuration</string>
    <key>PayloadUUID</key>
    <string>$profileUUID</string>
    <key>PayloadVersion</key>
    <integer>1</integer>
</dict>
</plist>
XML;

// Send Headers
header('Content-Type: application/x-apple-aspen-config; chatset=utf-8');
header('Content-Disposition: attachment; filename="sanyu-roof-mail.mobileconfig"');
echo $xml;
exit;
?>
