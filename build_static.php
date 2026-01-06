<?php
// build_static.php
// PHPファイルを静的HTMLに変換して docs/ フォルダに出力するスクリプト
// GitHub Pages公開用

// 設定
define('SRC_DIR', __DIR__ . '/public_html');
define('DEST_DIR', __DIR__ . '/docs');

// 出力ディレクトリ作成
if (!file_exists(DEST_DIR)) {
    mkdir(DEST_DIR, 0755, true);
}
if (!file_exists(DEST_DIR . '/assets')) {
    mkdir(DEST_DIR . '/assets', 0755, true);
}

// 再帰的にコピーする関数
function copy_recursive($src, $dst) {
    $dir = opendir($src);
    @mkdir($dst);
    while (false !== ($file = readdir($dir))) {
        if (($file != '.') && ($file != '..')) {
            if (is_dir($src . '/' . $file)) {
                copy_recursive($src . '/' . $file, $dst . '/' . $file);
            } else {
                copy($src . '/' . $file, $dst . '/' . $file);
            }
        }
    }
    closedir($dir);
}

// Assetsをコピー
copy_recursive(SRC_DIR . '/assets', DEST_DIR . '/assets');

// PHPファイルをHTMLに変換
$files = [
    'index.php',
    'services.php',
    'works.php',
    'about.php',
    'contact.php',
    'thanks.php'
];

// config読み込みのためにカレントディレクトリ変更
chdir(SRC_DIR);

foreach ($files as $file) {
    ob_start();
    // 擬似的にリクエスト変数をセット（必要であれば）
    $_SERVER['REQUEST_URI'] = '/' . $file;
    $_SERVER['HTTP_HOST'] = 'syou51158.github.io/sanyu-roof'; // GitHub Pages用URL
    
    // インクルード実行
    include $file;
    
    $content = ob_get_clean();
    
    // リンクの置換 (.php -> .html)
    $content = str_replace('.php"', '.html"', $content);
    $content = str_replace('.php\'', '.html\'', $content);
    
    // フォームのアクション無効化と注記追加
    if ($file === 'contact.php') {
        $notice = '<div style="background:#ffcccc; color:#d00; padding:10px; text-align:center; font-weight:bold; margin-bottom:10px;">※これはGitHub Pages上のデモです。メール送信機能は動作しません。</div>';
        $content = str_replace('<form', $notice . '<form onsubmit="alert(\'デモ画面のため送信できません\'); return false;"', $content);
    }
    
    // パスの調整（もし必要なら）
    // GitHub Pagesがサブディレクトリ(/sanyu-roof/)の場合、絶対パスだと崩れる可能性があるが、
    // 今回のコードは相対パス(assets/...)を使っているので基本大丈夫。
    // canonicalなどの絶対URLは置換する
    $content = str_replace('http://syou51158.github.io/sanyu-roof', 'https://syou51158.github.io/sanyu-roof', $content);

    // HTMLとして保存
    $html_file = str_replace('.php', '.html', $file);
    file_put_contents(DEST_DIR . '/' . $html_file, $content);
    
    echo "Converted: $file -> docs/$html_file\n";
}

echo "Build complete. Contents are in docs/ folder.\n";
?>