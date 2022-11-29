<?php
$title = 'GOOD&NEW オンラインショップ';
$is_top = NULL; //トップページの判定(isset)
Session::start();
$flash_message = Session::getFlash(); // フラッシュメッセージの取得
$cart_count = Session::get('cart_count', ""); //カート内のアイテム数を取得
$token = Session::getCsrfToken(); // トークンの取得
include INCLUDE_DIR . '/user/head.php'; // head.php の読み込み
?>
</head>
<body>
    <?php include INCLUDE_DIR . '/user/header_fixed.php'; ?>
    <main>
        <section class="area" id="detail">
            <nav class="page-nav wrapper">
                <span>
                    <a href="<?php echo url_for('originals', 'index'); ?>">ORIGINALS</a>
                </span>
                <span>&gt;</span>
                <span>
                    <a href="index.php?module=items&action=original_detail&item_id=<?php print h($records['item']->item_id); ?>">ITEM_DETAIL</a>
                </span>
                <span>&gt;</span>
            </nav>
            <div class="box fadeUpTrigger wrapper">
                <?php if(!empty($records['item'])) { ?>
                    <div class="item-info">
                    <div id="fixed-area"><!--左固定エリア-->
                        <div class="item-photo-area">
                            <ul class="item-photo">
                                <li class="slider-item <?= $records['item']->img1 ? '' : 'false' ?>"><img src="<?php print h(ITEMS_IMG_DIR . $records['item']->img1); ?>" alt="アイテム画像"></li>
                                <li class="slider-item <?= $records['item']->img2 ? '' : 'false' ?>"><img src="<?php print h(ITEMS_IMG_DIR . $records['item']->img2); ?>" alt="アイテム画像"></li>
                                <li class="slider-item <?= $records['item']->img3 ? '' : 'false' ?>"><img src="<?php print h(ITEMS_IMG_DIR . $records['item']->img3); ?>" alt="アイテム画像"></li>
                                <li class="slider-item <?= $records['item']->img4 ? '' : 'false' ?>"><img src="<?php print h(ITEMS_IMG_DIR . $records['item']->img4); ?>" alt="アイテム画像"></li>
                                <li class="slider-item <?= $records['item']->img5 ? '' : 'false' ?>"><img src="<?php print h(ITEMS_IMG_DIR . $records['item']->img5); ?>" alt="アイテム画像"></li>
                                <li class="slider-item <?= $records['item']->img6 ? '' : 'false' ?>"><img src="<?php print h(ITEMS_IMG_DIR . $records['item']->img6); ?>" alt="アイテム画像"></li>
                                <li class="slider-item <?= $records['item']->img7 ? '' : 'false' ?>"><img src="<?php print h(ITEMS_IMG_DIR . $records['item']->img7); ?>" alt="アイテム画像"></li>
                                <li class="slider-item <?= $records['item']->img8 ? '' : 'false' ?>"><img src="<?php print h(ITEMS_IMG_DIR . $records['item']->img8); ?>" alt="アイテム画像"></li>
                            </ul>
                            <ul class="item-photo-choice-btn">
                                <li class="slider-item <?= $records['item']->img1 ? '' : 'false' ?>"><img src="<?php print h(ITEMS_IMG_DIR . $records['item']->img1); ?>" alt="アイテム画像"></li>
                                <li class="slider-item <?= $records['item']->img2 ? '' : 'false' ?>"><img src="<?php print h(ITEMS_IMG_DIR . $records['item']->img2); ?>" alt="アイテム画像"></li>
                                <li class="slider-item <?= $records['item']->img3 ? '' : 'false' ?>"><img src="<?php print h(ITEMS_IMG_DIR . $records['item']->img3); ?>" alt="アイテム画像"></li>
                                <li class="slider-item <?= $records['item']->img4 ? '' : 'false' ?>"><img src="<?php print h(ITEMS_IMG_DIR . $records['item']->img4); ?>" alt="アイテム画像"></li>
                                <li class="slider-item <?= $records['item']->img5 ? '' : 'false' ?>"><img src="<?php print h(ITEMS_IMG_DIR . $records['item']->img5); ?>" alt="アイテム画像"></li>
                                <li class="slider-item <?= $records['item']->img6 ? '' : 'false' ?>"><img src="<?php print h(ITEMS_IMG_DIR . $records['item']->img6); ?>" alt="アイテム画像"></li>
                                <li class="slider-item <?= $records['item']->img7 ? '' : 'false' ?>"><img src="<?php print h(ITEMS_IMG_DIR . $records['item']->img7); ?>" alt="アイテム画像"></li>
                                <li class="slider-item <?= $records['item']->img8 ? '' : 'false' ?>"><img src="<?php print h(ITEMS_IMG_DIR . $records['item']->img8); ?>" alt="アイテム画像"></li>
                            </ul>
                        </div>
                    </div><!--/fixed-area-->
                    <div id="container"><!--右エリア-->
                        <div class="box fadeUpTrigger">
                            <div class="right-section">
                                <div class="item-detail">
                                    <div class="detail-lead">
                                        <p class="detail-brand"><?php print h($records['item']->brand_name); ?></p>
                                        <p class="detail-name"><?php print h($records['item']->item_name); ?></p>
                                        <p class="detail-price">&yen;<?php print h($records['item']->getPrice()); ?>&nbsp;<span class="tax-in">(TAX&nbsp;IN)</span></p>
                                        <div class="detail-stock">
                                            <p class="<?= $records['item']->stock ? 'true' : 'false' ?>">在庫数&emsp;<?php print h($records['item']->getStock()); ?></p>
                                        </div>
                                    </div>
                                    <div class="buttonwrap">
                                        <div class="cart-button">
                                            <form action="index.php" method="post">
                                              <input type="submit" value="ADD TO CART">
                                              <input type="hidden" name="module" value="carts">
                                              <input type="hidden" name="action" value="add">
                                              <input type="hidden" name="item_id" value="<?php print h($records['item']->item_id); ?>">
                                              <input type="hidden" name="token" value="<?=h($token)?>">
                                            </form>
                                        </div><!-- / .cart-button -->
                                    </div><!-- / .buttonwrap -->
                                    <div class="group">
                                        <p class="group-description">アイテム説明</br><?php print h($records['item']->description); ?></p>
                                        <p class="group-category">カテゴリ&nbsp;:&nbsp;<?php print h($records['item']->category_name); ?></p>
                                    </div>
                                </div><!-- /.item-detail アイテム詳細-->
                            </div>
                        </div><!-- /.box fadeUpTrigger -->
                    </div><!-- / .container -->
                </div><!-- / .item-info -->
                <?php } else { ?>
                    <p class="message errors">アイテム情報がありません。</p>
                <?php } ?>
                <div class="button-area">
                    <div class="basebutton">
                        <a href="<?php echo url_for('originals', 'index'); ?>">
                            <span>ORIGINALS</span>
                        </a>
                    </div>
                </div>
            </div><!-- / .box -->
        </section><!-- / #detail  -->
    </main>
    <?php include INCLUDE_DIR . '/user/footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/stickyfill/2.1.0/stickyfill.min.js"></script>
    <script src="./assets/js/user/common.js"></script>
</body>

</html>