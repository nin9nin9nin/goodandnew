<?php
$title = 'GOOD&NEW オンラインショップ';
$is_top = NULL; //トップページの判定(isset)
Session::start();
$flash_message = Session::getFlash(); // フラッシュメッセージの取得
$token = Session::getCsrfToken(); // トークンの取得
$cart_count = Session::get('cart_count', ""); //カート内のアイテム数を取得
include INCLUDE_DIR . '/user/head.php'; // head.php の読み込み
?>
</head>
<body>
    <?php include INCLUDE_DIR . '/user/header_fixed.php'; ?>
    <main>
        <section class="area" id="favorites">
            <nav class="page-nav wrapper">
                <span>
                    <a href="index.php?module=favorites&action=index">FAVORITES</a>
                </span>
                <span>&gt;</span>
            </nav>
            <div class="box fadeUpTrigger wrapper">
                <h3 class="section-title">FAVORITES</h3>
                <?php if(count($records['favorites']) > 0) { ?>
                <div class="grid">
                    <?php foreach ($records['favorites'] as $record) { ?>
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
                        <div class="item-lead favorite-black-button">
                            <p class="sub-lead">
                                <a href="index.php?module=brands&action=index&brand_id=<?php print h($record->brand_id); ?>&event_id=<?php print h($record->event_id); ?>">
                                    <?php print h($record->brand_name); ?>
                                </a>
                            </p>
                            <p class="main-lead">
                                <a href="index.php?module=items&action=detail&item_id=<?php print h($record->item_id); ?>"><?php print h($record->item_name); ?></a>
                            </p>
                            <p class="mid-lead">&yen;<?php print h($record->getPrice()); ?>&nbsp;<span class="tax-in">(TAX&nbsp;IN)</span></p>
                            <form action="index.php" method="post">
                                <label for="favorite">
                                    <input id="favorite" type="submit" style="display: none">
                                    <svg>
                                        <use xlink:href="./assets/images/icon/favorite-black.svg#favorite-black"></use>
                                    </svg>
                                </label>
                                <input type="hidden" name="module" value="favorites">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="favorite_id" value="<?php print h($record->favorite_id); ?>">
                                <input type="hidden" name="token" value="<?=h($token)?>">
                            </form>
                        </div>
                    </div>
                    <?php } ?>
                </div><!-- / .grid-->
                <?php } else { ?>
                    <p class="message errors">お気に入り情報がありません。</p>
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