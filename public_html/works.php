<?php
$page_title = "施工事例";
include 'partials/head.php';
include 'partials/header.php';
?>

<main>
    <div class="section-gray" style="padding: 40px 0;">
        <div class="container text-center">
            <h1>施工事例</h1>
            <p>Works</p>
        </div>
    </div>

    <section class="section">
        <div class="container">
            <p class="text-center mb-40">当社の施工実績の一部をご紹介します。</p>
            
            <?php
            $pdo = get_db_connection();
            $stmt = $pdo->query("SELECT * FROM works ORDER BY created_at DESC");
            $works = $stmt->fetchAll();
            ?>

            <?php foreach ($works as $work): ?>
                <div class="card">
                    <div class="card-img" style="height: 250px; padding: 0; display: flex; flex-direction: column;">
                         <?php if (!empty($work['image_path'])): ?>
                             <img src="<?php echo h($work['image_path']); ?>" class="lightbox-target" alt="After" style="width: 100%; height: 200px; object-fit: cover;">
                             <?php if (!empty($work['before_image_path'])): ?>
                                 <div style="display: flex; background: #f0f0f0; padding: 5px; align-items: center; height: 50px;">
                                    <span style="font-size: 0.7rem; background: #666; color: white; padding: 2px 6px; border-radius: 3px; margin-right: 5px;">Before</span>
                                    <img src="<?php echo h($work['before_image_path']); ?>" class="lightbox-target" alt="Before" style="height: 100%; width: auto; object-fit: contain;">
                                 </div>
                             <?php else: ?>
                                <div style="height: 50px; background: #f0f0f0;"></div>
                             <?php endif; ?>
                         <?php else: ?>
                            <!-- Image missing placeholder -->
                            <div style="width: 100%; height: 100%; background: #eee; display: flex; align-items: center; justify-content: center; color: #999;">
                                No Image
                            </div>
                         <?php endif; ?>
                    </div>
                    <div class="card-body">
                        <h3 class="card-title"><?php echo h($work['title']); ?></h3>
                        <p class="mb-20"><strong>工事内容：</strong><?php echo h($work['category']); ?></p>
                        <p><?php echo nl2br(h($work['content'])); ?></p>
                        <!-- Admin Edit Link (Optional, visible if logged in?) -->
                        <?php if(isset($_SESSION['admin_id'])): ?>
                            <a href="/admin/works/edit.php?id=<?php echo $work['id']; ?>" style="font-size:0.8rem; color:blue;">[編集]</a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>

            </div>

            <!-- New Section: Detail Report -->
            <div class="mt-40" style="margin-top: 80px;">
                <h2 class="section-title">
                    【Pick Up】板金雨漏り修理 工事レポート
                    <span>CONSTRUCTION REPORT</span>
                </h2>
                <div style="background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                    <p class="mb-20">
                        複雑な形状の屋根部分から雨漏りが発生していた事例です。<br>
                        谷板金の腐食と取り合い部分の劣化が原因でした。詳細な現場状況と、丁寧な補修の様子をご覧ください。
                    </p>
                    <div class="gallery-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 15px;">
                        <?php for($i=1; $i<=10; $i++): 
                            $num = sprintf('%02d', $i);
                        ?>
                        <div class="gallery-item" style="overflow: hidden; border-radius: 4px; border: 1px solid #eee;">
                            <img src="assets/img/works/sheet_metal/<?php echo $num; ?>.jpg" 
                                 class="lightbox-target" 
                                 alt="板金雨漏り修理 工事写真<?php echo $i; ?>" 
                                 style="width: 100%; height: 150px; object-fit: cover; transition: transform 0.3s;">
                        </div>
                        <?php endfor; ?>
                    </div>
                    <p style="margin-top: 15px; font-size: 0.9rem; color: #666; text-align: right;">※画像をクリックすると拡大します</p>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include 'partials/footer.php'; ?>
