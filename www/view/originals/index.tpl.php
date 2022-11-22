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
        <section class="area" id="originals-logo">
            <nav class="page-nav wrapper">
                <span>
                    <a href="index.php?module=originals&action=index">ORIGINALS</a>
                </span>
                <span>&gt;</span>
            </nav>
            <div class="box fadeUpTrigger wrapper">
                <div class="originals-logo">
                    <img src="./assets/images/logo/logo.svg" alt="goodandnew">
                </div>
            </div><!-- /.box-->
        </section>
        <section class="area" id="originals">
            <div class="box fadeUpTrigger wrapper">
                <h3 class="section-title">ORIGINALS</h3>
                <?php if(count($records['originals']) > 0) { ?>
                <div class="grid">
                    <?php foreach ($records['originals'] as $record) { ?>
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
                            <p class="main-lead">
                                <a href="index.php?module=items&action=detail&item_id=<?php print h($record->item_id); ?>"><?php print h($record->item_name); ?></a>
                            </p>
                            <p class="mid-lead">&yen;<?php print h($record->getPrice()); ?>&nbsp;<span class="tax-in">(TAX&nbsp;IN)</span></p>
                        </div>
                    </div>
                    <?php } ?>
                </div><!-- / .grid-->
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