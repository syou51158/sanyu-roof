<?php
session_start();

// Configuration
$PAGE_TITLE = "メール初期設定ポータル | Sanyu Roof";
$ACCESS_PASSWORD = 'sanyu2025';


// Login Logic
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password'])) {
    if ($_POST['password'] === $ACCESS_PASSWORD) {
        $_SESSION['mail_setup_auth'] = true;
        header("Location: index.php");
        exit;
    } else {
        $error = "パスワードが異なります。もう一度ご確認をお願いいたします。";
    }
}

// Check Auth
$is_authenticated = isset($_SESSION['mail_setup_auth']) && $_SESSION['mail_setup_auth'] === true;

// Accounts Data
$accounts = [
    [
        'id' => 'info',
        'role' => '代表メール (Representative)',
        'name' => 'Sanyu Roof (Info)',
        'email' => 'info@sanyu-roof.jp',
        'pass' => 'Ps4aO4d42-R-Mlb'
    ],
    [
        'id' => 'yuma',
        'role' => '山本 雄真 様 (Yuma Yamamoto)',
        'name' => 'Yuma Yamamoto',
        'email' => 'yu-ma.yamamoto@sanyu-roof.jp',
        'pass' => 'Q1P6vmobngEVdJWZ--'
    ]
];
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF_8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $PAGE_TITLE; ?></title>
    <link rel="stylesheet" href="assets/style.css">
    <script>
        function toggleManual(id) {
            var wrapper = document.getElementById('wrapper-' + id);
            wrapper.classList.toggle('open');
            
            var btn = document.getElementById('btn-manual-' + id);
            if (wrapper.classList.contains('open')) {
                btn.innerHTML = 'パソコン・その他 (閉じる)';
                btn.style.backgroundColor = '#fff';
                btn.style.color = '#333';
            } else {
                btn.innerHTML = 'パソコン・その他で設定する';
                btn.style.backgroundColor = 'transparent';
                btn.style.color = '#888';
            }
        }

        async function copyToClipboard(text, btnElement) {
            try {
                await navigator.clipboard.writeText(text);
                const originalText = btnElement.innerText;
                btnElement.innerText = "コピー完了！";
                btnElement.style.backgroundColor = "#E6FFFA";
                btnElement.style.color = "#00A3C4";
                
                setTimeout(() => {
                    btnElement.innerText = originalText;
                    btnElement.style.backgroundColor = "";
                    btnElement.style.color = "";
                }, 2000);
            } catch (err) {
                alert('コピーできませんでした: ' + text);
            }
        }
    </script>
</head>
<body>

<div class="container">
    <!-- Header -->
    <div class="header-section">
        <div class="logo-area">
            <!-- Text Logo or Image -->
            <div class="site-title">Sanyu Roof</div>
        </div>
        <h1 class="page-title">メール初期設定ポータル</h1>
    </div>

    <?php if (!$is_authenticated): ?>
        <!-- LOGIN SCREEN -->
        <div class="auth-card">
            <p class="auth-message">
                関係者様専用ページとなっております。<br>
                事前にお伝えしておりますパスワードをご入力ください。
            </p>
            
            <?php if (isset($error)): ?>
                <p style="color: #E53E3E; font-weight: bold; margin-bottom: 20px;"><?php echo $error; ?></p>
            <?php endif; ?>

            <form method="POST">
                <input type="password" name="password" class="auth-input" placeholder="パスワードを入力" required>
                <div style="margin-top: 25px;">
                    <button type="submit" class="btn-main" style="width: auto; padding: 15px 40px; margin-bottom: 0;">
                        ログインする
                    </button>
                </div>
            </form>
        </div>
    <?php else: ?>
        <!-- MAIN DASHBOARD -->
        
        <div class="intro-message">
            <div class="intro-title">
                <span>👋</span> ようこそ、Sanyu Roof メール設定へ
            </div>
            <p class="intro-text">
                新しいメールアドレスのご準備が整いました。<br>
                難しい設定は必要ございません。以下のボタンを押すだけで、iPhoneやiPadに自動で設定いただけます。<br>
                パソコンの方は「パソコン・その他で設定する」を押して情報をご覧ください。
            </p>
        </div>

        <div class="account-section">
            <?php foreach ($accounts as $acc): ?>
                <div class="account-card">
                    <div class="card-header">
                        <span class="user-name"><?php echo $acc['role']; ?></span>
                        <span class="role-badge">設定情報</span>
                    </div>
                    <div class="card-body">
                        <div style="font-size: 0.9rem; color: #888; margin-bottom: 5px;">貴方様のメールアドレス</div>
                        <div class="email-display"><?php echo $acc['email']; ?></div>

                        <!-- One Click iOS -->
                        <form action="download.php" method="POST" target="_blank">
                            <input type="hidden" name="name" value="<?php echo $acc['name']; ?>">
                            <input type="hidden" name="email" value="<?php echo $acc['email']; ?>">
                            <input type="hidden" name="password" value="<?php echo $acc['pass']; ?>">
                            
                            <button type="submit" class="btn-main">
                                <span class="icon">📱</span> iPhone / iPad に設定する
                            </button>
                        </form>

                        <!-- Manual Toggle -->
                        <button id="btn-manual-<?php echo $acc['id']; ?>" class="btn-sub" onclick="toggleManual('<?php echo $acc['id']; ?>')">
                            パソコン・その他で設定する
                        </button>

                        <!-- Manual Details -->
                        <div id="wrapper-<?php echo $acc['id']; ?>" class="manual-wrapper">
                            <div class="manual-content">
                                <h3 style="font-size: 1rem; color: #333; margin-bottom: 20px; text-align: center;">💻 手動設定用などの情報</h3>

                                <div class="info-group">
                                    <span class="info-label">メールアドレス</span>
                                    <div class="info-row">
                                        <span class="info-value"><?php echo $acc['email']; ?></span>
                                        <button class="btn-copy" onclick="copyToClipboard('<?php echo $acc['email']; ?>', this)">コピー</button>
                                    </div>
                                </div>

                                <div class="info-group">
                                    <span class="info-label">パスワード (共通)</span>
                                    <div class="info-row">
                                        <span class="info-value"><?php echo $acc['pass']; ?></span>
                                        <button class="btn-copy" onclick="copyToClipboard('<?php echo $acc['pass']; ?>', this)">コピー</button>
                                    </div>
                                </div>

                                <div style="margin-top: 30px; padding-top: 20px; border-top: 2px dashed #EEE;">
                                    <div class="info-group">
                                        <span class="info-label">受信サーバー (IMAP)</span>
                                        <div class="info-row">
                                            <span class="info-value">imap.lolipop.jp</span>
                                            <button class="btn-copy" onclick="copyToClipboard('imap.lolipop.jp', this)">コピー</button>
                                        </div>
                                        <div style="font-size: 0.8rem; color: #999; margin-top: 5px;">ポート: 993 (SSL)</div>
                                    </div>

                                    <div class="info-group" style="margin-bottom: 0;">
                                        <span class="info-label">送信サーバー (SMTP)</span>
                                        <div class="info-row">
                                            <span class="info-value">smtp.lolipop.jp</span>
                                            <button class="btn-copy" onclick="copyToClipboard('smtp.lolipop.jp', this)">コピー</button>
                                        </div>
                                        <div style="font-size: 0.8rem; color: #999; margin-top: 5px;">ポート: 465 (SSL)</div>
                                    </div>
                                </div>

                            </div>
                        </div><!-- /manual-wrapper -->
                    </div><!-- /card-body -->
                </div><!-- /account-card -->
            <?php endforeach; ?>
        </div>

        <!-- GUIDE SECTION -->
        <div class="guide-container">
            <h3 class="guide-heading">🔰 iPhone / iPad 設定の流れ</h3>
            <ul class="steps">
                <li class="step-card">
                    <div class="step-dot">1</div>
                    <div class="step-title">ボタンを押す</div>
                    <div class="step-desc">
                        上の青いボタン<strong>「iPhone / iPad に設定する」</strong>を押してください。<br>
                        画面に許可を求める表示が出た場合は<strong>「許可」</strong>を押してください。<br>
                        <span style="font-size: 0.85rem; color: #888;">※「プロファイルがダウンロードされました」と出たら成功です。</span>
                    </div>
                </li>
                <li class="step-card">
                    <div class="step-dot">2</div>
                    <div class="step-title">設定アプリを開く</div>
                    <div class="step-desc">
                        ホーム画面に戻り、歯車マークの<strong>「設定」アプリ</strong>を開いてください。<br>
                        一番上に<strong>「プロファイルがダウンロード済み」</strong>という項目が出ていますので、そこを押します。
                    </div>
                </li>
                <li class="step-card">
                    <div class="step-dot">3</div>
                    <div class="step-title">インストールして完了</div>
                    <div class="step-desc">
                        右上の<strong>「インストール」</strong>を押し、画面の指示に従って進めてください（パスコード入力など）。<br>
                        最後に「完了」を押せば設定終了です。「メール」アプリを開いてみましょう！
                    </div>
                </li>
            </ul>
        </div>

    <?php endif; ?>

    <div class="footer-simple">
        &copy; Sanyu Roof
    </div>
</div>

</body>
</html>
