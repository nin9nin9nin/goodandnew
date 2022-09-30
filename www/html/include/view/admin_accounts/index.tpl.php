<?php
$title = 'ec site 管理画面';
$description = '説明（アカウント管理ページ）';
//$is_home = true; //トップページの判定用の変数
$flash_message = Session::getFlash();
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
            <a href="<?php echo url_for('admin_accounts', 'index'); ?>">アカウント管理</a>
          </span>
          <span>&gt;</span>
        </nav>
        
        <div class="title">
          <h1>アカウント管理</h1>
        </div>
        
      </div>
    </div>
    <!---アカウント情報----------------------------------------------------------------------------------------------------------->
    <div id="accounts">
      <div class="container">
        
        <!--create タイトル-->
        <div class="title">
          <h2>アカウント情報</h2>
        </div>
        <!--フラッシュメッセージ-->
        <?php if ($flash_message !== '') { ?>
          <div class="message">
            <p class="flash"><?php echo $flash_message; ?></p>
          </div>
        <?php } ?>
        <!--入力フォーム-->
        <div class="create-form">
          <form action="dashboard.php" method="post" >
            <table class="create-form table">
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
                  管理者ネーム:
                </th>
                <td>
                  <?php print h($record -> admin_name); ?>
                </td>
              </tr>
              <tr class="form-text">
                <th>
                  メールアドレス:
                </th>
                <td>
                  <?php print h($record -> email); ?>
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
                <a href="dashboard.php?module=admin_accounts&action=edit&admin_id=<?php print h($record->admin_id); ?>">
                  <input type="button" value="アカウント情報">
                </a>
                <input type="submit" value="ログアウト">
                <input type="hidden" name="module" value="admin_accounts">
                <input type="hidden" name="action" value="logout">
                <input type="hidden" name="admin_id" value="<?php print h($record->admin_id); ?>">
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