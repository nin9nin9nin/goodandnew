<?php
$title = 'GOOD&NEW オンラインショップ';
$is_top = NULL; //トップページの判定(isset)
Session::start();
$flash_message = Session::getFlash(); // フラッシュメッセージの取得
$token = Session::getCsrfToken(); // トークンの取得
$cart_count = Session::get('cart_count', ""); //カート内のアイテム数を取得
include INCLUDE_DIR . '/user/head.php'; // head.php の読み込み
?>
</head>
<body>
    <?php include INCLUDE_DIR . '/user/header_fixed.php'; ?>
    <main>
        <section class="area" id="account">
            <nav class="page-nav wrapper">
                <span>
                    <a href="<?php echo url_for('users', 'account'); ?>">ACCOUNT</a>
                </span>
                <span>&gt;</span>
            </nav><!-- / .page-nav -->
            <div class="box fadeUpTrigger content">
                <h3 class="section-title">ACCOUNT</h3>
                <div class="account-info">
                    <table>
                        <caption>アカウント情報</caption>
                        <tbody>
                          <?php if (!empty($record)) { ?>
                          <tr>
                            <th>ユーザーID</th>
                            <td><?php print h($record->user_id); ?></td>
                          </tr>
                          <tr>
                            <th>ユーザーネーム</th>
                            <td><?php print h($record->user_name); ?></td>
                          </tr>
                          <tr>
                            <th>メールアドレス</th>
                            <td><?php print h($record->email); ?></td>
                          </tr>
                          <tr>
                            <th>登録日時</th>
                            <td><?php print h($record->getCreateDateTime()); ?></td>
                          </tr>
                          <?php } else { ?>
                              <p class="message errors">アカウント情報がありません。</p>
                          <?php } ?>
                        </tbody>
                    </table>
                </div><!-- /.account-info-->
                <div class="btn-arrow">
                  <a href="<?php echo url_for('orders', 'history'); ?>" class="btnarrow4">購入履歴を見る</a>
                </div>
                <div class="button-area button-flex">
                  <div class="logout">
                      <form action="index.php" method="post">
                          <input type="submit" value="ログアウト">
                          <input type="hidden" name="module" value="users">
                          <input type="hidden" name="action" value="logout">
                          <input type="hidden" name="token" value="<?=h($token)?>">
                      </form>
                  </div>
                  <div class="basebutton">
                      <a href="<?php echo url_for('events', 'index'); ?>">
                        <span>ショッピングに戻る</span> 
                      </a>
                  </div>
                </div>
            </div><!-- /.box -->
        </section>
        <?php include INCLUDE_DIR . '/user/f-nav.php'; ?>
    </main>
    <?php include INCLUDE_DIR . '/user/footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/stickyfill/2.1.0/stickyfill.min.js"></script>
    <script src="./assets/js/user/common.js"></script>
</body>

</html>