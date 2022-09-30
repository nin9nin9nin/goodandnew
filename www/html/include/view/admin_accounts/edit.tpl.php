<?php
$title = 'ec site 管理画面';
$description = '説明（アカウント情報変更ページ）';
// $is_home = true; //トップページの判定用の変数
include 'inc/admin/head.php'; // head.php の読み込み
?>
</head>

<body>
  <?php include 'inc/admin/header.php'; ?>
  
  <main>
    <!--タイトルナビ---------------------------------------------------------------------------------------------------->
    <div id="title">
      <div class="container">  
      
        <nav class="title-nav">
          <span>
            <a href="<?php echo url_for('admin_accounts', 'index'); ?>">アカウント</a>
          </span>
          <span>&gt;</span>
          <span>
            <a href="dashboard.php?module=admin_accounts&action=edit&admin_id=<?php print h($record->admin_id); ?>">アカウント情報</a>
          </span>
        </nav>
        
        <div class="title">
          <h1>アカウント情報</h1>
        </div>
        
      </div>
    </div>
    <!---アカウント情報----------------------------------------------------------------------------------------------------------->
    <div id="accounts">
      <div class="container">
        
        <!--create タイトル-->
        <div class="title">
          <h2>登録情報変更</h2>
        </div>
        
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
        
        <!--入力フォーム-->
        <div class="update-form">
          <form action="dashboard.php" method="post" >
            <table class="update-form table">
              <tr class="form-text">
                <th>
                  ID:
                </th>
                <td>
                  <?php print h($record -> admin_id); ?>
                </td>
              </tr>
              <tr class="form-text">
                <th>
                  <label for="admin_name">管理者ネーム：</label><span class="hissu">必須</span>
                </th>
                <td>
                  <input id="admin_name" type="text" name="admin_name" value="<?php print h($record -> admin_name); ?>">
                </td>
              </tr>
              <tr class="form-text">
                <th>
                  <label for="email">メールアドレス：</label><span class="hissu">必須</span>
                </th>
                <td>
                  <input id="email" type="email" name="email" value="<?php print h($record -> email); ?>">
                </td>
              </tr>
              <tr class="form-text">
                <th>
                  <label for="old_password">旧パスワード：</label><span class="hissu">必須</span>
                </th>
                <td>
                  <input id="old_password" type="password" name="old_password" value="">
                </td>
              </tr>
              <tr class="form-text">
                <th>
                  <label for="password">新パスワード：</label><span class="ninni">任意</span>
                </th>
                <td>
                  <input id="password" type="password" name="password" value="">
                </td>
              </tr>
              <tr class="form-text">
                <th>
                  <label for="check_password">確認用：</label>
                </th>
                <td>
                  <input id="check_password" type="password" name="check_password" value="">
                </td>
              </tr>
              <tr class="form-text">
                <th>
                  登録日時:
                </th>
                <td>
                  <?php print h($record -> getCreateDateTime()); ?>
                </td>
              </tr>
            </table>
              <!--submit+hidden-->
              <div class="form-buttonwrap">
                <a href="<?php echo url_for('admin_accounts', 'index'); ?>">
                  <input type="button" value="キャンセル">
                </a>
                <input type="submit" value="変更する">
                <input type="hidden" name="module" value="admin_accounts">
                <input type="hidden" name="action" value="update">
                <input type="hidden" name="admin_id" value="<?php print h($record -> admin_id); ?>">
                <input type="hidden" name="old_admin_name" value="<?php print h($record -> admin_name); ?>">
              </div>
          </form>
        </div>
      </div>
    </div>
    
    <div id="home">
      <div class="container">
        <div class="home">
          <div class="form-buttonwrap">
              <input type="button" value="ホーム画面に戻る" onclick="location.href='dashboard.php'">
          </div>
        </div>
      </div>
    </div>
    
  </main>
  
 <?php include 'inc/admin/footer.php'; ?>
</body>

</html>