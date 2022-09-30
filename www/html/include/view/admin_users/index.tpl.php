<?php
$title = 'ec site 管理画面';
$description = '説明（顧客管理ページ）';
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
            <a href="<?php echo url_for('admin_users', 'index'); ?>">ユーザー管理</a>
          </span>
          <span>&gt;</span>
        </nav>
        
        <div class="title">
          <h1>顧客管理</h1>
        </div>
        
      </div>
    </div>
    <!--検索機能------------------------------------------------------------------------------------------------------------>
    <div id="search">
      <div class="container">
      
      </div>
    </div>
    <!--顧客------------------------------------------------------------------------------------------------------------>
    <div id="list">
      <div class="container">
        
        <!--list タイトル-->
        <div class="title">
          <h2>ユーザー情報</h2>
        </div>
        
        <!--list 一覧テーブル-->
        <div class="list-group">
          <!--list 並べ替え-->
          
          <table>
            <caption>ユーザー一覧</caption>
            <thead>
              <tr>
                <th class="list-id">ID</th>
                <th class="list-name">ユーザーネーム</th>
                <th class="list-info">登録日時</th>
                <th class="list-detail"></th>
              </tr>
            </thead>
            <?php if(count($records['users']) > 0) { ?>
            <tbody>
              <?php foreach ($records['users'] as $record) { ?>
              <tr>
                <td class="list-id">
                  <?php print h($record->user_id); ?>
                </td>
                <td class="list-name">
                  <a href="dashboard.php?module=admin_users&action=detail&user_id=<?php print h($record->user_id); ?>">
                    <?php print h($record->user_name); ?>
                  </a>
                </td>
                <td class="list-info">
                  <?php print h($record->getCreateDateTime()); ?>
                </td>
                <!--詳細リンク-->
                <td>
                  <div class="list-detail">
                    <a href="dashboard.php?module=admin_users&action=detail&user_id=<?php print h($record->user_id); ?>">
                      <span>詳細</span>
                    </a>
                  </div>
                </td>
              </tr>
              <?php } ?>
            </tbody>
              <?php } else { ?>
              <p class="errors">顧客情報がありません。</p>
              <?php } ?>
          </table>
        </div>
        <!--ページボタン設置-->
        <div class="page-buttonwrap">
          <form action="dashboard.php" method="post">
            <ul>
              <li><a></a></li>
            </ul>
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