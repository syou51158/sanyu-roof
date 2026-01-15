<?php
$page_title = "お問い合わせ";
include 'partials/head.php';
include 'partials/header.php';

// セッションのエラーメッセージ取得
$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];
$input = isset($_SESSION['input']) ? $_SESSION['input'] : [];

// 表示用にクリア
unset($_SESSION['errors']);
unset($_SESSION['input']);
?>

<main>
    <!-- Page Header -->
    <div class="page-header">
        <div class="container text-center">
            <h1 class="page-title-en">CONTACT</h1>
            <p class="page-title-ja">お問い合わせ</p>
        </div>
    </div>

    <section class="section">
        <div class="container" style="max-width: 900px;">
            
            <!-- Contact Options (Phone/Line) -->
            <div class="contact-options">
                <div class="contact-option-card phone-card">
                    <div class="icon-wrapper">📞</div>
                    <div class="text-wrapper">
                        <h3>お電話でのお問い合わせ</h3>
                        <p class="note">お急ぎの方はこちら</p>
                        <a href="tel:<?php echo str_replace('-', '', COMPANY_PHONE); ?>" class="tel-link"><?php echo COMPANY_PHONE; ?></a>
                        <p class="hours">受付時間：9:00〜18:00（日曜定休）</p>
                    </div>
                </div>
                <!-- LINE option (placeholder if needed, or just emphasize ease) -->
                <div class="contact-option-card mail-card">
                    <div class="icon-wrapper">✉️</div>
                    <div class="text-wrapper">
                        <h3>Webフォームから</h3>
                        <p class="note">24時間受付中</p>
                        <p class="desc">以下のフォームより必要事項を入力して送信してください。2営業日以内に担当よりご連絡いたします。</p>
                    </div>
                </div>
            </div>

            <!-- Step Flow -->
            <div class="step-flow">
                <div class="step-item active">
                    <div class="step-number">1</div>
                    <div class="step-label">入力</div>
                </div>
                <div class="step-line"></div>
                <div class="step-item">
                    <div class="step-number">2</div>
                    <div class="step-label">確認</div>
                </div>
                <div class="step-line"></div>
                <div class="step-item">
                    <div class="step-number">3</div>
                    <div class="step-label">完了</div>
                </div>
            </div>

            <!-- Error Messages -->
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <h4 class="alert-heading">入力内容にエラーがあります</h4>
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo h($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <!-- Contact Form -->
            <div class="form-card">
                <form action="contact_confirm.php" method="post" class="h-adr">
                    <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                    <span class="p-country-name" style="display:none;">Japan</span>
                    
                    <!-- Honeypot -->
                    <div style="display:none;">
                        <label>このフィールドは空のままにしてください</label>
                        <input type="text" name="website_url" value="">
                    </div>

                    <div class="form-group">
                        <label class="form-label">お名前 <span class="badge-required">必須</span></label>
                        <div class="input-wrapper">
                            <input type="text" name="name" class="form-control" value="<?php echo isset($input['name']) ? h($input['name']) : ''; ?>" placeholder="例：山田 太郎" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">電話番号 <span class="badge-required">必須</span></label>
                        <div class="input-wrapper">
                            <input type="tel" name="tel" class="form-control" value="<?php echo isset($input['tel']) ? h($input['tel']) : ''; ?>" placeholder="例：090-1234-5678" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">地域（市区町村） <span class="badge-required">必須</span></label>
                        <div class="input-wrapper">
                            <input type="text" name="address" class="form-control p-region p-locality p-street-address" value="<?php echo isset($input['address']) ? h($input['address']) : ''; ?>" placeholder="例：京都市伏見区" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">希望連絡方法 <span class="badge-required">必須</span></label>
                        <div class="radio-group">
                            <label class="radio-label">
                                <input type="radio" name="contact_method" value="電話" <?php echo (!isset($input['contact_method']) || $input['contact_method'] === '電話') ? 'checked' : ''; ?>>
                                <span>電話</span>
                            </label>
                            <label class="radio-label">
                                <input type="radio" name="contact_method" value="メール" <?php echo (isset($input['contact_method']) && $input['contact_method'] === 'メール') ? 'checked' : ''; ?>>
                                <span>メール</span>
                            </label>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">メールアドレス <span class="badge-any">任意</span></label>
                        <div class="input-wrapper">
                            <input type="email" name="email" class="form-control" value="<?php echo isset($input['email']) ? h($input['email']) : ''; ?>" placeholder="例：info@example.com">
                        </div>
                        <p class="form-hint">※メールでの連絡をご希望の場合は必ずご入力ください。</p>
                    </div>

                    <div class="form-group">
                        <label class="form-label">ご相談内容 <span class="badge-required">必須</span></label>
                        <div class="input-wrapper">
                            <textarea name="message" class="form-control" rows="8" placeholder="具体的なご相談内容や、ご希望の工事時期などをご記入ください。" required><?php echo isset($input['message']) ? h($input['message']) : ''; ?></textarea>
                        </div>
                    </div>

                    <div class="form-footer">
                        <button type="submit" class="btn btn-submit">
                            確認画面へ進む
                            <span class="arrow">→</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</main>

<?php include 'partials/footer.php'; ?>
