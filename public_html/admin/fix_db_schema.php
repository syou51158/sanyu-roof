<?php
// public_html/admin/fix_db_schema.php
// データベースのカラム不足を解消するスクリプト

// エラー表示を有効化
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once '../config/config.php';

echo "<h1>データベース修復ツール</h1>";

try {
    $pdo = get_db_connection();
    if (!$pdo) {
        throw new Exception("データベースに接続できませんでした。");
    }
    echo "<p>データベース接続: OK</p>";

    // adminsテーブルの情報を取得
    $stmt = $pdo->query("PRAGMA table_info(admins)");
    $columns = $stmt->fetchAll(PDO::FETCH_COLUMN, 1); // column name is index 1

    echo "<p>現在のカラム: " . implode(', ', $columns) . "</p>";

    $needed_columns = [
        'email' => 'TEXT',
        'reset_token' => 'TEXT',
        'token_expires_at' => 'TEXT' // SQLite stores DATETIME as TEXT/NUMERIC
    ];

    $added = [];
    foreach ($needed_columns as $col => $type) {
        if (!in_array($col, $columns)) {
            echo "<p>カラム '{$col}' が見つかりません。追加します...</p>";
            $sql = "ALTER TABLE admins ADD COLUMN {$col} {$type}";
            $pdo->exec($sql);
            $added[] = $col;
        } else {
            echo "<p>カラム '{$col}' は既に存在します。</p>";
        }
    }

    if (!empty($added)) {
        echo "<div style='color:green; font-weight:bold;'>以下のカラムを追加しました: " . implode(', ', $added) . "</div>";
        echo "<p>修復が完了しました。この画面を閉じて、管理者招待を再度お試しください。</p>";
    } else {
        echo "<div style='color:blue;'>追加が必要なカラムはありませんでした。データベースは正常です。</div>";
    }

    // ついでに admins テーブルの中身を確認（パスワードは隠す）
    echo "<h3>現在の管理者データ確認</h3>";
    $stmt = $pdo->query("SELECT id, username, email FROM admins");
    $rows = $stmt->fetchAll();
    echo "<table border='1' cellpadding='5'><tr><th>ID</th><th>Username</th><th>Email</th></tr>";
    foreach ($rows as $r) {
        echo "<tr>";
        echo "<td>" . h($r['id']) . "</td>";
        echo "<td>" . h($r['username']) . "</td>";
        echo "<td>" . h($r['email']) . "</td>";
        echo "</tr>";
    }
    echo "</table>";

} catch (Exception $e) {
    echo "<div style='color:red; font-weight:bold;'>エラーが発生しました: " . h($e->getMessage()) . "</div>";
    echo "<pre>" . h($e->getTraceAsString()) . "</pre>";
}
?>
