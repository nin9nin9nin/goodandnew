<?php
$title = 'GOOD&NEW オンラインショップ';
$is_top = NULL; //トップページの判定(isset)
Session::start();
$flash_message = Session::getFlash(); // フラッシュメッセージの取得
$cart_count = Session::get('cart_count', ""); //カート内のアイテム数を取得
include INCLUDE_DIR . '/user/head.php'; // head.php の読み込み
?>
</head>
<body>
    <?php include INCLUDE_DIR . '/user/header_fixed.php'; ?>
    <main>
        <section class="area" id="orders">
            <nav class="page-nav wrapper">
                <span>
                    <a href="<?php echo url_for('orders', 'history'); ?>">ORDER&nbsp;HISTORY</a>
                </span>
                <span>&gt;</span>
                <span>
                    <a href="index.php?module=orders&action=detail&order_id=<?php print h($records['order']->order_id); ?>">ORDER&nbsp;DETAIL</a>
                </span>
                <span>&gt;</span>
            </nav>
            <div class="box fadeUpTrigger content">
                <div class="section-title">ORDER&nbsp;DETAIL</div>
                <div class="order-detail list-content">
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
                    <div class="order-list">
                    <?php if(!empty($records['order'])) { ?>
                        <div class="order-caption">
                          <div class="order-number">注文番号：<span><?php print h($records['order'][0]->order_number); ?></span></div>
                          <div class="order-datetime"><?php print h($records['order'][0]->create_datetime); ?></div>
                        </div>
                        <table>
                            <thead>
                                <tr>
                                    <th colspan="2">購入明細</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($records['order'] as $record) { ?>
                                <tr>
                                    <td class="cart-info">
                                        <a href="index.php?module=items&action=detail&item_id=<?php print h($record -> item_id); ?>">
                                            <div class="cart-item-img">
                                                <img src="<?php print h(ITEMS_ICON_DIR . $record -> icon_img); ?>" alt="アイテム画像">
                                            </div>
                                            <div class="cart-item-lead">
                                                <p class="sub-lead"><?php print h($record -> brand_name); ?></p>
                                                <p class="main-lead"><?php print h($record -> item_name); ?></p>
                                                <p class="mid-lead">&yen;<?php print h($record -> getPrice()); ?>&nbsp;<span class="tax-in">(TAX&nbsp;IN)</span></p>
                                            </div>
                                        </a>
                                    </td>
                                    <td class="order-quantity">
                                        <div class="order-quantity-flex">
                                            <div class="item-quantity">数量<span><?php print h($record -> quantity); ?></span></div>
                                            <div class="item-amount">小計<span><?php print h($record -> getSubTotal()); ?></span></div>
                                        </div>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td>合計数量</td>
                                    <td><?php print h($records['total_quantity']); ?></td>
                                </tr>
                                <tr>
                                    <td>合計金額（税込み）</td>
                                    <td><?php print h($records['total_amount']); ?></td>
                                </tr>
                            </tfoot>
                        </table>
                    <?php } else { ?>
                        <p class="message errors">購入明細がありません。</p>
                    <?php } ?>
                    </div><!-- .order-list -->
                </div><!-- / .order-detail .content -->
                <div class="button-area">
                    <div class="basebutton">
                        <a href="<?php echo url_for('orders', 'history'); ?>">
                            <span>戻る</span>
                        </a>
                    </div>
                </div>
            </div><!-- /.box -->
        </section><!-- / #carts -->
        <?php include INCLUDE_DIR . '/user/f-nav.php'; ?>
    </main>
    <?php include INCLUDE_DIR . '/user/footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/stickyfill/2.1.0/stickyfill.min.js"></script>
    <script src="./assets/js/user/common.js"></script>
</body>

</html>