<?php
$title = 'ec site 管理画面';
$description = '説明（新規登録完了ページ）';
$is_home = true; //トップページの判定用の変数
$cookie_check = Cookie::getCookieCheck();
$cookie_name = Cookie::getCookieName();
include './include/view/_inc/admin/head.php'; // head.php の読み込み
?>
</head>

<body>
  <main>
    <!---登録完了----------------------------------------------------------------------------------------------------------->
    <div id="update">
      <div class="container">
        
        <!--create タイトル-->
        <div class="title">
          <h2></h2>
        </div>
        
        <div class="message">
          <div class="completed">
            <h1 class="display-2 text-muted">Register Completed</h1>
            <p class="h4 text-muted">管理者登録出来ました</p>
          </div>
        </div>
          
      </div>
    </div>
    <!--ログイン------------------------------------------------------------------------------------------------------------>
    <div id="login">
      <div class="container">
        
        <header>
          <a <?php echo isset($is_home) ? '': 'href="dashboard.php"' ?>> 
            <h1>管理システム</h1>
          </a>
        </header>
        
        <div class="login-register-form">
          <div class="login-form">
            <form action="dashboard.php" method="post">
              <div class="admin_name">
                <input type="text" name="admin_name" value="<?php print h($cookie_name); ?>" placeholder="管理者ネーム">
                <small class="sub">半角英数字、６文字以上で入力してください</small>
              </div>
              <div class="password">
                <input type="password" name="password" value="" placeholder="パスワード">
                <small class="sub">半角英数字、６文字以上で入力してください</small>
              </div>
              <!--<p>-->
              <!--  <a href="">パスワードをお忘れですか？</a>-->
              <!--</p>-->
              <span class="block small">
                <input id="cookie_check" type="checkbox" name="cookie_check" value="checked" <?php print h($cookie_check); ?>>
                <label for="cookie_check" >次回から管理者ネームの入力を省略</label>
              </span>
              <div class="form-buttonwrap">
                <a href="dashboard.php">
                  <input type="button" value="キャンセル">
                </a>
                <input type="submit" value="ログインする">
                <input type="hidden" name="module" value="admin_accounts">
                <input type="hidden" name="action" value="login">
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