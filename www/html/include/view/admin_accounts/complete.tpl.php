<?php
$title = 'ec site 管理画面';
$description = '説明（アカウントの更新完了ページ）';
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
            <a href="dashboard.php?module=admin_accounts&action=edit&admin_id=<?php print h($admin->admin_id); ?>">アカウント情報</a>
          </span>
        </nav>
        
        <div class="title">
          <h1>アカウント情報</h1>
        </div>
        
      </div>
    </div>
    <!---更新完了----------------------------------------------------------------------------------------------------------->
    <div id="update">
      <div class="container">
        
        <!--create タイトル-->
        <div class="title">
          <h2></h2>
        </div>
        
        <div class="message">
          <div class="completed">
            <h1 class="display-2 text-muted">Update Completed</h1>
            <p class="h4 text-muted">アカウント情報を更新しました</p>
          </div>
        </div>
          
      </div>
    </div>
    <!--在庫------------------------------------------------------------------------------------------------------------>
    <div id="list">
      <div class="container">
        
        <!--list タイトル-->
        <div class="title">
          <h2>更新情報</h2>
        </div>
        
        <!--list 一覧テーブル-->
        <div class="list-group">
          
          <table>
            <caption></caption>
            <thead>
              <tr>
                <th class="list-id">ID</th>
                <th class="list-name">管理者</th>
                <th class="list-info">メールアドレス</th>
                <th class="list-info">更新日時</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="list-id">
                  <?php print h($admin -> admin_id); ?>
                </td>
                <td class="list-name">
                  <?php print h($admin -> admin_name); ?>
                </td>
                <td class="list-info">
                  <?php print h($admin -> email); ?>
                </td>
                <td class="list-info">
                  <?php print h($admin -> update_datetime); ?>
                </td>
              </tr>
            </tbody>
          </table>
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