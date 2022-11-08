<?php
$title = 'goodandnew管理画面';
$description = '説明（新規登録ページ）';
$is_home = NULL; //トップページの判定用の変数
$flash_message = Session::getFlash();
$token = Session::getCsrfToken(); // トークンの取得
$cookie_check = Cookie::getCookieCheck();
$cookie_name = Cookie::getCookieName();
include './include/view/_inc/admin/head.php'; // head.php の読み込み
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
          <div class="register-form">
            <form action="dashboard.php" method="post">
              <div class="admin_name">
                <input type="text" name="admin_name" value="" placeholder="管理者ネーム">
                <small class="sub">半角英数字、６文字以上で入力してください</small>
              </div>
              <div class="email">
                <input type="text" name="email" value="" placeholder="メールアドレス">
              </div>
              <div class="password">
                <input type="password" name="password" value="" placeholder="パスワード">
                <small class="sub">半角英数字、６文字以上で入力してください</small>
              </div>
              <span class="block small">
                <input id="cookie_check" type="checkbox" name="cookie_check" value="checked" >
                <label for="cookie_check" >次回から管理者ネームの入力を省略</label>
              </span>
              <div class="form-buttonwrap">
                <a href="<?php echo url_for('admin_accounts', 'signin'); ?>">
                  <input type="button" value="キャンセル">
                </a>
                <input type="submit" value="登録する">
                <input type="hidden" name="module" value="admin_accounts">
                <input type="hidden" name="action" value="register">
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