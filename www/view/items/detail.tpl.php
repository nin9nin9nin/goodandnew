<?php
$title = 'GOOD&NEW オンラインショップ';
$is_top = true; //トップページの判定(isset)
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
                    <a href="index.php?module=events&action=index&event_id=<?php print h($records['event']->event_id); ?>">EVENT</a>
                </span>
                <span>&gt;</span>
                <span>
                    <a href="index.php?module=items&action=detail&item_id=<?php print h($records['item']->item_id); ?>">ITEM_DETAIL</a>
                </span>
                <span>&gt;</span>
            </nav>
            <div class="box fadeUpTrigger wrapper">
                <?php if(!empty($records['item'])) { ?>
                    <div class="item-info">
                    <div id="fixed-area"><!--左固定エリア-->
                        <div class="item-photo-area">
                            <ul class="gallery">
                                <li><img src="<?php print h(ITEMS_IMG_DIR . $records['item']->img1); ?>" alt="アイテム画像"></li>
                                <li><img src="<?php print h(ITEMS_IMG_DIR . $records['item']->img2); ?>" alt="アイテム画像"></li>
                                <li><img src="<?php print h(ITEMS_IMG_DIR . $records['item']->img3); ?>" alt="アイテム画像"></li>
                                <li><img src="<?php print h(ITEMS_IMG_DIR . $records['item']->img4); ?>" alt="アイテム画像"></li>
                                <li><img src="<?php print h(ITEMS_IMG_DIR . $records['item']->img5); ?>" alt="アイテム画像"></li>
                                <li><img src="<?php print h(ITEMS_IMG_DIR . $records['item']->img6); ?>" alt="アイテム画像"></li>
                                <li><img src="<?php print h(ITEMS_IMG_DIR . $records['item']->img7); ?>" alt="アイテム画像"></li>
                                <li><img src="<?php print h(ITEMS_IMG_DIR . $records['item']->img8); ?>" alt="アイテム画像"></li>
                            </ul>
                            <ul class="choice-btn">
                                <li><img src="<?php print h(ITEMS_IMG_DIR . $records['item']->img1); ?>" alt="アイテム画像"></li>
                                <li><img src="<?php print h(ITEMS_IMG_DIR . $records['item']->img2); ?>" alt="アイテム画像"></li>
                                <li><img src="<?php print h(ITEMS_IMG_DIR . $records['item']->img3); ?>" alt="アイテム画像"></li>
                                <li><img src="<?php print h(ITEMS_IMG_DIR . $records['item']->img4); ?>" alt="アイテム画像"></li>
                                <li><img src="<?php print h(ITEMS_IMG_DIR . $records['item']->img5); ?>" alt="アイテム画像"></li>
                                <li><img src="<?php print h(ITEMS_IMG_DIR . $records['item']->img6); ?>" alt="アイテム画像"></li>
                                <li><img src="<?php print h(ITEMS_IMG_DIR . $records['item']->img7); ?>" alt="アイテム画像"></li>
                                <li><img src="<?php print h(ITEMS_IMG_DIR . $records['item']->img8); ?>" alt="アイテム画像"></li>
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
                                        <div class="detail-stock <?= $records['event']->status ? 'true' : 'false' ?>">
                                            <p class="<?= $records['item']->stock ? 'true' : 'false' ?>">在庫数&emsp;<?php print h($records['item']->getStock()); ?></p>
                                        </div>
                                    </div>
                                    <div class="buttonwrap <?= $records['event']->status ? 'true' : 'false' ?>">
                                        <div class="cart-button">
                                            <form action="index.php" method="post">
                                              <input type="submit" value="ADD TO CART">
                                              <input type="hidden" name="module" value="carts">
                                              <input type="hidden" name="action" value="add">
                                              <input type="hidden" name="item_id" value="<?php print h($records['item']->item_id); ?>">
                                              <input type="hidden" name="token" value="<?=h($token)?>">
                                            </form>
                                        </div><!-- / .cart-button -->
                                        <div class="favorite-button">
                                            <form action="index.php" method="post">
                                                <label for="favorite">
                                                    <input id="favorite" type="submit" style="display: none;">
                                                    <svg>
                                                        <use xlink:href="./assets/images/icon/favorite.svg#favorite"></use>
                                                    </svg>
                                                </label>
                                                <input type="hidden" name="module" value="favorite">
                                                <input type="hidden" name="action" value="add">
                                                <input type="hidden" name="item_id" value="<?php print h($records['item']->item_id); ?>">
                                                <input type="hidden" name="token" value="<?=h($token)?>">
                                            </form>
                                        </div><!-- / .favorite-button -->
                                    </div><!-- / .buttonwrap -->
                                    <div class="group">
                                        <p class="group-description">アイテム説明</br><?php print h($records['item']->description); ?></p>
                                        <p class="group-category">カテゴリ&nbsp;:&nbsp;<?php print h($records['item']->category_name); ?></p>
                                    </div>
                                </div><!-- /.item-detail アイテム詳細-->
                            </div>
                        </div><!-- /.box fadeUpTrigger -->
                        <div class="box fadeUpTrigger">
                            <div class="right-section">
                                <div class="brand-detail">
                                    <div class="detail-lead">
                                        <div class="detail-name">
                                            <a href="index.php?module=brands&action=index&brand_id=<?php print h($records['brand']->brand_id); ?>&event_id=<?php print h($records['event']->event_id); ?>">
                                                <?php print h($records['brand']->brand_name); ?>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="group">
                                        <p class="group-description"><?php print h($records['brand']->description); ?></p>
                                        <p class="group-hp"><a href="<?php print h($records['brand'] -> brand_hp); ?>" target=”_blank” rel="noopener noreferrer"><?php print h($records['brand'] -> brand_hp); ?></a></p>
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
                                  </div><!--/.group ブランド詳細-->
                                </div>
                            </div>
                        </div><!-- /.box fadeUpTrigger -->
                    </div><!-- / .container -->
                </div><!-- / .item-info -->
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