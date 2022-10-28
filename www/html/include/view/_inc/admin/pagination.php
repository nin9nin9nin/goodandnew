   <div id="paginations">
      <div class="container">
        <div class="paginations-text">
            <p class="from_to"><?php print h($paginations['total_record']); ?>件中 <?php print h($paginations['from_record']); ?> - <?php print h($paginations['to_record']);?> 件目を表示</p>
        </div>
        <div class="paginations">
            <!-- 戻る -->
            <?php if ($paginations['page_id'] !== 1) { ?>
                <a href="dashboard.php?module=admin_events&action=index&page_id=<?php print h($paginations['prev_page']); ?>" class="page_feed">&laquo;</a>
            <?php } else { ?>
                <!-- <span class="first_last_page">&laquo;</span> -->
            <?php } ?>
            <!-- ページ番号の表示 -->
            <?php foreach ($paginations['page_range'] as $num) { ?>
                <?php if ($num === $paginations['page_id']) { ?>
                    <span class="now_page_number"><?php print h($num); ?></span>
                <?php } else { ?>
                    <a href="dashboard.php?module=admin_events&action=index&page_id=<?php print h($num); ?>" class="page_number"><?php print h($num); ?></a>
                <?php } ?>
            <?php } ?>
            <!-- 進む -->
            <?php if($paginations['page_id'] < $paginations['page_total']) { ?>
                <a href="dashboard.php?module=admin_events&action=index&page_id=<?php print h($paginations['next_page']); ?>" class="page_feed">&raquo;</a>
            <?php } else { ?>
                <!-- <span class="first_last_page">&raquo;</span> -->
            <?php } ?>
        </div>
      </div>
    </div>