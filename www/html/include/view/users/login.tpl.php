<?php
$title = 'ec site ショップ画面';
$description = '説明（ログイン・ユーザー登録ページ）';
// $is_home = true; //トップページの判定用の変数
//フラッシュメッセージの取得
$flash_message = Session::getInstance()->getFlash();
include 'inc/user/head.php'; // head.php の読み込み
?>
</head>

<body>
  <div id="member" class="big-bg">
    <div class="wrapper">
      <h2 class="page-title">Member</h2>
      <!--フラッシュメッセージ-->
        <?php if ($flash_message !== '') { ?>
          <div class="fade-message">
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
      <div class="input-field">
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
            <div>
            <input type="submit" class="button" value="ログインする">
            <input type="hidden" name="module" value="users">
            <input type="hidden" name="action" value="login">
            </div>
          </form>
        </div>
        <!--/.form-->
        <div id="register" class="form">
          <form action="index.php" method="post">
            <div>
              <label for="user_name">ユーザーネーム</label>
              <input type="text" id="user_name" name="user_name" value="" placeholder="半角英数字,6文字以上">
            </div>
            <div>
              <label for="email">メールアドレス</label>
              <input type="email" id="email" name="email" value="" >
            </div>
            <div>
              <label for="password">パスワード</label>
              <input type="password" id="password" name="password" value="" placeholder="半角英数字,6文字以上">
            </div>
            <div class="block small">
              <input id="cookie_check" type="checkbox" name="cookie_check" value="checked">
              <label for="cookie_check">次回から管理者ネームの入力を省略</label>
            </div>
            <div>
              <input type="submit" class="button" value="登録する">
              <input type="hidden" name="module" value="users">
              <input type="hidden" name="action" value="register">
            </div>
          </form>
        </div><!--/.form-->
      </div><!--/.input-field -->
    </div><!--/.wrapper-->
  </div><!-- / #member .big-bg -->
  <?php include 'inc/user/footer.php'; ?>

  <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
  <script src="./js/user/login.js"></script>
</body>

</html>