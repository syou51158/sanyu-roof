<?php
// public_html/admin/index.php
require_once '../config/config.php';
require_login();

$page_title = 'ダッシュボード';
include 'inc/header.php';
?>

<div style="max-width: 1200px; margin: 0 auto;">
    <div style="text-align: center; margin-bottom: 40px;">
        <h2 style="font-size: 1.8rem; margin-bottom: 10px;">山勇ルーフ 管理画面</h2>
        <p style="color: #666;">本日の業務を選択してください。</p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 30px;">
        <!-- Works -->
        <a href="/admin/works/index.php" class="card" style="text-decoration: none; color: inherit; display: block; border-left: 5px solid #007bff; transition: transform 0.2s;">
            <div style="text-align: center;">
                <span style="font-size: 3.5rem; display: block; margin-bottom: 15px;">🏠</span>
                <h3 style="margin: 0 0 10px 0; font-size: 1.3rem;">施工事例の更新</h3>
                <p style="margin: 0; color: #666; font-size: 0.9rem;">新しい工事の実績を追加したり、<br>内容を修正したりします。</p>
            </div>
        </a>

        <!-- Inquiries -->
        <a href="/admin/inquiries/index.php" class="card" style="text-decoration: none; color: inherit; display: block; border-left: 5px solid #28a745; transition: transform 0.2s;">
            <div style="text-align: center;">
                <span style="font-size: 3.5rem; display: block; margin-bottom: 15px;">📬</span>
                <h3 style="margin: 0 0 10px 0; font-size: 1.3rem;">届いたメールを見る</h3>
                <p style="margin: 0; color: #666; font-size: 0.9rem;">お問い合わせ履歴を確認します。<br>ステータス管理も可能です。</p>
            </div>
        </a>

        <!-- News -->
        <a href="/admin/news/index.php" class="card" style="text-decoration: none; color: inherit; display: block; border-left: 5px solid #ffc107; transition: transform 0.2s;">
            <div style="text-align: center;">
                <span style="font-size: 3.5rem; display: block; margin-bottom: 15px;">📢</span>
                <h3 style="margin: 0 0 10px 0; font-size: 1.3rem;">お知らせの投稿</h3>
                <p style="margin: 0; color: #666; font-size: 0.9rem;">「夏季休業」や「キャンペーン」など<br>トップページのニュースを更新します。</p>
            </div>
        </a>

        <!-- Settings -->
        <a href="/admin/settings/index.php" class="card" style="text-decoration: none; color: inherit; display: block; border-left: 5px solid #6c757d; transition: transform 0.2s;">
            <div style="text-align: center;">
                <span style="font-size: 3.5rem; display: block; margin-bottom: 15px;">⚙️</span>
                <h3 style="margin: 0 0 10px 0; font-size: 1.3rem;">会社情報の変更</h3>
                <p style="margin: 0; color: #666; font-size: 0.9rem;">住所・電話番号・メールアドレス等の<br>基本情報を変更します。</p>
            </div>
        </a>

        <!-- Account -->
        <a href="/admin/users/index.php" class="card" style="text-decoration: none; color: inherit; display: block; border-left: 5px solid #17a2b8; transition: transform 0.2s;">
            <div style="text-align: center;">
                <span style="font-size: 3.5rem; display: block; margin-bottom: 15px;">👥</span>
                <h3 style="margin: 0 0 10px 0; font-size: 1.3rem;">アカウント管理</h3>
                <p style="margin: 0; color: #666; font-size: 0.9rem;">新しい管理者の招待や、<br>既存ユーザーの管理を行います。</p>
            </div>
        </a>

        <!-- Profile -->
        <a href="/admin/profile.php" class="card" style="text-decoration: none; color: inherit; display: block; border-left: 5px solid #20c997; transition: transform 0.2s;">
            <div style="text-align: center;">
                <span style="font-size: 3.5rem; display: block; margin-bottom: 15px;">🔒</span>
                <h3 style="margin: 0 0 10px 0; font-size: 1.3rem;">自分の設定</h3>
                <p style="margin: 0; color: #666; font-size: 0.9rem;">自分のパスワードや<br>ログインIDを変更します。</p>
            </div>
        </a>
    </div>
</div>

<style>
    /* Dashboard specific hover effect */
    .card:hover { transform: translateY(-5px); box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15); }
</style>

<?php include 'inc/footer.php'; ?>
