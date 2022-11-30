<?php
$title = 'GOOD&NEW オンラインショップ';
$is_top = NULL; //トップページの判定(isset)
Session::start();
$flash_message = Session::getFlash(); // フラッシュメッセージの取得
$cart_count = Session::get('cart_count', ""); //カート内のアイテム数を取得
$url = Request::getUrl(); //ページネーション用url
include INCLUDE_DIR . '/user/head.php'; // head.php の読み込み
?>
</head>
<body ontouchstart="">
    <?php include INCLUDE_DIR . '/user/header_fixed.php'; ?>
    <main>
        <section class="area" id="schedule">
            <nav class="page-nav wrapper">
                <span>
                    <a href="<?php echo url_for('schedule', 'index'); ?>">SCHEDULE</a>
                </span>
                <span>&gt;</span>
            </nav><!-- / .page-nav -->
            <div class="box fadeUpTrigger wrapper">
                <h3 class="section-title">SCHEDULE</h3>
                <?php if(count($records['schedule']) > 0) { ?>
                <div class="schedule-list">
                    <?php foreach($records['schedule'] as $record) { ?>
                    <article class="zoomIn">
                        <a href="index.php?module=gallery&action=index&event_id=<?php print h($record->event_id); ?>">
                            <div class="schedule-list-img-area">
                                <figure class="schedule-list-fig">
                                    <span class="clip">
                                        <img src="<?php print h(EVENTS_IMG_DIR . $record -> img1); ?>" alt="イベント画像">
                                    </span>
                                </figure>
                            </div>
                            <div class="schedule-info">
                                <div class="schedule-tag"><?php print h($record->getEventTag()); ?></div>
                                <h4 class="schedule-title"><?php print h($record->event_name); ?></h4>
                                <div class="schedule-date"><?php print h($record->event_date); ?></div>
                            </div>
                        </a>
                    </article>
                    <?php } ?>
                </div><!-- / .schedule-list -->
                <?php } else { ?>
                    <p class="message errors">スケジュール情報がありません。</p>
                <?php } ?>
            </div><!-- /.box .wrapper-->
        </section>
        <?php include INCLUDE_DIR . '/user/pagination.php'; ?>
        <?php include INCLUDE_DIR . '/user/f-nav.php'; ?>
    </main>
    <?php include INCLUDE_DIR . '/user/footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/stickyfill/2.1.0/stickyfill.min.js"></script>
    <script src="./assets/js/user/common.js"></script>
</body>

</html>