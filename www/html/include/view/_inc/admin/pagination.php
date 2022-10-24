<!-- 渡ってくる値
$page_id
$paginations['total_record']
$paginations['page_total']
$paginations['prev_page']
$paginations['next_page']
$paginations['page_range']-array
$paginations['from_record']
$paginations['to_record']
 -->
   <div id="home">
      <div class="container">
        <div class="paginations-text">
            <p class="from_to"><?php print h($paginations['total_record']); ?>件中 <?php print h($paginations['from_record']); ?> - <?php print h($paginations['to_record']);?> 件目を表示</p>
        </div>
        <div class="paginations">
            <!-- 戻る -->
            <?php if ($page_id !== 1) { ?>
                <a href="dashboard.php?module=admin_items&action=index&page_id=<?php print h($paginations['prev_page']); ?>" class="page_feed">&laquo;</a>
            <?php } else { ?>
                <span class="first_last_page">&laquo;</span>
            <?php } ?>
            <!-- ページ番号の表示 -->
            <?php foreach ($paginations['page_range'] as $num) { ?>
                <?php if ($num === $page_id) { ?>
                    <span class="now_page_number"><?php print h($num); ?></span>
                <?php } else { ?>
                    <a href="dashboard.php?module=admin_items&action=index&page_id=<?php print h($num); ?>" class="page_number"><?php print h($num); ?></a>
                <?php } ?>
            <?php } ?>
            <!-- 進む -->
            <?php if($page_id < $paginations['page_total']) { ?>
                <a href="dashboard.php?module=admin_items&action=index&page_id=<?php print h($paginations['next_page']); ?>" class="page_feed">&raquo;</a>
            <?php } else { ?>
                <span class="first_last_page">&raquo;</span>
            <?php } ?>
        </div>
      </div>
    </div>