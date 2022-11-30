<?php
$title = 'GOOD&NEW オンラインショップ';
$is_top = true; //トップページの判定(isset)
Session::start();
$flash_message = Session::getFlash(); // フラッシュメッセージの取得
$cart_count = Session::get('cart_count', ""); //カート内のアイテム数を取得
include INCLUDE_DIR . '/user/head.php'; // head.php の読み込み
?>
</head>
<body ontouchstart="">
    <!-- loading 3.5s-->
    <div id="splash">
        <div id="splash_logo">
            <svg version="1.1" id="mask" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="952px" height="84px" viewBox="0 0 952 84" style="enable-background:new 0 0 952 84;" xml:space="preserve">
                <g>
                    <path d="M114,99c0,3.92,0,37.85,0,40-.12,0-6.68,1-19,1-13,0-22.56-.64-32-3a67.07,67.07,0,0,1-21-9c-5.45-3.53-11.32-9.16-14-14s-4-9-4-14a27.47,27.47,0,0,1,4-14c3.81-6.39,8.35-10.21,14-14a74.5,74.5,0,0,1,21-9c10.18-2.68,20.29-3,32-3a141.55,141.55,0,0,1,19,1V76a148.29,148.29,0,0,0-16-1,145.9,145.9,0,0,0-19,1,73,73,0,0,0-20,6,35.43,35.43,0,0,0-10,7,15.67,15.67,0,0,0-5,11c0,1.26,0,5.69,5,11,3,3.17,7.91,6.14,12,8a69.59,69.59,0,0,0,19,5c5.89.62,8.86.83,15,1,0-.31.08-18.91,0-26Z" transform="translate(-24 -59)" />
                    <path d="M240,100c0,22.47-23.79,41-53,41s-53-18.53-53-41,23.79-41,53-41S240,77.53,240,100ZM187,74c-18.54,0-33,11.67-33,26s14.46,26,33,26,33-11.67,33-26S205.54,74,187,74Z" transform="translate(-24 -59)" />
                    <path d="M366,100c0,22.47-23.79,41-53,41s-53-18.53-53-41,23.79-41,53-41S366,77.53,366,100ZM313,74c-18.54,0-33,11.67-33,26s14.46,26,33,26,33-11.67,33-26S331.54,74,313,74Z" transform="translate(-24 -59)" />
                    <path d="M481,100a29.57,29.57,0,0,1-5,17c-2.92,4.5-10.89,11.65-22,16a78.8,78.8,0,0,1-18,5,178.76,178.76,0,0,1-28,2H386V60h19a186,186,0,0,1,29,2,95.9,95.9,0,0,1,20,5,50.87,50.87,0,0,1,18,11A29.66,29.66,0,0,1,481,100Zm-20,0c0-5-1.42-11.48-9-17-6.27-4.57-15-6.14-21-7-8.44-1.21-15.39-1-23-1h-3v50h4c6.86,0,17.31.12,24-1a48,48,0,0,0,11-3,34.17,34.17,0,0,0,12-8A19.4,19.4,0,0,0,461,100Z" transform="translate(-24 -59)" />
                    <path d="M571,131c-7.31,6.72-17.79,10-31,10-22,0-39-11.09-39-25,0-8.17,5.8-16.14,16-21-6.06-5.07-8-9.4-8-15,0-12.42,15.46-21,31-21,14.88,0,27,7,30,16l-18,4c-1.42-4.37-5.84-7-12-7-6.69,0-12,3.62-12,8s7.21,9,18,16l-13,10-3-2c-5.85,2.49-9,6.48-9,11,0,6.93,8.61,13,19,13a25.16,25.16,0,0,0,17-6l-12-8,12-10,44,29-12,10Z" transform="translate(-24 -59)" />
                    <path d="M635,60l57,55V60h19v80H692L635,85v55H616V60Z" transform="translate(-24 -59)" />
                    <path d="M802,60V75H755V92h46v15H755v18h48v15H736V60Z" transform="translate(-24 -59)" />
                    <path d="M837,60l25,49,25-49h20l25,49,25-49h19l-40,80h-8L897,79l-31,61h-8L818,60Z" transform="translate(-24 -59)" />
                </g>
            </svg>
        </div><!--/splash-logo-->
    </div>
    <!---画面遷移用-->
    <div class="splash-bg"></div>
    <header id="header">
        <div class="openbtn1"><span></span><span></span><span></span></div>
        <nav id="g-nav">
            <div id="g-nav-list">
                <div class="g-nav-content">
                    <ul class="g-nav-list-main">
                        <li>
                            <div class="close-btn"></div>
                            <div id="search-wrap">
                                <form role="search" method="get" id="searchform" action="">
                                    <input type="text" value="" name="" id="search-text" placeholder="search">
                                    <input type="submit" id="searchsubmit" value="">
                                </form>
                            </div>
                        </li>
                        <li><a href="<?php echo url_for('top', 'index'); ?>">Top</a></li>
                        <li><a href="<?php echo url_for('concept', 'index'); ?>">CONCEPT</a></li>
                        <li><a href="<?php echo url_for('events', 'index'); ?>">EVENT</a></li>
                        <li><a href="<?php echo url_for('schedule', 'index'); ?>">SCHEDULE</a></li>
                        <li><a href="<?php echo url_for('gallery', 'index'); ?>">GALLERY</a></li>
                        <li><a href="<?php echo url_for('originals', 'index'); ?>">ORIGINALS</a></li>
                    </ul>
                    <div class="g-nav-list-link">
                        <ul class="link-icon-nav">
                            <li class="icon-instagram"><a href="#" target="_blank" rel="noopener noreferrer">instagram</a></li>
                            <li class="icon-twitter"><a href="#" target="_blank" rel="noopener noreferrer">twitter</a></li>
                            <li class="icon-facebook"><a href="#" target="_blank" rel="noopener noreferrer">facebook</a></li>
                            <li class="icon-youtube"><a href="#" target="_blank" rel="noopener noreferrer">youtube</a></li>
                            <li class="icon-line"><a href="#" target="_blank" rel="noopener noreferrer">line</a></li>
                        </ul>
                    </div>
                    <ul class="g-nav-list-sub">
                        <li><a href="<?php echo url_for('users', 'signin'); ?>">ログイン&middot;新規登録</a></li>
                        <li><a href="#">配送に関して</a></li>
                        <li><a href="#">ご利用ガイド</a></li>
                        <li><a href="#">プライバシーポリシー</a></li>
                        <li><a href="#">特定商取引に関する表示</a></li>
                        <li><a href="#">お問い合わせ</a></li>
                    </ul>
                </div><!-- /g-nav-content-->
            </div><!-- /g-nav-list-->
        </nav>
        <div class="logo">
            <a <?php echo isset($is_top) ? '': 'href="index.php"' ?> alt="GOODANDNEW">
                <svg>
                    <use xlink:href="./assets/images/logo/logo.svg#logo"></use>
                </svg>
            </a>
        </div>
        <div id="header-icon">
            <ul class="header-icon-btn">
                <li class="account">
                    <a href="<?php echo url_for('users', 'account'); ?>">
                        <svg>
                            <use xlink:href="./assets/images/icon/account.svg#account"></use>
                        </svg>
                    </a>
                </li>
                <li class="favorite">
                    <a href="<?php echo url_for('favorites', 'index'); ?>">
                        <svg>
                            <use xlink:href="./assets/images/icon/favorite.svg#favorite"></use>
                        </svg>
                    </a>
                </li>
                <li class="shopping-cart">
                    <a href="<?php echo url_for('carts', 'index'); ?>">
                        <span class="cart-count"><?php print h($cart_count); ?></span>
                        <svg>
                            <use xlink:href="./assets/images/icon/shopping-cart.svg#shopping-cart"></use>
                        </svg>
                    </a>
                </li>
            </ul>
        </div>
        <!--フラッシュメッセージ-->
        <?php if ($flash_message !== '') { ?>
            <div class="header-message">
            <p class="flash"><?php echo $flash_message; ?></p>
            </div>
        <?php } ?>
    </header>
    <main>
        <section class="area" id="top">
            <div class="panel" id="top-bg">
                <div class="bb-1">
                    <img src="./assets/images/baby/bb-1.png" alt="image">
                </div>
                <div class="bb-2">
                    <img src="./assets/images/baby/bb-2.png" alt="image">
                </div>
                <div class="bb-3">
                    <img src="./assets/images/baby/bb-3.png" alt="image">
                </div>
                <div class="bb-4">
                    <img src="./assets/images/baby/bb-4.png" alt="image">
                </div>
                <div class="bb-5">
                    <img src="./assets/images/baby/bb-5.png" alt="image">
                </div>
            </div><!-- / .top-bg -->
            <div class="top-title">
                <div class="top-title-layout">
                    <h1 id="top-logo">
                        <img src="./assets/images/logo/logo.svg" alt="goodandnew">
                    </h1>
                    <h2 class="top-text">&Prime;つたえる&Prime;オンラインショップ</h2>
                </div>
            </div><!-- / .top-title -->
            <div class="scrolldown">
                <span>Scroll</span>
            </div><!-- / .scrolldown -->
        </section>
        <section class="area" id="caption">
            <div class="box fadeUpTrigger wrapper">
                <div class="caption-layout">
                    <h2 class="caption-text">
                        毎月変わる、ひと月限定のポップアップショップ。
                        <br>
                        愛せるブランドの伝えたい
                        <br>
                        「いいもの(GOOD)」と「新しい発見(NEW)」
                    </h2>
                </div>
            </div>
        </section>
        <section class="area" id="event">
            <div class="box fadeUpTrigger wrapper">
                <?php if(!empty($records['release_event'])) { ?>
                <div class="event-area">
                    <div class="event-area-layout">
                        <div class="event-month">
                            <svg>
                                <use xlink:href="<?php print h(EVENTS_VISUAL_DIR . $records['release_event']->event_svg) . '#event-tag'; ?>"></use>
                            </svg>
                        </div>
                        <div class="event-image">
                            <img src="<?php print h(EVENTS_VISUAL_DIR . $records['release_event']->event_png); ?>" alt="event_img">
                        </div>
                        <div class="event-lead">
                            <div class="event-tag">
                                <?php print h($records['release_event'] -> getEventTag()); ?>
                            </div>
                            <h3 class="event-title">
                                <a href="index.php?module=events&action=index&event_id=<?php print h($records['release_event']->event_id); ?>">
                                    <?php print h($records['release_event'] -> event_name); ?>
                                </a>
                            </h3>
                            <div class="event-date">
                                <span>
                                    <?php print h($records['release_event'] -> event_date); ?>
                                </span>
                            </div>
                            <p class="event-text">
                                <span>
                                    <?php print h($records['release_event'] -> description); ?>
                                </span>
                            </p>
                            <div class="event-link-btn">
                                <a href="<?php echo url_for('events', 'index', ['event_id' => $records['release_event']->event_id]); ?>">
                                    <span>Index</span>
                                </a>
                            </div>
                        </div>
                    </div><!-- /.event-area-layout-->
                </div><!-- /.event-area-->
                <?php } else { ?>
                    <p class="message errors">公開中イベントがありません。</p>
                <?php } ?>
            </div><!-- /.box-->
            <div class="box fadeUpTrigger">
                <?php if(!empty($records['release_event'])) { ?>
                <div class="top-slider-area">
                    <ul class="top-slider">
                        <li class="slider-item <?= $records['release_event']->img1 ? '' : 'false' ?>"><img src="<?php print h(EVENTS_IMG_DIR . $records['release_event']->img1); ?>" alt="イベントイメージ"></li>
                        <li class="slider-item <?= $records['release_event']->img2 ? '' : 'false' ?>"><img src="<?php print h(EVENTS_IMG_DIR . $records['release_event']->img2); ?>" alt="イベントイメージ"></li>
                        <li class="slider-item <?= $records['release_event']->img3 ? '' : 'false' ?>"><img src="<?php print h(EVENTS_IMG_DIR . $records['release_event']->img3); ?>" alt="イベントイメージ"></li>
                        <li class="slider-item <?= $records['release_event']->img4 ? '' : 'false' ?>"><img src="<?php print h(EVENTS_IMG_DIR . $records['release_event']->img4); ?>" alt="イベントイメージ"></li>
                        <li class="slider-item <?= $records['release_event']->img5 ? '' : 'false' ?>"><img src="<?php print h(EVENTS_IMG_DIR . $records['release_event']->img5); ?>" alt="イベントイメージ"></li>
                        <li class="slider-item <?= $records['release_event']->img6 ? '' : 'false' ?>"><img src="<?php print h(EVENTS_IMG_DIR . $records['release_event']->img6); ?>" alt="イベントイメージ"></li>
                        <li class="slider-item <?= $records['release_event']->img7 ? '' : 'false' ?>"><img src="<?php print h(EVENTS_IMG_DIR . $records['release_event']->img7); ?>" alt="イベントイメージ"></li>
                        <li class="slider-item <?= $records['release_event']->img8 ? '' : 'false' ?>"><img src="<?php print h(EVENTS_IMG_DIR . $records['release_event']->img8); ?>" alt="イベントイメージ"></li>
                    </ul>
                </div>
                <?php } ?>
            </div><!-- /.box-->
        </section>
        <section class="area" id="items">
            <div class="box fadeUpTrigger wrapper">
                <h3 class="section-title">RECOMMEND&nbsp;ITEMS</h3>
                <?php if(count($records['recommend_items']) > 0) { ?>
                <div class="grid">
                    <?php foreach ($records['recommend_items'] as $record) { ?>
                    <div class="item">
                        <div class="bgUD zoomIn item-img">
                            <a href="index.php?module=items&action=detail&item_id=<?php print h($record->item_id); ?>">
                                <span class="mask">
                                    <img src="<?php print h(ITEMS_ICON_DIR . $record -> icon_img); ?>" alt="商品画像">
                                    <span class="cap">
                                        <span class="cap-description">
                                            <?php print h($record->description); ?>
                                        </span>
                                        <span class="cap-stock">在庫数&emsp;<?php print h($record->getStock()); ?></span>
                                    </span>
                                </span>
                            </a>
                        </div>
                        <div class="item-lead">
                            <p class="sub-lead">
                                <a href="index.php?module=brands&action=index&brand_id=<?php print h($record->brand_id); ?>&event_id=<?php print h($records['release_event']->event_id); ?>">
                                    <?php print h($record->brand_name); ?>
                                </a>
                            </p>
                            <p class="main-lead">
                                <a href="index.php?module=items&action=detail&item_id=<?php print h($record->item_id); ?>">
                                    <?php print h($record->item_name); ?>
                                </a>
                            </p>
                            <p class="mid-lead">&yen;<?php print h($record->getPrice()); ?>&nbsp;<span class="tax-in">(TAX&nbsp;IN)</span></p>
                        </div>
                    </div>
                    <?php } ?>
                </div><!-- /.grid -->
                <div class="btn-arrow fadeRightTrigger">
                    <a href="<?php echo url_for('events', 'index', ['event_id' => $records['release_event']->event_id]); ?>" class="btnarrow4">VIEW&nbsp;MORE</a>
                </div><!-- /.btn-arrow -->
                <?php } else { ?>
                    <p class="message errors">アイテム情報がありません。</p>
                <?php } ?>
            </div><!-- /.box .wrapper-->
        </section>
        <section class="area sticky-top" id="brands">
            <div class="box fadeUpTrigger wrapper">
                <h3 class="section-title">BRANDS</h3>
                <?php if(count($records['brands']) > 0) { ?>
                <div class="grid">
                    <?php foreach ($records['brands'] as $record) { ?>
                    <div class="brand">
                        <div class="bgUD zoomIn">
                            <a href="index.php?module=brands&action=index&brand_id=<?php print h($record->brand_id); ?>&event_id=<?php print h($records['release_event']->event_id); ?>">
                                <span class="mask white">
                                    <!--<span class="brand-logo-name">brand_name</span>-->
                                    <span class="brand-logo">
                                        <img src="<?php print h(BRANDS_LOGO_DIR . $record -> brand_logo); ?>" alt="brand_logo">
                                    </span>
                                    <span class="cap">
                                        <span class="cap-description">
                                            <?php print h($record->description); ?>
                                        </span>
                                    </span>
                                </span>
                            </a>
                        </div>
                        <div class="brand-lead">
                            <p class="main-lead">
                                <a href="index.php?module=brands&action=index&brand_id=<?php print h($record->brand_id); ?>&event_id=<?php print h($records['release_event']->event_id); ?>">
                                    <?php print h($record->brand_name); ?>
                                </a>
                            </p>
                        </div>
                    </div>
                    <?php } ?>
                </div><!-- / .grid -->
                <?php } else { ?>
                    <p class="message errors">ブランド情報がありません。</p>
                <?php } ?>
            </div><!-- /.box .wrapper-->
        </section>
        <section class="area" id="schedule">
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
                <div class="btn-arrow fadeRightTrigger">
                    <a href="<?php echo url_for('schedule', 'index'); ?>" class="btnarrow4">VIEW&nbsp;MORE</a>
                </div><!-- / .btn-arrow -->
                <?php } else { ?>
                    <p class="message errors">スケジュール情報がありません。</p>
                <?php } ?>
            </div><!-- /.box .wrapper-->
        </section>
        <section class="area" id="originals">
            <div class="box fadeUpTrigger wrapper">
                <h3 class="section-title">ORIGINALS</h3>
                <?php if(count($records['originals']) > 0) { ?>
                <div class="grid">
                    <?php foreach ($records['originals'] as $record) { ?>
                    <div class="item">
                        <div class="bgUD zoomIn item-img">
                            <a href="index.php?module=items&action=original_detail&item_id=<?php print h($record->item_id); ?>">
                                <span class="mask">
                                    <img src="<?php print h(ITEMS_ICON_DIR . $record -> icon_img); ?>" alt="商品画像">
                                    <span class="cap">
                                        <span class="cap-description">
                                            <?php print h($record->description); ?>
                                        </span>
                                        <span class="cap-stock">在庫数&emsp;<?php print h($record->getStock()); ?></span>
                                    </span>
                                </span>
                            </a>
                        </div>
                        <div class="item-lead">
                            <p class="main-lead">
                                <a href="index.php?module=items&action=original_detail&item_id=<?php print h($record->item_id); ?>"><?php print h($record->item_name); ?></a>
                            </p>
                            <p class="mid-lead">&yen;<?php print h($record->getPrice()); ?>&nbsp;<span class="tax-in">(TAX&nbsp;IN)</span></p>
                        </div>
                    </div>
                    <?php } ?>
                </div><!-- / .grid-->
                <div class="btn-arrow fadeRightTrigger">
                    <a href="<?php echo url_for('originals', 'index'); ?>" class="btnarrow4">VIEW&nbsp;MORE</a>
                </div><!-- / .btn-arrow -->
                <?php } else { ?>
                    <p class="message errors">アイテム情報がありません。</p>
                <?php } ?>
            </div><!-- /.box .wrapper-->
        </section>
        <section class="area" id="information">
            <div class="box fadeUpTrigger content">
                <h3 class="section-title">INFORMATION</h3>
                <div class="information-area">
                    <ul class="information-list">
                        <li>
                            <a href="">
                                <span class="information-list-date">2022.2.18</span>
                                <span class="information-list-title">【重要なお知らせ】当面のご配送日についてお知らせ</span>
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <span class="information-list-date">2021.10.2</span>
                                <span class="information-list-title">【INFO】システムメンテナンスに伴うサービス一時停止のお知らせ</span>
                            </a>
                        </li>
                    </ul>
                </div><!-- / .information-area -->
            </div><!-- /.box .content-->
        </section>
        <?php include INCLUDE_DIR . '/user/f-nav.php'; ?>
    </main>
    <?php include INCLUDE_DIR . '/user/footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.10.3/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.10.3/ScrollTrigger.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.10.4/TextPlugin.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vivus/0.4.4/vivus.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/stickyfill/2.1.0/stickyfill.min.js"></script>
    <script src="./assets/js/user/top.js"></script>
    <script src="./assets/js/user/common.js"></script>
</body>

</html>