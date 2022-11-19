<?php
$title = 'GOOD&NEW オンラインショップ';
$is_top = NULL; //トップページの判定(isset)
$flash_message = Session::getFlash(); // フラッシュメッセージの取得
$cart_count = Session::get('cart_count', ""); //カート内のアイテム数を取得
include INCLUDE_DIR . '/user/head.php'; // head.php の読み込み
?>
</head>
<body>
    <?php include INCLUDE_DIR . '/user/header_fixed.php'; ?>
    <main>
        <section class="area" id="gallery">
            <?php if(!empty($records['event'])) { ?>
            <nav class="page-nav wrapper">
                <span>
                    <a href="index.php?module=events&action=index&event_id=<?php print h($records['event']->event_id); ?>">GALLERY</a>
                </span>
                <span>&gt;</span>
            </nav><!-- / .page-nav -->
            <div class="box fadeUpTrigger wrapper">
                <h3 class="section-title">GALLERY</h3>
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
                                                        <a href="index.php?module=brands&action=index&brand_id=<?php print h($record->brand_id); ?>">
                                                            <?php print h($record->brand_name); ?>
                                                        </a>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                        <?php } else { ?>
                                            <p class="errors">ブランド情報がありません。</p>
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
                                <li><img src="<?php print h(EVENTS_IMG_DIR . $records['event']->img1); ?>" alt="イベントイメージ"></li>
                                <li><img src="<?php print h(EVENTS_IMG_DIR . $records['event']->img2); ?>" alt="イベントイメージ"></li>
                                <li><img src="<?php print h(EVENTS_IMG_DIR . $records['event']->img3); ?>" alt="イベントイメージ"></li>
                                <li><img src="<?php print h(EVENTS_IMG_DIR . $records['event']->img4); ?>" alt="イベントイメージ"></li>
                                <li><img src="<?php print h(EVENTS_IMG_DIR . $records['event']->img5); ?>" alt="イベントイメージ"></li>
                                <li><img src="<?php print h(EVENTS_IMG_DIR . $records['event']->img6); ?>" alt="イベントイメージ"></li>
                                <li><img src="<?php print h(EVENTS_IMG_DIR . $records['event']->img7); ?>" alt="イベントイメージ"></li>
                                <li><img src="<?php print h(EVENTS_IMG_DIR . $records['event']->img8); ?>" alt="イベントイメージ"></li>
                            </ul>
                            <ul class="choice-btn">
                                <li><img src="<?php print h(EVENTS_IMG_DIR . $records['event']->img1); ?>" alt="イベントイメージ"></li>
                                <li><img src="<?php print h(EVENTS_IMG_DIR . $records['event']->img2); ?>" alt="イベントイメージ"></li>
                                <li><img src="<?php print h(EVENTS_IMG_DIR . $records['event']->img3); ?>" alt="イベントイメージ"></li>
                                <li><img src="<?php print h(EVENTS_IMG_DIR . $records['event']->img4); ?>" alt="イベントイメージ"></li>
                                <li><img src="<?php print h(EVENTS_IMG_DIR . $records['event']->img5); ?>" alt="イベントイメージ"></li>
                                <li><img src="<?php print h(EVENTS_IMG_DIR . $records['event']->img6); ?>" alt="イベントイメージ"></li>
                                <li><img src="<?php print h(EVENTS_IMG_DIR . $records['event']->img7); ?>" alt="イベントイメージ"></li>
                                <li><img src="<?php print h(EVENTS_IMG_DIR . $records['event']->img8); ?>" alt="イベントイメージ"></li>
                            </ul>
                        </div><!--/.gallery-info-->
                    </article>
                </div><!-- / .gallery-content -->
            </div><!-- .box-->
            <?php } else { ?>
                <p class="errors">ギャラリーがありません。</p>
            <?php } ?>
            <div class="basebutton">
                <a href="<?php echo url_for('schedule', 'index'); ?>">
                    <span>スケジュール一覧</span>
                </a>
            </div>
        </section><!-- / #gallery .big-bg -->
        <section class="area" id="f-nav">
            <div class="box fadeUpTrigger content">
                <div class="f-nav-area">
                    <div class="f-nav-list-link">
                        <ul class="link-icon-nav">
                            <li class="icon-instagram"><a href="#" target=”_blank” rel="noopener noreferrer">instagram</a></li>
                            <li class="icon-twitter"><a href="#" target=”_blank” rel="noopener noreferrer">twitter</a></li>
                            <li class="icon-facebook"><a href="#" target=”_blank” rel="noopener noreferrer">facebook</a></li>
                            <li class="icon-youtube"><a href="#" target=”_blank” rel="noopener noreferrer">youtube</a></li>
                            <li class="icon-line"><a href="#" target=”_blank” rel="noopener noreferrer">line</a></li>
                        </ul>
                    </div>
                    <ul class="f-nav-list-main">
                        <li><a href="<?php echo url_for('top', 'index'); ?>">Top</a></li>
                        <li><a href="<?php echo url_for('concept', 'index'); ?>">CONCEPT</a></li>
                        <li><a href="<?php echo url_for('events', 'index'); ?>">EVENT</a></li>
                        <li><a href="<?php echo url_for('schedule', 'index'); ?>">SCHEDULE</a></li>
                        <li><a href="<?php echo url_for('gallery', 'index'); ?>">GALLERY</a></li>
                        <li><a href="#">INFORMATION</a></li>
                    </ul>
                    <ul class="f-nav-list-sub">
                        <li><a href="<?php echo url_for('user', 'signin'); ?>">ログイン&middot;新規登録</a></li>
                        <li><a href="#">配送に関して</a></li>
                        <li><a href="#">ご利用ガイド</a></li>
                        <li><a href="#">プライバシーポリシー</a></li>
                        <li><a href="#">特定商取引に関する表示</a></li>
                        <li><a href="#">お問い合わせ</a></li>
                    </ul>
                </div><!-- / .f-nav-area -->
            </div><!-- /.box .content-->
        </section>
    </main>
    <?php include INCLUDE_DIR . '/user/footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.10.3/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.10.3/ScrollTrigger.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.10.4/TextPlugin.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vivus/0.4.4/vivus.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/stickyfill/2.1.0/stickyfill.min.js"></script>
    <script src="./assets/js/user/common.js"></script>

</body>

</html>