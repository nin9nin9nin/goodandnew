<?php
$title = 'GOOD&NEW オンラインショップ';
$is_top = NULL; //トップページの判定(isset)
$flash_message = Session::getFlash(); // フラッシュメッセージの取得
$token = Session::getCsrfToken(); // トークンの取得
$cart_count = Session::get('cart_count', ""); //カート内のアイテム数を取得
$cookie_check = Cookie::getUserCookieCheck();
$cookie_name = Cookie::getUserCookieName();
include INCLUDE_DIR . '/user/head.php'; // head.php の読み込み
?>
</head>
<body ontouchstart="">
    <?php include INCLUDE_DIR . '/user/header_fixed.php'; ?>
    <main>
        <section class="area" id="logout">
          <div class="box fadeUpTrigger wrapper">
            <div class="logout-image">
              <img src="./assets/images/baby/logout.png" alt="イメージ画像">
            </div>
            <div class="logout-message">
              ご利用ありがとうございました。
              </br>
              THANK YOU FOR USING
            </div>
            <div class="button-area">
                <div class="basebutton">
                    <a href="<?php echo url_for('top', 'index'); ?>">
                        <span>TOP</span>
                    </a>
                </div>
            </div>
          </div><!--/.box-->
        </section><!-- / #member -->
        <?php include INCLUDE_DIR . '/user/f-nav.php'; ?>
    </main>
    <?php include INCLUDE_DIR . '/user/footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="./assets/js/user/login.js"></script>
    <script src="./assets/js/user/common.js"></script>
</body>

</html>