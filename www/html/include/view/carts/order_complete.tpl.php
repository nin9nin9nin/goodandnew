<?php
$title = 'ec site ショップ画面';
$description = '説明（購入完了ページ）';
// $is_home = true; //トップページの判定用の変数
//セッションからカート内のアイテム数を取得
$cart_count = Session::getInstance() -> get('cart_count', "");
include 'inc/user/head.php'; // head.php の読み込み
?>
</head>

<body>
    <div id="order" class="big-bg">
        <div id="page-header">
          <?php include 'inc/user/header.php'; ?>
        </div>

        <div class="order-contents wrapper">
            <section>
                <div class="order-title">
                    <div class="section-title">ORDER&nbsp;COMPLETE</div>
                    <div class="section-title">ご購入ありがとうございました。</div>
                    <div><?php print h($records['user'] -> user_name); ?>&nbsp;様</div>
                </div>
                <div class="order-history">
                    <a href="<?php echo url_for('carts', 'order_history'); ?>">
                        <span>購入履歴へ</span>
                    </a>
                </div>
                <div class="order-info">
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
                        <caption><div><?php print h($records['purchased'][0] -> update_datetime); ?></div></caption>
                        <thead>
                          <tr>
                            <th colspan="2">購入伝票</th>
                          </tr>
                          <tr>
                            <th>商品</th>
                            <th>数量</th>
                          </tr>
                        </thead>
                        <?php if($records['total_quantity'] > 0) { ?>
                        <tbody>
                          <?php foreach ($records['purchased'] as $record) { ?>
                          <tr>
                            <td class="list-lead">
                                <a href="index.php?module=items&action=detail&item_id=<?php print h($record->item_id); ?>">
                                    <span class="sub-lead"><?php print h($record->brand_name); ?></span>
                                    <p class="main-lead"><?php print h($record->item_name); ?></p>
                                    <p class="main-lead">
                                        &yen;<?php print h($record->getPrice()); ?>&nbsp;<span class="tax-in">(TAX&nbsp;IN)</span>
                                    </p>
                                </a>
                            </td>
                            <td class="list-quantity">
                                <p><?php print h($record->quantity); ?></p>
                            </td>
                          </tr>
                          <?php } ?>
                        </tbody>
                        <tfoot>
                          <tr>
                            <th>数量</th><td><?php print h($records['total_quantity']); ?></td>
                          </tr>
                          <tr></tr>
                            <th>購入金額（税込）</th><td><?php print h($records['total_amount']); ?></td>
                          </tr>
                        </tfoot>
                        <?php } ?>
                    </table>
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