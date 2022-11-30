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
<body ontouchstart="">
    <?php include INCLUDE_DIR . '/user/header_fixed.php'; ?>
    <main>
        <section class="area" id="carts">
            <nav class="page-nav wrapper">
                <span>
                    <a href="<?php echo url_for('carts', 'index'); ?>">CARTS</a>
                </span>
                <span>&gt;</span>
            </nav>
            <div class="box fadeUpTrigger wrapper">
                <div class="section-title">SHOPPING&nbsp;CART</div>
                <div class="cart-content">
                    <div class="list-content">
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
                        <div class="cart-list">
                        <?php if(count($records['carts']) > 0) { ?>
                            <?php if(!empty($records['carts'][0] -> item_id)) { ?>
                                <table>
                                    <thead>
                                        <tr>
                                            <th>商品</th>
                                            <th>数量</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($records['carts'] as $record) { ?>
                                        <tr>
                                            <td class="cart-info">
                                                <a href="index.php?module=items&action=detail&item_id=<?php print h($record->item_id); ?>">
                                                    <div class="cart-item-img">
                                                        <img src="<?php print h(ITEMS_ICON_DIR . $record -> icon_img); ?>" alt="アイテム画像">
                                                    </div>
                                                    <div class="cart-item-lead">
                                                        <p class="sub-lead"><?php print h($record->brand_name); ?></p>
                                                        <p class="main-lead"><?php print h($record->item_name); ?></p>
                                                        <p class="mid-lead">&yen;<?php print h($record->getPrice()); ?>&nbsp;<span class="tax-in">(TAX&nbsp;IN)</span></p>
                                                    </div>
                                                </a>
                                            </td>
                                            <td class="cart-quantity">
                                                <div class="cart-quantity-flex">
                                                    <form action="index.php" method="post">
                                                        <input type="text" name="quantity" value="<?php print h($record -> quantity); ?>">
                                                        <input type="submit" id="editsubmit" value="">
                                                        <input type="hidden" name="module" value="carts">
                                                        <input type="hidden" name="action" value="update">
                                                        <input type="hidden" name="cart_id" value="<?php print h($record->cart_id); ?>">
                                                        <input type="hidden" name="item_id" value="<?php print h($record->item_id); ?>">
                                                        <input type="hidden" name="token" value="<?=h($token)?>">
                                                    </form>
                                                    <form action="index.php" method="post">
                                                        <input type="submit" id="deletesubmit" value="削除" />
                                                        <input type="hidden" name="module" value="carts" />
                                                        <input type="hidden" name="action" value="delete" />
                                                        <input type="hidden" name="cart_id" value="<?php print h($record->cart_id); ?>">
                                                        <input type="hidden" name="item_id" value="<?php print h($record->item_id); ?>">
                                                        <input type="hidden" name="token" value="<?=h($token)?>">
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            <?php } else { ?>
                                <p class="message errors">カートに商品がありません。</p>
                            <?php } ?>
                        <?php } else { ?>
                            <p class="message errors">カート情報がありません。</p>
                        <?php } ?>
                        </div><!-- .cart-list -->
                    </div>
                    <div class="slip-content">
                        <div class="cart-slip">
                            <table>
                                <tr>
                                    <th>合計数量</th>
                                    <td><?php print h($records['total_quantity']); ?></td>
                                </tr>
                                <tr>
                                    <th>合計金額（税込）</th>
                                    <td><?php print h($records['total_amount']); ?></td>
                                </tr>
                            </table>
                        </div><!-- .cart-slip -->
                        <div class="order-button <?= $records['carts'][0] -> item_id ? 'true' : 'false' ?>">
                            <form action="index.php" method="post">
                                <input type="submit" value="CONFIRM THE ORDER" />
                                <input type="hidden" name="module" value="carts" />
                                <input type="hidden" name="action" value="confirm" />
                                <input type="hidden" name="cart_id" value="<?php print h($records['carts'][0]->cart_id); ?>">
                                <input type="hidden" name="token" value="<?=h($token)?>">
                            </form>
                        </div>
                        <div class="basebutton">
                            <a href="<?php echo url_for('events', 'index'); ?>">
                                <span>ショッピングを続ける</span>
                            </a>
                        </div>
                    </div>
                </div><!-- / .cart-content -->
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