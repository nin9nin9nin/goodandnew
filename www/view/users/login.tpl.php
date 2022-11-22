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
<body>
    <?php include INCLUDE_DIR . '/user/header_fixed.php'; ?>
    <main>
        <section class="area" id="member">
          <div class="box wrapper">
            <h3 class="section-title">MEMBER</h3>
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
            <div class="input-field member-bg">
              <ul class="tab">
                <li><a href="#login">ログイン</a></li>
                <li><a href="#register">新規登録</a></li>
              </ul>
              <div id="login" class="form">
                <form action="index.php" method="post">
                  <div>
                    <label for="user_name">ユーザーネーム</label>
                    <input type="text" id="user_name" name="user_name" value="<?php print h($cookie_name); ?>">
                  </div>
                  <div>
                    <label for="password">パスワード</label>
                    <input type="password" id="password" name="password" value="">
                  </div>
                  <div class="block small">
                    <input id="cookie_check" type="checkbox" name="cookie_check" value="checked" <?php print h($cookie_check); ?>>
                    <label for="cookie_check">次回から管理者ネームの入力を省略</label>
                  </div>
                  <div class="member-button">
                  <input type="submit" class="button" value="ログインする">
                  <input type="hidden" name="module" value="users">
                  <input type="hidden" name="action" value="login">
                  <input type="hidden" name="token" value="<?=h($token)?>">
                  </div>
                </form>
              </div><!--/.login-->
              <div id="register" class="form">
                <form action="index.php" method="post">
                  <div>
                    <label for="reg_user_name">ユーザーネーム</label>
                    <input type="text" id="user_name" name="reg_user_name" value="" placeholder="半角英数字,6文字以上">
                  </div>
                  <div>
                    <label for="reg_email">メールアドレス</label>
                    <input type="email" id="email" name="reg_email" value="" >
                  </div>
                  <div>
                    <label for="reg_password">パスワード</label>
                    <input type="password" id="password" name="reg_password" value="" placeholder="半角英数字,6文字以上">
                  </div>
                  <div class="block small">
                    <input id="cookie_check" type="checkbox" name="reg_cookie_check" value="checked">
                    <label for="reg_cookie_check">次回から管理者ネームの入力を省略</label>
                  </div>
                  <div class="member-button">
                    <input type="submit" class="button" value="登録する">
                    <input type="hidden" name="module" value="users">
                    <input type="hidden" name="action" value="register">
                    <input type="hidden" name="token" value="<?=h($token)?>">
                  </div>
                </form>
              </div><!--/.register-->
            </div><!--/.input-field -->
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