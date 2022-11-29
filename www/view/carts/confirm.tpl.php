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
            </nav>
            <div class="box fadeUpTrigger wrapper">
                <div class="section-title">CONFIRM&nbsp;THE&nbsp;ORDER</br>ご注文内容をご確認下さい。</div>
                <div class="confirm-content">
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
                        <div class="order-list">
                        <?php if(count($records['carts']) > 0) { ?>
                            <?php if(!empty($records['carts'][0] -> item_id)) { ?>
                            <table>
                                <thead>
                                    <tr>
                                        <th colspan="2">注文伝票</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($records['carts'] as $record) { ?>
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
                                                <div class="item-quantity">数量：<span><?php print h($record->quantity); ?></span>点</div>
                                                <div class="item-amount">小計：<span><?php print h($record -> getSubTotal()); ?></span>円</div>
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
                                <p class="message errors">カートに商品がありません。</p>
                            <?php } ?>
                        <?php } else { ?>
                            <p class="message errors">カート情報がありません。</p>
                        <?php } ?>
                        </div><!-- .confirm-list -->
                    </div><!-- .list-content -->
                    <div class="slip-content">
                        <div class="account-slip">
                            <?php if(!empty($records['user'])) { ?>
                            <table>
                                <tr>
                                    <th>ユーザー</th>
                                    <td><?php print h($records['user'] -> user_name); ?></td>
                                </tr>
                                <tr>
                                    <th>メールアドレス</th>
                                    <td><?php print h($records['user'] -> email); ?></td>
                                </tr>
                            </table>
                            <?php } else { ?>
                                <p class="message errors">ユーザー情報がありません。</p>
                            <?php } ?>
                            <div class="btn-arrow">
                                <a href="<?php echo url_for('users', 'account'); ?>" class="btnarrow4">アカウント情報へ</a>
                            </div>
                        </div><!-- .account-slip -->
                        <div class="order-button">
                            <form action="index.php" method="post">
                                <input type="submit" value="ORDER" />
                                <input type="hidden" name="module" value="orders" />
                                <input type="hidden" name="action" value="order" />
                                <input type="hidden" name="cart_id" value="<?php print h($records['carts'][0]->cart_id); ?>">
                                <input type="hidden" name="user_id" value="<?php print h($records['user']->user_id); ?>">
                                <input type="hidden" name="token" value="<?=h($token)?>">
                            </form>
                        </div>
                        <div class="basebutton">
                            <a href="<?php echo url_for('carts', 'index'); ?>">
                                <span>キャンセル</span>
                            </a>
                        </div>
                    </div><!-- .slip-content -->
                </div><!-- / .confirm-content -->
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