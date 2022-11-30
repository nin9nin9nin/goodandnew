<?php
$title = 'GOOD&NEW オンラインショップ';
$is_top = NULL; //トップページの判定(isset)
Session::start();
$flash_message = Session::getFlash(); // フラッシュメッセージの取得
$cart_count = Session::get('cart_count', ""); //カート内のアイテム数を取得
include INCLUDE_DIR . '/user/head.php'; // head.php の読み込み
?>
</head>
<body ontouchstart="">
    <?php include INCLUDE_DIR . '/user/header_fixed.php'; ?>
    <main>
        <section class="area" id="orders">
            <nav class="page-nav wrapper">
                <span>
                    <a href="<?php echo url_for('users', 'account'); ?>">ACCOUNT</a>
                </span>
                <span>&gt;</span>
                <span>
                    <a href="<?php echo url_for('orders', 'history'); ?>">ORDER&nbsp;HISTORY</a>
                </span>
                <span>&gt;</span>
            </nav>
            <div class="box fadeUpTrigger wrapper">
                <div class="section-title">ORDER&nbsp;HISTORY</div>
                <div class="history-content">
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
                        <div class="history-list">
                        <?php if(count($records['historys']) > 0) { ?>
                            <table>
                                <thead>
                                    <tr>
                                        <th colspan="2">購入履歴</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($records['historys'] as $record) { ?>
                                    <tr>
                                      <td class="history-info">
                                        <a href="index.php?module=orders&action=detail&order_id=<?php print h($record -> order_id); ?>">
                                          <div class="order-number">注文番号：<span><?php print h($record -> order_number); ?></span></div>
                                          <div class="order-datetime"><?php print h($record -> create_datetime); ?></div>
                                        </a>
                                      </td>
                                      <td class="history-total">
                                        <div class="total-quantity">数量：<span><?php print h($record -> total_quantity); ?></span>点</div>
                                        <div class="total-amount">金額：<span><?php print h($record -> total_amount); ?></span>円</div>
                                        <div class="history-detail">
                                          <a href="index.php?module=orders&action=detail&order_id=<?php print h($record -> order_id); ?>">明細を見る</a>
                                        </div>
                                      </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        <?php } else { ?>
                            <p class="message errors">購入履歴がありません。</p>
                        <?php } ?>
                        </div><!-- .history-list -->
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
                        <div class="basebutton">
                            <a href="<?php echo url_for('events', 'index'); ?>">
                                <span>ショッピングに戻る</span>
                            </a>
                        </div>
                    </div><!-- .slip-content -->
                </div><!-- / .history-content -->
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