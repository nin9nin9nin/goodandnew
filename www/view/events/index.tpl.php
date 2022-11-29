<?php
$title = 'GOOD&NEW オンラインショップ';
$is_top = NULL; //トップページの判定(isset)
Session::start();
$flash_message = Session::getFlash(); // フラッシュメッセージの取得
$cart_count = Session::get('cart_count', ""); //カート内のアイテム数を取得
$search = Request::get('search'); //検索・絞り込みの値
$sorting = Request::get('sorting'); //並べ替えの値
include INCLUDE_DIR . '/user/head.php'; // head.php の読み込み
?>
</head>
<body ontouchstart="">
    <?php include INCLUDE_DIR . '/user/header_fixed.php'; ?>
    <main>
        <section class="area" id="event">
            <nav class="page-nav wrapper">
                <span>
                    <a href="index.php?module=events&action=index&event_id=<?php print h($records['event']->event_id); ?>">EVENT</a>
                </span>
                <span>&gt;</span>
            </nav>
            <div class="box fadeUpTrigger wrapper">
                <?php if(!empty($records['event'])) { ?>
                <div class="event-area">
                    <div class="event-index-image">
                        <img src="<?php print h(EVENTS_VISUAL_DIR . $records['event']->event_png); ?>" alt="event_img">
                    </div>
                    <div class="event-index-lead">
                        <div class="event-tag">
                            <?php print h($records['event'] -> getEventTag()); ?>
                        </div>
                        <h3 class="event-title">
                            <a href="index.php?module=events&action=index&event_id=<?php print h($records['event']->event_id); ?>">
                                <?php print h($records['event'] -> event_name); ?>
                            </a>
                        </h3>
                        <div class="event-date">
                            <span>
                                <?php print h($records['event'] -> event_date); ?>
                            </span>
                        </div>
                        <p class="event-text">
                                <?php print h($records['event'] -> description); ?>
                        </p>
                    </div>
                </div><!-- /.event-area-->
                <?php } else { ?>
                    <p class="message errors">公開中イベントがありません。</p>
                <?php } ?>
            </div><!-- /.box-->
        </section>
        <section class="area" id="props">
            <div class="box fadeUpTrigger content">
                <div class="search-select">
                    <div class="select-list-filter">
                        <form action="index.php" method="get">
                            <table>
                                <tr>
                                    <th class="select-title">
                                        <label for="filter">カテゴリ</label>
                                    </th>
                                    <td class="select-name">
                                        <div class="select-wrap">
                                            <select id="filter" name="search[filter]" ONCHANGE="submit(this.form)">
                                                <option value="">選択してください</option>
                                                <?php foreach($records['categorys'] as $record) { ?>
                                                    <option value="<?php print h($record->category_id); ?>"><?php print h($record->category_name); ?></option>
                                                <?php } ?>
                                        </select>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <input type="hidden" name="module" value="events">
                            <input type="hidden" name="action" value="search">
                            <input type="hidden" name="event_id" value="<?php print h($records['event'] -> event_id); ?>">
                        </form>
                    </div>
                    <div class="select-list-sorting">
                        <form action="index.php" method="get">
                            <table>
                                <tr>
                                    <th class="select-title">
                                        <label for="sorting">並べ替え</label>
                                    </th>
                                    <td class="select-name">
                                        <div class="select-wrap">
                                        <select id="sorting" name="sorting" ONCHANGE="submit(this.form)">
                                            <option value="">選択してください</option>
                                            <option value="0">新着順</option>
                                            <option value="1">価格の安い順</option>
                                            <option value="2">価格の高い順</option>
                                        </select>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <input type="hidden" name="module" value="events">
                            <input type="hidden" name="action" value="sorting">
                            <input type="hidden" name="event_id" value="<?php print h($records['event'] -> event_id); ?>">
                        </form>
                    </div>
                </div><!-- / .search-select -->
                <div class="pagelink-list">
                    <ul id="in-page-link">
                        <li>
                            <a class="arrow" href="#items">ITEMS</a>
                        </li>
                        <li>
                            <a class="arrow" href="#brands">BRANDS</a>
                        </li>
                        <li>
                            <a class="arrow" href="#originals">ORIGINALS</a>
                        </li>
                    </ul>
                </div><!-- / .pagelink-list -->
            </div><!-- .box .fadeupTrigger #props-->
        </section>
        <section class="area" id="items">
            <div class="box fadeUpTrigger wrapper">
                <h3 class="section-title">ITEMS</h3>
                <?php if(count($records['items']) > 0) { ?>
                <div class="grid">
                    <?php foreach ($records['items'] as $record) { ?>
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
                                <a href="index.php?module=brands&action=index&brand_id=<?php print h($record->brand_id); ?>&event_id=<?php print h($records['event']->event_id); ?>">
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
                <?php } else { ?>
                    <p class="message errors">アイテム情報がありません。</p>
                <?php } ?>
            </div><!-- /.box .wrapper-->
        </section>
        <section class="area" id="brands">
            <div class="box fadeUpTrigger wrapper">
                <h3 class="section-title">BRANDS</h3>
                <?php if(count($records['brands']) > 0) { ?>
                <div class="grid">
                    <?php foreach ($records['brands'] as $record) { ?>
                    <div class="brand">
                        <div class="bgUD zoomIn">
                            <a href="index.php?module=brands&action=index&brand_id=<?php print h($record->brand_id); ?>&event_id=<?php print h($records['event']->event_id); ?>">
                                <span class="mask white">
                                    <!--<span class="brand-logo-name">brand_name</span>-->
                                    <span class="brand-logo">
                                        <img src="<?php print h(BRANDS_LOGO_DIR . $record -> brand_logo); ?>" alt="<?php print h($record->brand_name); ?>">
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
                                <a href="index.php?module=brands&action=index&brand_id=<?php print h($record->brand_id); ?>&event_id=<?php print h($records['event']->event_id); ?>">
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
        <?php include INCLUDE_DIR . '/user/f-nav.php'; ?>
    </main>
    <?php include INCLUDE_DIR . '/user/footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/stickyfill/2.1.0/stickyfill.min.js"></script>
    <script src="./assets/js/user/common.js"></script>
</body>

</html>