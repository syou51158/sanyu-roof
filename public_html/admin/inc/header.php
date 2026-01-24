<?php
// public_html/admin/inc/header.php
if (!isset($page_title)) $page_title = 'Admin Panel';
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo h($page_title); ?> - 山勇ルーフ管理画面</title>
    <!-- Reset CSS or Normalize could go here -->
    <link rel="stylesheet" href="/admin/css/admin.css?v=<?php echo time(); ?>">
</head>
<body>

<?php include __DIR__ . '/sidebar.php'; ?>
<div class="sidebar-overlay" onclick="toggleSidebar()"></div>

<div class="admin-wrapper">
    <header class="admin-header">
        <button class="menu-toggle" onclick="toggleSidebar()">☰</button>
        <h1 class="page-title"><?php echo h($page_title); ?></h1>
        <div class="user-info">
            <div style="display:flex; align-items:center;">
                <span>
                    ログイン中: <strong><?php echo h($_SESSION['admin_username'] ?? 'Admin'); ?></strong> 様
                </span>
                <a href="/admin/logout.php" class="btn-logout">ログアウト</a>
            </div>
        </div>
        <!-- Mobile Logout (Only visible on mobile via CSS if needed, or rely on sidebar logout) -->
    </header>

    <main class="admin-content">

<script>
function toggleSidebar() {
    const sidebar = document.querySelector('.admin-sidebar');
    const overlay = document.querySelector('.sidebar-overlay');
    sidebar.classList.toggle('active');
    overlay.classList.toggle('active');
}
</script>
