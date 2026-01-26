<?php
// public_html/admin/users/delete.php
require_once '../../config/config.php';
require_login();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validate_csrf_token($_POST['csrf_token'])) die('Invalid Request');

    $id = $_POST['id'] ?? null;
    
    // Prevent self-deletion and ID 1 deletion (Super Admin) - optional policy
    if ($id == $_SESSION['admin_id']) {
        die('自分自身は削除できません。');
    }

    $pdo = get_db_connection();
    $stmt = $pdo->prepare("DELETE FROM admins WHERE id = ?");
    if ($stmt->execute([$id])) {
        header('Location: index.php?msg=deleted');
        exit;
    }
}
header('Location: index.php?error=failed');
?>
