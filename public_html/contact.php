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
    <div class="section-gray" style="padding: 40px 0;">
        <div class="container text-center">
            <h1>お問い合わせ</h1>
            <p>Contact</p>
        </div>
    </div>

    <section class="section">
        <div class="container">
            <p class="text-center mb-40">
                お急ぎの方は、お電話（<a href="tel:<?php echo str_replace('-', '', COMPANY_PHONE); ?>"><?php echo COMPANY_PHONE; ?></a>）にてご連絡ください。<br>
                フォームからのお問い合わせは、以下の項目にご入力の上、「確認画面へ」ボタンを押してください。
            </p>

            <?php if (!empty($errors)): ?>
                <div class="error-list">
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li>・<?php echo h($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="contact_confirm.php" method="post" style="max-width: 800px; margin: 0 auto;">
                <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                
                <!-- Honeypot (スパム対策) -->
                <div style="display:none;">
                    <label>このフィールドは空のままにしてください</label>
                    <input type="text" name="website_url" value="">
                </div>

                <div class="form-group">
                    <label class="form-label">お名前 <span class="badge-required">必須</span></label>
                    <input type="text" name="name" class="form-control" value="<?php echo isset($input['name']) ? h($input['name']) : ''; ?>" placeholder="例：山田 太郎" required>
                </div>

                <div class="form-group">
                    <label class="form-label">電話番号 <span class="badge-required">必須</span></label>
                    <input type="tel" name="tel" class="form-control" value="<?php echo isset($input['tel']) ? h($input['tel']) : ''; ?>" placeholder="例：090-1234-5678" required>
                </div>

                <div class="form-group">
                    <label class="form-label">地域（市区町村） <span class="badge-required">必須</span></label>
                    <input type="text" name="address" class="form-control" value="<?php echo isset($input['address']) ? h($input['address']) : ''; ?>" placeholder="例：京都市伏見区" required>
                </div>

                <div class="form-group">
                    <label class="form-label">希望連絡方法 <span class="badge-required">必須</span></label>
                    <select name="contact_method" class="form-control">
                        <option value="電話" <?php echo (isset($input['contact_method']) && $input['contact_method'] === '電話') ? 'selected' : ''; ?>>電話</option>
                        <option value="メール" <?php echo (isset($input['contact_method']) && $input['contact_method'] === 'メール') ? 'selected' : ''; ?>>メール</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label">メールアドレス <span style="font-size:0.8rem; color:#666; font-weight:normal;">(メール連絡をご希望の場合は必須)</span></label>
                    <input type="email" name="email" class="form-control" value="<?php echo isset($input['email']) ? h($input['email']) : ''; ?>" placeholder="例：info@example.com">
                </div>

                <div class="form-group">
                    <label class="form-label">ご相談内容 <span class="badge-required">必須</span></label>
                    <textarea name="message" class="form-control" required><?php echo isset($input['message']) ? h($input['message']) : ''; ?></textarea>
                </div>

                <div class="text-center mt-20">
                    <button type="submit" class="btn btn-primary">確認画面へ</button>
                </div>
            </form>
        </div>
    </section>
</main>

<?php include 'partials/footer.php'; ?>
