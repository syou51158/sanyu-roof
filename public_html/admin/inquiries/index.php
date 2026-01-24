<?php
// public_html/admin/inquiries/index.php
require_once '../../config/config.php';
require_login();

$pdo = get_db_connection();
$stmt = $pdo->query("SELECT * FROM inquiries ORDER BY created_at DESC");
$inquiries = $stmt->fetchAll();

$page_title = 'お問い合わせ履歴';
include __DIR__ . '/../inc/header.php';
?>

<div class="card" style="padding: 0; overflow: hidden;">
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 50px;">ID</th>
                <th style="width: 100px;">状態</th>
                <th style="width: 140px;">日時</th>
                <th style="width: 150px;">お名前</th>
                <th>内容（抜粋）</th>
                <th style="width: 80px;">操作</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($inquiries as $row): ?>
            <?php 
                $status = $row['status'] ?? '未対応';
                $status_bg = '#6c757d'; // Default gray
                if ($status === '未対応') $status_bg = '#dc3545';
                elseif ($status === '対応中') $status_bg = '#17a2b8';
                elseif ($status === '完了') $status_bg = '#28a745';
            ?>
            <tr>
                <td><?php echo h($row['id']); ?></td>
                <td>
                    <span style="display:inline-block; padding: 4px 8px; border-radius: 12px; color: #fff; font-size: 0.8rem; background-color: <?php echo $status_bg; ?>;">
                        <?php echo h($status); ?>
                    </span>
                </td>
                <td><?php echo h(date('Y/m/d H:i', strtotime($row['created_at']))); ?></td>
                <td><?php echo h($row['name']); ?></td>
                <td><?php echo h(mb_strimwidth($row['message'], 0, 50, '...')); ?></td>
                <td>
                    <a href="/admin/inquiries/detail.php?id=<?php echo h($row['id']); ?>" class="btn btn-primary" style="padding: 5px 10px; font-size: 0.85rem;">詳細</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include __DIR__ . '/../inc/footer.php'; ?>
