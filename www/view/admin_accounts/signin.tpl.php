<?php
$title = 'goodandnewshop管理画面';
$description = '説明（ログインページ）';
$is_home = NULL; //トップページの判定用の変数
$flash_message = Session::getFlash();
$token = Session::getCsrfToken(); // トークンの取得
$cookie_check = Cookie::getCookieCheck();
$cookie_name = Cookie::getCookieName();
include INCLUDE_DIR . '/admin/head.php'; // head.php の読み込み
?>
</head>

<body>
  <main>
    <!---ログイン----------------------------------------------------------------------------------------------------------->
    <div id="login">
      <div class="container">
          
        <header>
          <a <?php echo isset($is_home) ? '': 'href="dashboard.php"' ?>> 
            <h1>管理システム</h1>
          </a>
        </header>
        <!--フラッシュメッセージ-->
        <?php if ($flash_message !== '') { ?>
          <div class="message">
            <p class="flash"><?php echo $flash_message; ?></p>
          </div>
        <?php } ?>
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
        
        <div class="login-register-form">
          <div class="login-form">
            <form action="dashboard.php" method="post">
              <div class="admin_name">
                <input type="text" name="admin_name" placeholder="管理者ネーム" value="<?php print h($cookie_name); ?>" >
                <!-- <small class="sub">半角英数字、６文字以上で入力してください</small> -->
              </div>
              <div class="password">
                <input type="password" name="password" value="" placeholder="パスワード">
                <!-- <small class="sub">半角英数字、６文字以上で入力してください</small> -->
              </div>
              <!--<p>-->
              <!--  <a href="">パスワードをお忘れですか？</a>-->
              <!--</p>-->
              <span class="block small">
                <input id="cookie_check" type="checkbox" name="cookie_check" value="checked" <?php print h($cookie_check); ?> >
                <label for="cookie_check" >次回から管理者ネームの入力を省略</label>
              </span>
              <div class="form-buttonwrap">
                <a href="<?php echo url_for('admin_accounts', 'signup'); ?>">
                  <input type="button" value="新規登録">
                </a>
                <input type="submit" value="ログインする">
                <input type="hidden" name="module" value="admin_accounts">
                <input type="hidden" name="action" value="login">
                <input type="hidden" name="token" value="<?=h($token)?>">
              </div>
            </form>
          </div>
        </div>
        
      </div>
    </div>
  </main>
  <footer>
    
  </footer>
</body>

</html>