<?php
$page_title = "送信完了";
include 'partials/head.php';
include 'partials/header.php';
?>

<main>
    <div class="section-gray" style="padding: 40px 0;">
        <div class="container text-center">
            <h1>送信完了</h1>
        </div>
    </div>

    <section class="section">
        <div class="container text-center">
            <div style="font-size: 3rem; color: var(--color-primary); margin-bottom: 20px;">✔</div>
            <h2>お問い合わせありがとうございます</h2>
            <p class="mt-20">
                送信が完了しました。<br>
                内容を確認次第、担当者（山本）よりご連絡させていただきます。<br>
                今しばらくお待ちください。
            </p>
            
            <div class="mt-20">
                <a href="index.php" class="btn btn-outline">トップページへ戻る</a>
            </div>
        </div>
    </section>
</main>

<?php include 'partials/footer.php'; ?>
