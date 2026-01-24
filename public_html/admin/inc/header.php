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

<div class="admin-wrapper">
    <header class="admin-header">
        <h1 class="page-title"><?php echo h($page_title); ?></h1>
        <div style="display:flex; align-items:center;">
            <span class="user-info">
                ログイン中: <strong><?php echo h($_SESSION['admin_username'] ?? 'Admin'); ?></strong> 様
            </span>
            <a href="/admin/logout.php" class="btn-logout">ログアウト</a>
        </div>
    </header>

    <main class="admin-content">
