<?php
$title = 'ec site ショップ画面';
$description = '説明（アイテムページ）';
$is_home = true; //トップページの判定用の変数
//セッションからカート内のアイテム数を取得
$cart_count = Session::get('cart_count', "");
//フラッシュメッセージの取得
$flash_message = Session::getFlash();
include 'inc/user/head.php'; // head.php の読み込み
?>
</head>

<body>
    <div id="items" class="big-bg">
        <div id="page-header">
          <?php include 'inc/user/header.php'; ?>
        </div>
        
        <div class="items-content wrapper">
            <div class="link-nav">
                <ul id="page-link">
                    <li><a class="arrow" href="#area-1">MONTHLY&nbsp;ITEMS</a></li>
                    <li><a class="arrow" href="#area-2">BRANDS</a></li>
                    <li><a class="arrow" href="#area-3">ORIGINALS</a></li>
                </ul>
            </div>
            <?php if(count($records['monthly']) > 0) { ?>
            <div class="box fadeUpTrigger">
                <section class="area" id="area-1">
                    <div class="section-title">&ndash;&thinsp;MONTHLY&nbsp;ITEMS&thinsp;&ndash;</div>
                    <div class="wrapper grid">
                        <?php foreach ($records['monthly'] as $record) { ?>
                        <div class="item">
                            <div class="bgUD">
                                <a href="index.php?module=items&action=detail&item_id=<?php print h($record->item_id); ?>">
                                    <span class="mask">
                                        <img src="<?php print h('./include/img/' .$record->icon_img); ?>" alt="商品画像">
                                        <span class="cap">
                                            <?php print h($record->description); ?>
                                            <span>在庫数：<?php print h($record->stock); ?></span>
                                        </span>
                                    </span>
                                </a>
                            </div>
                            <div class="bgUD lead">
                                <a href="index.php?module=items&action=detail&item_id=<?php print h($record->item_id); ?>">
                                    <span class="sub-lead"><?php print h($record->brand_name); ?></span>
                                    <p class="main-lead"><?php print h($record->item_name); ?></p>
                                    <p class="main-lead">
                                        &yen;<?php print h($record->getPrice()); ?>&nbsp;<span class="tax-in">(TAX&nbsp;IN)</span>
                                    </p>
                                </a>
                            </div>
                        </div>
                        <?php } ?>
                    </div><!-- / .grid -->
                </section>
            </div><!-- /.box fadeUpTrigger -->
            <?php }  ?>
            
            <?php if(count($records['brands']) > 0) { ?>
            <div class="box fadeUpTrigger">
                <section class="area" id="area-2">
                    <div class="section-title">&ndash;&thinsp;BRANDS&thinsp;&ndash;</div>
                    <div class="wrapper grid">
                        <?php foreach ($records['brands'] as $record) { ?>
                        <div class="item">
                            <div class="bgUD">
                                <!--<a href="index.php?module=brands&action=detail&brand_id=<?php print h($record->brand_id); ?>">-->
                                    <span class="mask white">
                                        <span class="brands"><?php print h($record -> brand_name); ?></span>
                                        <!--<img src="">-->
                                        <span class="cap"><?php print h($record->description); ?></span>
                                    </span>
                                <!--</a>-->
                            </div>
                            <p class="bgUD lead">
                                <!--<a href="index.php?module=brands&action=detail&brand_id=<?php print h($record->brand_id); ?>">-->
                                    <?php print h($record->category_name); ?>
                                <!--</a>-->
                            </p>
                        </div>
                        <?php } ?>
                    </div><!-- / .grid -->
                </section>
            </div><!-- /.box fadeUpTrigger -->
            <?php }  ?>
            
            <?php if(count($records['original']) > 0) { ?>
            <div class="box fadeUpTrigger">
                <section class="area" id="area-3">
                    <div class="section-title">&ndash;&thinsp;ORIGINALS&thinsp;&ndash;</div>
                    <div class="wrapper grid">
                        <?php foreach ($records['original'] as $record) { ?>
                        <div class="item">
                            <div class="bgUD">
                                <a href="index.php?module=items&action=detail&item_id=<?php print h($record->item_id); ?>">
                                    <span class="mask">
                                        <img src="<?php print h('./include/img/' .$record->icon_img); ?>" alt="商品画像">
                                        <span class="cap">
                                            <?php print h($record->description); ?>
                                            <span>在庫数：<?php print h($record->stock); ?></span>
                                        </span>
                                    </span>
                                </a>
                            </div>
                            <div class="bgUD lead">
                                <a href="index.php?module=items&action=detail&item_id=<?php print h($record->item_id); ?>">
                                    <p class="main-lead"><?php print h($record->item_name); ?></p>
                                    <p class="main-lead">&yen;<?php print h($record->getPrice()); ?>&nbsp;<span>(TAX&nbsp;IN)</span></p>
                                </a>
                            </div>
                        </div>
                        <?php } ?>
                    </div><!-- / .grid -->
                </section>
            </div><!-- /.box fadeUpTrigger -->
            <?php }  ?>
            <div class="box fadeUpTrigger">
                <section>
                    <div class="gallery-info">
                        <h1>Gallery</h1>
                        <p><a href="" target="_blank">next month</a></p>
    
                        <ul class="gallery">
                            <li><img src="https://coco-factory.jp/ugokuweb/wp-content/themes/ugokuweb/data/6-2-4/img/01.jpg" alt=""></li>
                            <li><img src="https://coco-factory.jp/ugokuweb/wp-content/themes/ugokuweb/data/6-2-4/img/02.jpg" alt=""></li>
                            <li><img src="https://coco-factory.jp/ugokuweb/wp-content/themes/ugokuweb/data/6-2-4/img/03.jpg" alt=""></li>
                            <li><img src="https://coco-factory.jp/ugokuweb/wp-content/themes/ugokuweb/data/6-2-4/img/04.jpg" alt=""></li>
                            <li><img src="https://coco-factory.jp/ugokuweb/wp-content/themes/ugokuweb/data/6-2-4/img/05.jpg" alt=""></li>
                            <li><img src="https://coco-factory.jp/ugokuweb/wp-content/themes/ugokuweb/data/6-2-4/img/06.jpg" alt=""></li>
                            <li><img src="https://coco-factory.jp/ugokuweb/wp-content/themes/ugokuweb/data/6-2-4/img/07.jpg" alt=""></li>
                            <li><img src="https://coco-factory.jp/ugokuweb/wp-content/themes/ugokuweb/data/6-2-4/img/08.jpg" alt=""></li>
                        </ul>
                        <ul class="choice-btn">
                            <li><img src="https://coco-factory.jp/ugokuweb/wp-content/themes/ugokuweb/data/6-2-4/img/01.jpg" alt=""></li>
                            <li><img src="https://coco-factory.jp/ugokuweb/wp-content/themes/ugokuweb/data/6-2-4/img/02.jpg" alt=""></li>
                            <li><img src="https://coco-factory.jp/ugokuweb/wp-content/themes/ugokuweb/data/6-2-4/img/03.jpg" alt=""></li>
                            <li><img src="https://coco-factory.jp/ugokuweb/wp-content/themes/ugokuweb/data/6-2-4/img/04.jpg" alt=""></li>
                            <li><img src="https://coco-factory.jp/ugokuweb/wp-content/themes/ugokuweb/data/6-2-4/img/05.jpg" alt=""></li>
                            <li><img src="https://coco-factory.jp/ugokuweb/wp-content/themes/ugokuweb/data/6-2-4/img/06.jpg" alt=""></li>
                            <li><img src="https://coco-factory.jp/ugokuweb/wp-content/themes/ugokuweb/data/6-2-4/img/07.jpg" alt=""></li>
                            <li><img src="https://coco-factory.jp/ugokuweb/wp-content/themes/ugokuweb/data/6-2-4/img/08.jpg" alt=""></li>
                        </ul>
    
                    </div><!--/.gallery-info-->
                </section>
           </div><!-- /.box fadeUpTrigger -->
        </div><!-- / .item-content -->
    </div><!-- / #items .big-bg -->
    <?php include 'inc/user/footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script src="./js/user/items.js"></script>
</body>

</html>