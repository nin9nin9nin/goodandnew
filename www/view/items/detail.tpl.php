<?php
$title = 'ec site ショップ画面';
$description = '説明（アイテム詳細ページ）';
// $is_home = true; //トップページの判定用の変数
//セッションからカート内のアイテム数を取得
$cart_count = Session::getInstance() -> get('cart_count', "");
include 'inc/user/head.php'; // head.php の読み込み
?>
</head>

<body>
    <div id="detail" class="big-bg">
        <div id="page-header">
          <?php include 'inc/user/header.php'; ?>
        </div>

        <div class="detail-content wrapper">
            <?php if(count($records) > 0) { ?>
            <div id="fixed-area"><!--左固定エリア-->
                <div class="gallery-info">
                        <ul class="gallery">
                            <li><img src="<?php print h('./include/img/' .$records[0]->icon_img); ?>" alt="商品画像"></li>
                        </ul>
                        <!--<ul class="choice-btn">-->
                        <!--    <li><img src="https://coco-factory.jp/ugokuweb/wp-content/themes/ugokuweb/data/6-2-4/img/01.jpg" alt=""></li>-->
                        <!--    <li><img src="https://coco-factory.jp/ugokuweb/wp-content/themes/ugokuweb/data/6-2-4/img/02.jpg" alt=""></li>-->
                        <!--    <li><img src="https://coco-factory.jp/ugokuweb/wp-content/themes/ugokuweb/data/6-2-4/img/03.jpg" alt=""></li>-->
                        <!--    <li><img src="https://coco-factory.jp/ugokuweb/wp-content/themes/ugokuweb/data/6-2-4/img/04.jpg" alt=""></li>-->
                        <!--    <li><img src="https://coco-factory.jp/ugokuweb/wp-content/themes/ugokuweb/data/6-2-4/img/05.jpg" alt=""></li>-->
                        <!--    <li><img src="https://coco-factory.jp/ugokuweb/wp-content/themes/ugokuweb/data/6-2-4/img/06.jpg" alt=""></li>-->
                        <!--    <li><img src="https://coco-factory.jp/ugokuweb/wp-content/themes/ugokuweb/data/6-2-4/img/07.jpg" alt=""></li>-->
                        <!--    <li><img src="https://coco-factory.jp/ugokuweb/wp-content/themes/ugokuweb/data/6-2-4/img/08.jpg" alt=""></li>-->
                        <!--</ul>-->
                </div><!--/.gallery-info-->
            </div><!--/fixed-area-->
            
            <div id="container"><!--右エリア-->
                <div class="box fadeUpTrigger">
                    <section class="right-section">
                      <div class="area">
                        <div class="detail-info">
                            <div class="lead">
                                <span class="sub-lead"><?php print h($records[0]->brand_name); ?></span>
                                <p class="main-lead"><?php print h($records[0]->item_name); ?></p>
                                <p class="main-lead">&yen;<?php print h($records[0]->getPrice()); ?>&nbsp;<span class="tax-in">(TAX&nbsp;IN)</span></p>
                                <div class="stock">
                                    <p class="<?= $records[0]->stock ? 'true' : 'false' ?>">在庫数：<?php print h($records[0]->stock); ?></p>
                                </div>
                                <!--エラーメッセージ-->
                                <?php if(count($errors) > 0) { ?>
                                <div class="message">
                                  <ul class="errors">
                                  <?php foreach($errors as $key => $error) { ?>
                                    <li>
                                      <?php print h($error); ?>
                                    </li>
                                  <?php } ?>
                                  </ul>
                                </div>
                                <?php } ?>
                                
                                <?php if($records[0]->stock !== 0) { ?>
                                <div class="buttonwrap">
                                    <div class="cartbutton">
                                        <form action="index.php" method="post">
                                          <input type="submit" value="ADD TO CART">
                                          <input type="hidden" name="module" value="carts">
                                          <input type="hidden" name="action" value="add">
                                          <input type="hidden" name="item_id" value="<?php print h($records[0]->item_id); ?>">
                                        </form>
                                    </div>
                                </div>
                                <?php } else { ?>
                                <p class="soldout">売り切れ</p>
                                <?php } ?>
                                <div class="favoritebutton">
                                    <!--<a href="index.php?module=favorites&action=add&item_id=<?php print h($records[0]->item_id); ?>">-->
                                        <img class="nav" src="./images/iconmonstr-heart-thin.svg" alt="お気に入り">
                                    <!--</a>-->
                                </div>
                            </div>
                        </div>
                      </div><!--/area1-->
                    </section>
                </div><!-- /.box fadeUpTrigger -->
                <div class="box fadeUpTrigger">
                    <section class="right-section">
                      <div class="area">
                          <h3>アイテム説明：</h3>
                          <p><?php print h($records[0]->description); ?></p>
                          <p><?php print h($records[0]->category_name); ?></p>
                      </div><!--/area1-->
                      <div class="area">
                          <?php if (count($records['brand']) > 0) { ?>
                           <h3>ブランド：</h3>
                          <?php foreach ($records['brand'] as $record) { ?>
                          <p><?php print h($record->brand_name); ?></p>
                          <p><?php print h($record->description); ?></p>
                          <div>
                              <!--<a href="<?php print h($record->brand_hp); ?>">-->
                                <span><?php print h($record->brand_hp); ?></span>
                              <!--</a>-->
                          </div>
                          <span>
                              <!--<a href="<?php print h($record->brand_link1); ?>">-->
                                  <img src="" alt="instagram">
                              <!--</a>-->
                          </span>
                          <?php } ?>
                          <?php } else { ?>
                          <p>商品情報はありません。</p>
                          <?php } ?>
                      </div><!--/area1-->
                    </section>
                </div><!-- /.box fadeUpTrigger -->
                <div class="box fadeUpTrigger">
                    <section class="right-section">
                      <div class="area">
                          <?php if (count($records['shop']) > 0) { ?>
                           <h3>取り扱いショップ：</h3>
                          <?php foreach ($records['shop'] as $record) { ?>
                          <p><?php print h($record->shop_name); ?></p>
                          <p><?php print h($record->description); ?></p>
                          <div>
                              <!--<a href="<?php print h($record->shop_hp); ?>">-->
                                <span><?php print h($record->shop_hp); ?></span>
                              <!--</a>-->
                          </div>
                          <div><?php print h($record->address); ?></div>
                          <div><?php print h($record->phone_number); ?></div>
                          <span>
                              <!--<a href="<?php print h($record->shop_link1); ?>">-->
                                  <img src="" alt="instagram">
                              <!--</a>-->
                          </span>
                          <span>
                              <!--<a href="<?php print h($record->shop_link2); ?>">-->
                                  <img src="" alt="YouTube">
                              <!--</a>-->
                          </span>
                          <span>
                              <!--<a href="<?php print h($record->shop_link3); ?>">-->
                                  <img src="" alt="Twitter">
                              <!--</a>-->
                          </span>
                          <span>
                              <!--<a href="<?php print h($record->shop_link4); ?>">-->
                                  <img src="" alt="Facebook">
                              <!--</a>-->
                          </span>
                          <?php } ?>
                          <?php } else { ?>
                          <p>商品情報はありません。</p>
                          <?php } ?>
                      </div><!--/area1-->
                    </section>
                </div><!-- /.box fadeUpTrigger -->
            </div><!-- / .container -->
            <?php } ?>
        </div><!-- / .detail-content -->
    </div><!-- / #detail .big-bg -->
    <?php include 'inc/user/footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/stickyfill/2.1.0/stickyfill.min.js"></script>
    <script src="./js/user/detail.js"></script>
</body>

</html>