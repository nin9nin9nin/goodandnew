<?php
$title = 'ec site 管理画面';
$description = '説明（アイテム編集完了ページ）';
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
            <a href="dashboard.php?module=admin_items&action=edit&item_id=<?php print h($records[0]->item_id); ?>">商品詳細</a>
          </span>
          <span>&gt;</span>
          <span>
            更新完了
          </span>
        </nav>
        
        <div class="title">
          <h1>更新完了</h1>
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
            <p class="h4 text-muted">商品情報を更新しました</p>
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
                <th class="list-img">画像</th>
                <th class="list-name">商品名</th>
                <th class="list-info">価格（税込）</th>
                <th class="list-stock">在庫数</th>
                <th class="list-status">ステータス</th>
                <th class="list-delete">削除</th>
                <th class="list-detail"></th>
              </tr>
            </thead>
            <tbody>
              <tr class="<?= $records[0]->status ? 'true' : 'false' ?>">
                <td class="list-img">
                  <a href="dashboard.php?module=admin_items&action=img_edit&item_id=<?php print h($records[0]->item_id); ?>">
                    <img src="<?php print h('./include/img/' .$records[0]->icon_img); ?>">
                  </a>
                </td>
                <td class="list-name">
                  <a href="dashboard.php?module=admin_items&action=edit&item_id=<?php print h($records[0]->item_id); ?>">
                    <ul>
                      <li class="category_name"><?php print h($records[0]->category_name); ?></li>
                      <li class="brand_name"><?php print h($records[0]->brand_name); ?></li>
                      <li class="shop_name"><?php print h($records[0]->shop_name); ?></li>
                    </ul>
                    <p class="item-name"><?php print h($records[0]->item_name); ?></p>
                  </a>
                </td>
                <td class="list-price">
                  <?php print h($records[0]->getPrice()); ?>
                </td>
                <td class="list-stock">
                  <?php print h($records[0]->getStock()); ?>
                </td>
                <!--ステータス-->
                <td class="list-status">
                  <div class="status-checkbox">
                    <form action="dashboard.php" method="post">
                      <input id="status_<?php print h($records[0]->item_id); ?>" type="checkbox" name="status" value="1" ONCHANGE="this.form.submit();" <?= $records[0]->status ? 'checked' : '' ?> >
                      <label for="status<?php print h($records[0]->item_id); ?>">
                        <span></span>
                      </label>
                      <div class="list-switch"></div>
                      <input type="hidden" name="module" value="admin_items">
                      <input type="hidden" name="action" value="update-status">
                      <input type="hidden" name="table" value="items">
                      <input type="hidden" name="item_id" value="<?php print h($records[0]->item_id); ?>">
                    </form>
                  </div>
                </td>
                <!--削除ボタン-->
                <td>
                  <div class="list-delete">
                    <form action="dashboard.php" method="post" id="delete_form">
                      <input type="submit" value="削除">
                      <input type="hidden" name="module" value="admin_items">
                      <input type="hidden" name="action" value="delete">
                      <input type="hidden" name="item_id" value="<?php print h($records[0]->item_id); ?>">
                    </form>
                  </div>
                </td>
                <!--詳細リンク-->
                <td>
                  <div class="list-detail">
                    <a href="dashboard.php?module=admin_items&action=edit&item_id=<?php print h($records[0]->item_id); ?>">
                      <span>詳細</span>
                    </a>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
          <!--submit+hidden-->
          <div class="form-buttonwrap">
            <a href="<?php echo url_for('admin_items', 'index'); ?>">  
              <input type="button" value="商品一覧に戻る">
            </a>
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