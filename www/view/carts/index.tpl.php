<?php
$title = 'ec site ショップ画面';
$description = '説明（カートページ）';
// $is_home = true; //トップページの判定用の変数
//セッションからカート内のアイテム数を取得
$cart_count = Session::getInstance() -> get('cart_count', "");
include 'inc/user/head.php'; // head.php の読み込み
?>
</head>

<body>
    <div id="cart" class="big-bg">
        <div id="page-header">
          <?php include 'inc/user/header.php'; ?>
        </div>

        <div class="cart-contents wrapper">
            <section>
                <div class="section-title">CART&nbsp;DETAILS</div>
                <div class="order-history">
                    <a href="<?php echo url_for('carts', 'order_history'); ?>">
                        <span>購入履歴へ</span>
                    </a>
                </div>

                <div class="cart-info">
                    <table>
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
                        <caption>カート一覧</caption>
                        <thead>
                          <tr>
                            <th>商品</th>
                            <th>数量</th>
                            <th></th>
                          </tr>
                        </thead>
                        <?php if($records['total_quantity'] > 0) { ?>
                        <tbody>
                          <?php foreach ($records['cart_items'] as $record) { ?>
                          <tr>
                            <td class="list-item">
                                <div class="list-img">
                                    <img src="<?php print h('./include/img/' .$record->icon_img); ?>">
                                </div>
                                <div class="list-lead">
                                    <a href="index.php?module=items&action=detail&item_id=<?php print h($record->item_id); ?>">
                                        <span class="sub-lead"><?php print h($record->brand_name); ?></span>
                                        <p class="main-lead"><?php print h($record->item_name); ?></p>
                                        <p class="main-lead">
                                            &yen;<?php print h($record->getPrice()); ?>&nbsp;<span class="tax-in">(TAX&nbsp;IN)</span>
                                        </p>
                                    </a>
                                </div>
                            </td>
                            <td class="list-quantity">
                                <form action="index.php" method="post">
                                    <div>
                                        <input type="text" name="new_quantity" value="<?php print h($record->quantity); ?>">
                                    </div>
                                    <div>
                                        <input type="submit" value="変更">
                                        <input type="hidden" name="module" value="carts">
                                        <input type="hidden" name="action" value="update">
                                        <input type="hidden" name="cart_id" value="<?php print h($record->cart_id); ?>">
                                        <input type="hidden" name="item_id" value="<?php print h($record->item_id); ?>">
                                        <input type="hidden" name="quantity" value="<?php print h($record->quantity); ?>">
                                    </div>
                                </form>
                            </td>
                            <td class="list-delete">
                                <form action="index.php" method="post">
                                  <input type="submit" value="削除">
                                  <input type="hidden" name="module" value="carts">
                                  <input type="hidden" name="action" value="delete">
                                  <input type="hidden" name="cart_id" value="<?php print h($record->cart_id); ?>">
                                  <input type="hidden" name="item_id" value="<?php print h($record->item_id); ?>">
                                  <input type="hidden" name="quantity" value="<?php print h($record->quantity); ?>">
                                </form>
                            </td>
                          </tr>
                          <?php } ?>
                        </tbody>
                        <?php } else { ?>
                        <p class="errors">カートに商品がありません</p>
                        <?php } ?>
                    </table>
                </div>
            </section>
            <section>
                <div class="cart-slip">
                    <form action="index.php" method="post">
                        <table>
                            <tr>
                                <th>数量</th><td><?php print h($records['total_quantity']); ?></td>
                            </tr>
                            <tr>
                                <th>合計金額（税込）</th><td><?php print h($records['total_amount']); ?></td>
                            </tr>
                        </table>
                        <?php if($records['total_quantity'] > 0) { ?>
                        <div class="orderbutton">
                            <input type="submit" value="CONFIRM THE ORDER">
                            <input type="hidden" name="module" value="carts">
                            <input type="hidden" name="action" value="order">
                            <input type="hidden" name="user_id" value="<?php print h($records['cart_items'][0]->user_id); ?>">
                            <input type="hidden" name="cart_id" value="<?php print h($records['cart_items'][0]->cart_id); ?>">
                        </div>
                        <?php } ?>
                    </form>
                </div>
            </section>
            <div class="basebutton">
                <a href="<?php echo url_for('items', 'index'); ?>">
                    <span>ショッピングを続ける</span>
                </a>
            </div>
        </div><!-- / .cart-content .wrapper-->
    </div><!-- / #cart .big-bg -->
    <?php include 'inc/user/footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/stickyfill/2.1.0/stickyfill.min.js"></script>
    <script src="./js/user/detail.js"></script>
</body>

</html>