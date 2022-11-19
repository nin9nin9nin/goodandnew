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
    <div id="account" class="big-bg">
        <div id="page-header">
          <?php include 'inc/user/header.php'; ?>
        </div>

        <div class="account-contents wrapper">
            <section>
                <div class="section-title">ACCOUNT</div>
                <div class="order-history">
                    <a href="<?php echo url_for('carts', 'order_history'); ?>">
                        <span>購入履歴へ</span>
                    </a>
                </div>
                <div class="account-info">
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
                        <caption>アカウント情報</caption>
                        <tbody>
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
                        </tbody>
                    </table>
                </div>
            </section>
            <div class="logout">
                <form action="index.php" method="post">
                    <input type="submit" value="ログアウト">
                    <input type="hidden" name="module" value="users">
                    <input type="hidden" name="action" value="logout">
                    <input type="hidden" name="user_id" value="<?php print h($record->user_id); ?>">
                </form>
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