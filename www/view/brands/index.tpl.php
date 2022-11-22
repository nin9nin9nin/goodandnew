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
<body>
    <?php include INCLUDE_DIR . '/user/header_fixed.php'; ?>
    <main>
        <section class="area" id="brands">
            <nav class="page-nav wrapper">
                <span>
                    <a href="index.php?module=events&action=index&event_id=<?php print h($records['event']->event_id); ?>">EVENT</a>
                </span>
                <span>&gt;</span>
                <span>
                    <a href="index.php?module=brands&action=index&brand_id=<?php print h($records['brand']->brand_id); ?>&event_id=<?php print h($records['event']->event_id); ?>">BRANDS</a>
                </span>
                <span>&gt;</span>
            </nav>
            <div class="box fadeUpTrigger wrapper">
                <?php if(!empty($records['brand'])) { ?>
                <div class="brand-info">
                    <div id="fixed-area"><!--左エリア-->
                        <div class="brand-image white">
                            <!-- <img class="brand-logo" src="" alt="brand_logo"> -->
                            <ul class="brand-image-slider">
                                <li class="slider-item"><img src="<?php print h(BRANDS_IMG_DIR . $records['brand'] -> img1); ?>" alt="ブランド画像"></li>
                                <li class="slider-item"><img src="<?php print h(BRANDS_IMG_DIR . $records['brand'] -> img2); ?>" alt="ブランド画像"></li>
                                <li class="slider-item"><img src="<?php print h(BRANDS_IMG_DIR . $records['brand'] -> img3); ?>" alt="ブランド画像"></li>
                                <li class="slider-item"><img src="<?php print h(BRANDS_IMG_DIR . $records['brand'] -> img4); ?>" alt="ブランド画像"></li>
                                <li class="slider-item"><img src="<?php print h(BRANDS_IMG_DIR . $records['brand'] -> img5); ?>" alt="ブランド画像"></li>
                                <li class="slider-item"><img src="<?php print h(BRANDS_IMG_DIR . $records['brand'] -> img6); ?>" alt="ブランド画像"></li>
                                <li class="slider-item"><img src="<?php print h(BRANDS_IMG_DIR . $records['brand'] -> img7); ?>" alt="ブランド画像"></li>
                                <li class="slider-item"><img src="<?php print h(BRANDS_IMG_DIR . $records['brand'] -> img8); ?>" alt="ブランド画像"></li>
                            </ul>
                        </div>
                    </div><!--/.flex-area-->
                    <div id="container"><!--右エリア-->
                        <div class="brand-detail">
                            <div class="detail-lead">
                                <div class="detail-name">
                                    <?php print h($records['brand'] -> brand_name); ?>
                                </div>
                            </div>
                            <div class="group">
                                <p class="group-description"><?php print h($records['brand'] -> description); ?></p>
                                <p class="group-hp"><a href="#" target="_blank" rel="noopener noreferrer"><?php print h($records['brand'] -> brand_hp); ?></a></p>
                                <div class="group-link">
                                    <ul class="link-icon-nav">
                                    <?php if (!empty($records['brand'] -> brand_instagram)) { ?>
                                        <li class="icon-instagram"><a href="<?php print h($records['brand'] -> brand_instagram); ?>" target="_blank" rel="noopener noreferrer">instagram</a></li>
                                    <?php } ?> 
                                    <?php if (!empty($records['brand'] -> brand_twitter)) { ?>
                                        <li class="icon-twitter"><a href="<?php print h($records['brand'] -> brand_twitter); ?>" target="_blank" rel="noopener noreferrer">twitter</a></li>  
                                    <?php } ?> 
                                    <?php if (!empty($records['brand'] -> brand_facebook)) { ?>
                                        <li class="icon-facebook"><a href="<?php print h($records['brand'] -> brand_facebook); ?>" target="_blank" rel="noopener noreferrer">facebook</a></li>  
                                    <?php } ?> 
                                    <?php if (!empty($records['brand'] -> brand_youtube)) { ?>
                                        <li class="icon-youtube"><a href="<?php print h($records['brand'] -> brand_youtube); ?>" target="_blank" rel="noopener noreferrer">youtube</a></li>
                                    <?php } ?> 
                                    <?php if (!empty($records['brand'] -> brand_line)) { ?>
                                        <li class="icon-line"><a href="<?php print h($records['brand'] -> brand_line); ?>" target="_blank" rel="noopener noreferrer">line</a></li>
                                    <?php } ?> 
                                    </ul>
                                </div>
                                <p class="group-address"><?php print h($records['brand'] -> address); ?></p>
                                <p class="group-phone_number"><?php print h($records['brand'] -> phone_number); ?></p>
                                <p class="group-email"><?php print h($records['brand'] -> email); ?></p>
                            </div><!--/.group　ブランド詳細-->
                        </div>
                    </div><!-- / .container -->
                </div><!-- / .brand-info -->
                <?php } else { ?>
                    <p class="errors">ブランド情報がありません。</p>
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
                            <input type="hidden" name="module" value="brands">
                            <input type="hidden" name="action" value="search">
                            <input type="hidden" name="event_id" value="<?php print h($records['event'] -> event_id); ?>">
                            <input type="hidden" name="brand_id" value="<?php print h($records['brand'] -> brand_id); ?>">
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
                            <input type="hidden" name="module" value="brands">
                            <input type="hidden" name="action" value="sorting">
                            <input type="hidden" name="event_id" value="<?php print h($records['event'] -> event_id); ?>">
                            <input type="hidden" name="brand_id" value="<?php print h($records['brand'] -> brand_id); ?>">
                        </form>
                    </div>
                </div><!-- / .search-select -->
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
                    <p class="errors">アイテム情報がありません。</p>
                <?php } ?>
                <div class="button-area">
                    <div class="basebutton">
                        <a href="index.php?module=events&action=index&event_id=<?php print h($records['event']->event_id); ?>">
                            <span>EVENT</span>
                        </a>
                    </div>
                </div>
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