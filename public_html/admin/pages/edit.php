<?php
// public_html/admin/pages/edit.php
require_once '../../config/config.php';
require_login();

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: index.php');
    exit;
}

$pdo = get_db_connection();
$stmt = $pdo->prepare("SELECT * FROM pages WHERE id = ?");
$stmt->execute([$id]);
$page = $stmt->fetch();

if (!$page) {
    die("ページが見つかりません。");
}

$page_title = 'ページ編集: ' . $page['name'];
$msg = '';

// Content JSON definition (Schema)
// Define which fields are editable for each page slug
$schema = [];
if ($page['slug'] === 'home') {
    $schema = [
        'hero_title' => ['label' => 'メインキャッチコピー (改行はそのまま反映)', 'type' => 'textarea', 'rows' => 3],
        'hero_subtitle' => ['label' => 'サブタイトル', 'type' => 'text'],
        'hero_description' => ['label' => '説明文', 'type' => 'textarea', 'rows' => 4],
        'reason_1_title' => ['label' => '選ばれる理由1: タイトル', 'type' => 'text'],
        'reason_1_text' => ['label' => '選ばれる理由1: 本文', 'type' => 'textarea', 'rows' => 3],
        'reason_2_title' => ['label' => '選ばれる理由2: タイトル', 'type' => 'text'],
        'reason_2_text' => ['label' => '選ばれる理由2: 本文', 'type' => 'textarea', 'rows' => 3],
        'reason_3_title' => ['label' => '選ばれる理由3: タイトル', 'type' => 'text'],
        'reason_3_text' => ['label' => '選ばれる理由3: 本文', 'type' => 'textarea', 'rows' => 3],
        'solar_title' => ['label' => '太陽光セクション: タイトル', 'type' => 'textarea', 'rows' => 2],
        'solar_text' => ['label' => '太陽光セクション: 本文1 (HTML記述可)', 'type' => 'textarea', 'rows' => 4, 'html' => true],
        'solar_text_2' => ['label' => '太陽光セクション: 本文2', 'type' => 'textarea', 'rows' => 3],
    ];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validate_csrf_token($_POST['csrf_token'])) {
        die('CSRF Token Error');
    }

    $title = $_POST['title'];
    $description = $_POST['description'];
    
    // Process content fields
    $current_content = json_decode($page['content'] ?? '{}', true);
    $new_content = [];
    foreach ($schema as $key => $field) {
        if (isset($_POST['content'][$key])) {
            $new_content[$key] = $_POST['content'][$key];
        } else {
            $new_content[$key] = $current_content[$key] ?? '';
        }
    }
    
    $content_json = json_encode($new_content, JSON_UNESCAPED_UNICODE);
    
    $stmt = $pdo->prepare("UPDATE pages SET title = ?, description = ?, content = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
    $stmt->execute([$title, $description, $content_json, $id]);
    
    $msg = "更新しました。";
    
    // Refresh data
    $stmt = $pdo->prepare("SELECT * FROM pages WHERE id = ?");
    $stmt->execute([$id]);
    $page = $stmt->fetch();
}

$content_data = json_decode($page['content'] ?? '{}', true);

include __DIR__ . '/../inc/header.php';
?>

<div class="container">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
        <h2 style="margin:0;">ページ編集: <?php echo h($page['name']); ?></h2>
        <a href="index.php" class="btn btn-outline-secondary">一覧に戻る</a>
    </div>

    <?php if ($msg): ?>
        <div class="alert alert-success"><?php echo h($msg); ?></div>
    <?php endif; ?>

    <form method="post">
        <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
        
        <div class="row" style="display:flex; gap:20px; flex-wrap:wrap;">
            <!-- SEO Settings (Left/Top) -->
            <div style="flex:1; min-width:300px;">
                <div class="card">
                    <h3 class="card-title" style="margin-top:0;">SEO設定 (メタデータ)</h3>
                    
                    <div class="form-group">
                        <label class="form-label">ページのタイトル (&lt;title&gt;)</label>
                        <input type="text" name="title" class="form-control" value="<?php echo h($page['title']); ?>">
                        <p class="form-help">検索結果のタイトルとして表示されます。</p>
                    </div>

                    <div class="form-group">
                        <label class="form-label">ページの説明 (meta description)</label>
                        <textarea name="description" class="form-control" rows="4"><?php echo h($page['description']); ?></textarea>
                        <p class="form-help">検索結果のスニペットとして表示される説明文です。120文字程度が推奨です。</p>
                    </div>
                </div>
            </div>

            <!-- Content Settings (Right/Bottom) -->
            <div style="flex:2; min-width:300px;">
                <div class="card">
                    <h3 class="card-title" style="margin-top:0;">コンテンツ編集</h3>
                    
                    <?php if (empty($schema)): ?>
                        <p>このページには編集可能なコンテンツエリアが定義されていません。</p>
                    <?php else: ?>
                        <?php foreach ($schema as $key => $field): ?>
                            <div class="form-group">
                                <label class="form-label"><?php echo h($field['label']); ?></label>
                                
                                <?php if ($field['type'] === 'textarea'): ?>
                                    <textarea name="content[<?php echo $key; ?>]" class="form-control" rows="<?php echo $field['rows']; ?>"><?php echo isset($field['html']) && $field['html'] ? htmlspecialchars($content_data[$key] ?? '', ENT_QUOTES) : h($content_data[$key] ?? ''); ?></textarea>
                                <?php else: ?>
                                    <input type="text" name="content[<?php echo $key; ?>]" class="form-control" value="<?php echo h($content_data[$key] ?? ''); ?>">
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div style="margin-top: 30px; text-align: center; position: sticky; bottom: 20px; background: rgba(255,255,255,0.9); padding: 15px; border-top: 1px solid #ddd; box-shadow: 0 -2px 10px rgba(0,0,0,0.1);">
            <button type="submit" class="btn btn-primary" style="min-width: 200px; font-size: 1.1rem;">保存する</button>
        </div>
    </form>
</div>

<!-- Simple styling for form help -->
<style>
.form-help {
    font-size: 0.85rem;
    color: #666;
    margin-top: 5px;
}
</style>

<?php include __DIR__ . '/../inc/footer.php'; ?>
