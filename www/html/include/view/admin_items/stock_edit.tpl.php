<?php
$title = 'ec site 管理画面';
$description = '説明（在庫一覧ページ）';
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
            <a href="<?php echo url_for('admin_items', 'index'); ?>">商品管理</a>
          </span>
          <span>&gt;</span>
          <span>
            <a href="<?php echo url_for('admin_items', 'stock_edit'); ?>">在庫一覧</a>
          </span>
        </nav>
        
        <div class="title">
          <h1>在庫一覧</h1>
        </div>
        
      </div>
    </div>
    <!--在庫------------------------------------------------------------------------------------------------------------>
    <div id="list">
      <div class="container">
        
        <!--list タイトル-->
        <div class="title">
          <h2>在庫情報</h2>
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
        
        <!--list 一覧テーブル-->
        <div class="list-group">
          
          <table>
            <caption>在庫一覧</caption>
            <thead>
              <tr>
                <th class="list-img">画像</th>
                <th class="list-name">商品名</th>
                <th class="list-info">価格（税込）</th>
                <th class="list-stock">在庫数</th>
                <th class="list-change"></th>
              </tr>
            </thead>
            <?php if(count($records['items']) > 0) { ?>
            <tbody>
              <?php foreach ($records['items'] as $record) { ?>
              <tr class="<?= $record->status ? 'true' : 'false' ?>">
                <td class="list-img">
                  <a href="dashboard.php?module=imgs&action=edit&item_id=<?php print h($record->item_id); ?>">
                    <img src="<?php print h('./include/img/' .$record->icon_img); ?>">
                  </a>
                </td>
                <td class="list-name">
                  <a href="dashboard.php?module=items&action=edit&item_id=<?php print h($record->item_id); ?>">
                    <ul>
                      <li class="category_name"><?php print h($record->category_name); ?></li>
                      <li class="brand_name"><?php print h($record->brand_name); ?></li>
                      <li class="shop_name"><?php print h($record->shop_name); ?></li>
                    </ul>
                    <p class="item-name"><?php print h($record->item_name); ?></p>
                  </a>
                </td>
                <td class="list-price">
                  <?php print h($record->getPrice()); ?>
                </td>
                <td class="list-stock">
                  <form action="dashboard.php" method="post" id="stocks">
                    <input type="text" name="stock" value="<?php print h($record->stock); ?>">
                </td>
                <!--変更ボタン-->
                <td>
                  <div class="list-change">
                      <input type="submit" value="変更">
                      <input type="hidden" name="module" value="admin_items">
                      <input type="hidden" name="action" value="update_stock">
                      <input type="hidden" name="item_id" value="<?php print h($record->item_id); ?>">
                    </form>
                  </div>
                </td>
              </tr>
              <?php } ?>
            </tbody>
              <?php } else { ?>
              <p class="errors">商品情報がありません。</p>
              <?php } ?>
          </table>
        </div>
        <div class="alldelete">
          <div class="form-buttonwrap">
            <form action="dashboard.php" method="post">
              <a href="<?php echo url_for('admin_items', 'index'); ?>">
                <input type="button" value="商品管理に戻る">
              </a>
            </form>
          </div>
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
  
  <script>
      let delete_form = document.getElementById('delete_form');
      delete_form.addEventListener('submit', (e) => {
        if (!confirm('このメッセージデータを削除してもよろしいですか？')) {
          e.preventDefault();
          return;
        }
      });
    </script>
</body>

</html>