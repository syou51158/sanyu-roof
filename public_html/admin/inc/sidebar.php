<?php
// public_html/admin/inc/sidebar.php
// Determine active menu
$current_uri = $_SERVER['REQUEST_URI'];
function is_active($pattern, $uri) {
    return strpos($uri, $pattern) !== false ? 'active' : '';
}
?>
<nav class="admin-sidebar">
    <a href="/admin/index.php" class="sidebar-brand">
        SANYU ROOF<br><span style="font-size:0.8rem; font-weight:normal;">管理画面</span>
    </a>
    <ul class="sidebar-nav">
        <li>
            <a href="/admin/index.php" class="<?php echo ($current_uri === '/admin/index.php' || $current_uri === '/admin/') ? 'active' : ''; ?>">
                <span class="icon">📊</span> ダッシュボード
            </a>
        </li>
        <li>
            <a href="/admin/works/index.php" class="<?php echo is_active('/admin/works/', $current_uri); ?>">
                <span class="icon">🏠</span> 施工事例の管理
            </a>
        </li>
        <li>
            <a href="/admin/inquiries/index.php" class="<?php echo is_active('/admin/inquiries/', $current_uri); ?>">
                <span class="icon">📬</span> お問い合わせ
            </a>
        </li>
        <li>
            <a href="/admin/news/index.php" class="<?php echo is_active('/admin/news/', $current_uri); ?>">
                <span class="icon">📢</span> お知らせ管理
            </a>
        </li>
        <li>
            <a href="/admin/settings/index.php" class="<?php echo is_active('/admin/settings/', $current_uri); ?>">
                <span class="icon">⚙️</span> 会社情報の変更
            </a>
        </li>
        <li>
            <a href="/admin/profile.php" class="<?php echo is_active('/admin/profile.php', $current_uri); ?>">
                <span class="icon">🔒</span> ID・パスワード変更
            </a>
        </li>
        <li>
            <a href="/" target="_blank">
                <span class="icon">🌐</span> サイトを確認
            </a>
        </li>
    </ul>

    <div style="margin-top: auto; padding: 20px;">
        <a href="/admin/logout.php" style="display:block; text-align:center; padding:10px; border:1px solid rgba(255,255,255,0.2); color:#ccc; border-radius:4px; text-decoration:none; font-size:0.9rem;">
            ログアウト
        </a>
    </div>
</nav>
