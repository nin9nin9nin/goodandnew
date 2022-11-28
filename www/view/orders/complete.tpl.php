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
                    <a href="<?php echo url_for('carts', 'index'); ?>">CARTS</a>
                </span>
                <span>&gt;</span>
                <span>
                    CONFIRM&nbsp;THE&nbsp;ORDER
                </span>
                <span>&gt;</span>
                <span>
                    ORDER&nbsp;COMPLETE
                </span>
                <span>&gt;</span>
            </nav>
            <div class="box fadeUpTrigger content">
                <div class="section-title">ORDER&nbsp;COMPLETE</div>
                <div class="check-mark">
                  <img src="./assets/images/icon/iconmonstr-check-mark-2-240.png" alt="check-mark">
                </div>
                <div class="section-sub-title">ご購入ありがとうございました。</div>
                <div class="title-user-name"><?php print h($records['user']->user_name); ?>&nbsp;様</div>
                <div class="order-complete list-content">
                    <div class="order-list">
                        <?php if(count($records['orders']) > 0) { ?>
                        <div class="order-caption">
                          <div class="order-number">注文番号：<span><?php print h($records['orders'][0]->order_number); ?></span></div>
                          <div class="order-datetime"><?php print h($records['orders'][0]->create_datetime); ?></div>
                        </div>
                        <table>
                            <thead>
                                <tr>
                                    <th colspan="2">注文伝票</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($records['orders'] as $record) { ?>
                                <tr>
                                    <td class="order-info">
                                        <div class="item-lead">
                                            <p class="sub-lead"><?php print h($record->brand_name); ?></p>
                                            <p class="main-lead"><?php print h($record->item_name); ?></p>
                                            <p class="mid-lead">&yen;<?php print h($record->getPrice()); ?><span class="tax-in">(TAX&nbsp;IN)</span></p>
                                        </div>
                                    </td>
                                    <td class="order-quantity">
                                        <div class="order-quantity-flex">
                                            <div class="item-quantity">数量<span><?php print h($record->quantity); ?></span></div>
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
                            <p class="message errors">オーダー情報がありません。</p>
                        <?php } ?>
                    </div><!-- .order-list -->
                    <div class="btn-arrow content">
                      <a href="<?php echo url_for('orders', 'history'); ?>" class="btnarrow4">購入履歴を見る</a>
                    </div>
                </div><!-- / .order-complete .content -->
                <div class="button-area">
                    <div class="basebutton">
                        <a href="<?php echo url_for('top', 'index'); ?>">
                            <span>TOP</span>
                        </a>
                    </div>
                </div>
            </div><!-- /.box -->
        </section><!-- / #orders -->
        <?php include INCLUDE_DIR . '/user/f-nav.php'; ?>
    </main>
    <?php include INCLUDE_DIR . '/user/footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/stickyfill/2.1.0/stickyfill.min.js"></script>
    <script src="./assets/js/user/common.js"></script>
</body>

</html>