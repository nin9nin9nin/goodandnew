<?php
$title = 'GOOD&NEW オンラインショップ';
$is_top = NULL; //トップページの判定(isset)
Session::start();
$flash_message = Session::getFlash(); // フラッシュメッセージの取得
$cart_count = Session::get('cart_count', ""); //カート内のアイテム数を取得
include INCLUDE_DIR . '/user/head.php'; // head.php の読み込み
?>
</head>
<body>
    <?php include INCLUDE_DIR . '/user/header_fixed.php'; ?>
    <main>
        <section class="area" id="gallery">
            <nav class="page-nav wrapper">
                <span>
                    <a href="index.php?module=schedule&action=index">SCHEDULE</a>
                </span>
                <span>&gt;</span>
                <span>
                    <a href="index.php?module=gallery&action=index&event_id=<?php print h($records['event']->event_id); ?>">GALLERY</a>
                </span>
                <span>&gt;</span>
            </nav><!-- / .page-nav -->
            <div class="box fadeUpTrigger wrapper">
                <h3 class="section-title">GALLERY</h3>
                <?php if(!empty($records['event'])) { ?>
                <div class="gallery-content">
                    <aside>
                        <div class="gallery-info">
                            <div class="event-tag">
                                <?php print h($records['event'] -> getEventTag()); ?>
                            </div>
                            <div class="event-title">
                                <a href="<?php echo url_for('events', 'index'); ?>">
                                    <?php print h($records['event'] -> event_name); ?>
                                </a>
                            </div>
                            <div class="event-date">
                                <span>
                                    <?php print h($records['event'] -> event_date); ?>
                                </span>
                            </div>
                            <div class="event-text">
                                <?php print h($records['event'] -> description); ?>
                            </div>
                            <div class="event-link-btn">
                                <a href="<?php echo url_for('events', 'index', ['event_id' => $records['event']->event_id]); ?>">
                                    <span>Index</span>
                                </a>
                            </div>
                            <ul class="accordion-area">
                                <li>
                                    <div class="accordion-group">
                                        <div class="title">BRANDS</div>
                                        <?php if(count($records['brands']) > 0) { ?>
                                        <div class="list">
                                            <ul>
                                                <?php foreach($records['brands'] as $record) { ?>
                                                    <li>
                                                        <a href="index.php?module=brands&action=index&brand_id=<?php print h($record->brand_id); ?>&event_id=<?php print h($records['event']->event_id); ?>">
                                                            <?php print h($record->brand_name); ?>
                                                        </a>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                        <?php } else { ?>
                                            <p class="message errors">ブランド情報がありません。</p>
                                        <?php } ?>
                                    </div>
                                </li>
                                <li>
                                    <div class="accordion-group">
                                        <div class="title">GOOD&amp;NEW</div>
                                        <div class="list">
                                            <ul>
                                                <li><a href="">オーナーブログ記事へ</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div><!-- .gallery-info -->
                    </aside>
                    <article>
                        <div class="gallery-area">
                            <ul class="gallery">
                                <li class="slider-item <?= $records['event']->img1 ? '' : 'false' ?>"><img src="<?php print h(EVENTS_IMG_DIR . $records['event']->img1); ?>" alt="イベントイメージ"></li>
                                <li class="slider-item <?= $records['event']->img2 ? '' : 'false' ?>"><img src="<?php print h(EVENTS_IMG_DIR . $records['event']->img2); ?>" alt="イベントイメージ"></li>
                                <li class="slider-item <?= $records['event']->img3 ? '' : 'false' ?>"><img src="<?php print h(EVENTS_IMG_DIR . $records['event']->img3); ?>" alt="イベントイメージ"></li>
                                <li class="slider-item <?= $records['event']->img4 ? '' : 'false' ?>"><img src="<?php print h(EVENTS_IMG_DIR . $records['event']->img4); ?>" alt="イベントイメージ"></li>
                                <li class="slider-item <?= $records['event']->img5 ? '' : 'false' ?>"><img src="<?php print h(EVENTS_IMG_DIR . $records['event']->img5); ?>" alt="イベントイメージ"></li>
                                <li class="slider-item <?= $records['event']->img6 ? '' : 'false' ?>"><img src="<?php print h(EVENTS_IMG_DIR . $records['event']->img6); ?>" alt="イベントイメージ"></li>
                                <li class="slider-item <?= $records['event']->img7 ? '' : 'false' ?>"><img src="<?php print h(EVENTS_IMG_DIR . $records['event']->img7); ?>" alt="イベントイメージ"></li>
                                <li class="slider-item <?= $records['event']->img8 ? '' : 'false' ?>"><img src="<?php print h(EVENTS_IMG_DIR . $records['event']->img8); ?>" alt="イベントイメージ"></li>
                            </ul>
                            <ul class="gallery-choice-btn">
                                <li class="slider-item <?= $records['event']->img1 ? '' : 'false' ?>"><img src="<?php print h(EVENTS_IMG_DIR . $records['event']->img1); ?>" alt="イベントイメージ"></li>
                                <li class="slider-item <?= $records['event']->img2 ? '' : 'false' ?>"><img src="<?php print h(EVENTS_IMG_DIR . $records['event']->img2); ?>" alt="イベントイメージ"></li>
                                <li class="slider-item <?= $records['event']->img3 ? '' : 'false' ?>"><img src="<?php print h(EVENTS_IMG_DIR . $records['event']->img3); ?>" alt="イベントイメージ"></li>
                                <li class="slider-item <?= $records['event']->img4 ? '' : 'false' ?>"><img src="<?php print h(EVENTS_IMG_DIR . $records['event']->img4); ?>" alt="イベントイメージ"></li>
                                <li class="slider-item <?= $records['event']->img5 ? '' : 'false' ?>"><img src="<?php print h(EVENTS_IMG_DIR . $records['event']->img5); ?>" alt="イベントイメージ"></li>
                                <li class="slider-item <?= $records['event']->img6 ? '' : 'false' ?>"><img src="<?php print h(EVENTS_IMG_DIR . $records['event']->img6); ?>" alt="イベントイメージ"></li>
                                <li class="slider-item <?= $records['event']->img7 ? '' : 'false' ?>"><img src="<?php print h(EVENTS_IMG_DIR . $records['event']->img7); ?>" alt="イベントイメージ"></li>
                                <li class="slider-item <?= $records['event']->img8 ? '' : 'false' ?>"><img src="<?php print h(EVENTS_IMG_DIR . $records['event']->img8); ?>" alt="イベントイメージ"></li>
                            </ul>
                        </div><!--/.gallery-info-->
                    </article>
                </div><!-- / .gallery-content -->
                <?php } else { ?>
                    <p class="message errors">イベントギャラリーがありません。</p>
                <?php } ?>
                <div class="button-area">
                    <div class="basebutton">
                        <a href="index.php?module=schedule&action=index">
                            <span>SCHEDULE</span>
                        </a>
                    </div>
                </div>
            </div><!-- .box-->
        </section><!-- / #gallery -->
        <?php include INCLUDE_DIR . '/user/f-nav.php'; ?>
    </main>
    <?php include INCLUDE_DIR . '/user/footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/stickyfill/2.1.0/stickyfill.min.js"></script>
    <script src="./assets/js/user/common.js"></script>
</body>

</html>