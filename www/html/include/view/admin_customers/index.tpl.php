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
            <a href="<?php echo url_for('admin_customers', 'index'); ?>">顧客管理</a>
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
          <h2>顧客情報</h2>
        </div>
        
        <!--list 一覧テーブル-->
        <div class="list-group">
          <!--list 並べ替え-->
          
          <table>
            <caption>顧客情報一覧</caption>
            <thead>
              <tr>
                <th class="list-id">ID</th>
                <th class="list-name">顧客名</th>
                <th class="list-info">登録日時</th>
                <th class="list-info">最終利用</th>
                <th class="list-count">利用回数</th>
                <th class="list-detail"></th>
              </tr>
            </thead>
            <?php if(count($records['customers']) > 0) { ?>
            <tbody>
              <?php foreach ($records['customers'] as $record) { ?>
              <tr class="<?= $record->enabled ? 'true' : 'false' ?>">
                <td class="list-id">
                  <?php print h($record->customer_id); ?>
                </td>
                <td class="list-name">
                  <a href="dashboard.php?module=admin_customers&action=detail&customer_id=<?php print h($record->customer_id); ?>">
                    <ul>
                      <li class="name_kana"><?php print h($record->name_kana); ?></li>
                    </ul>
                    <p class="name_kanji"><?php print h($record->name_kanji); ?></p>
                  </a>
                </td>
                <td class="list-info">
                  <?php print h($record->getCreateDateTime()); ?>
                </td>
                <td class="list-info">
                  <?php print h($record->getLastOrderDateTime()); ?>
                </td>
                <td class="list-info short">
                  <?php print h($record->order_count); ?>
                </td>
                <!--詳細リンク-->
                <td>
                  <div class="list-detail">
                    <a href="dashboard.php?module=admin_customers&action=detail&customer_id=<?php print h($record->customer_id); ?>">
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