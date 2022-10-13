<?php
$title = 'ec site 管理画面';
$description = '説明（画像編集ページ）';
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
            <a href="dashboard.php?module=admin_items&action=img_edit&item_id=<?php print h($records[0]->item_id); ?>">画像変更</a>
          </span>
        </nav>
        
        <div class="title">
          <h1>画像変更</h1>
        </div>
        
      </div>
    </div>
    <!---更新----------------------------------------------------------------------------------------------------------->
    <div id="update">
      <div class="container">
        
        <!--create タイトル-->
        <div class="title">
          <h2>画像情報変更</h2>
        </div>
        
        <!--エラーメッセージ-->
        <?php if(count($errors) > 0) { ?>
          <ul class="errors">
          <?php foreach($errors as $key => $error) { ?>
            <li>
              <?php print h($error); ?>
            </li>
          <?php } ?>
          </ul>
        <?php } ?>
        
        <!--入力フォーム-->
        <div class="update-form">
          <form action="dashboard.php" method="post" enctype="multipart/form-data">
            <table class="update-form table">
              <tr class="form-text">
                <th>
                  <label for="new_item_id">ID：</label>
                </th>
                <td>
                  <span class="raw_data"><?php print h($records[0] -> item_id); ?></span>
                <!--<input id="new_category_id" type="text" name="new_category_id" value="">-->
                </td>
              </tr>
              <tr class="form-text">
                <th>
                  <label for="item_name">名前：</label>
                </th>
                <td>
                  <span class="raw_data"><?php print h($records[0] -> item_name); ?></span>
                  <!--<input id="item_name" type="text" name="item_name" value="">-->
                </td>
              </tr>
              <!--商品画像-->
              <tr class="form-file">
                <th>
                  <label for="file">画像：</label>
                </th>
                <td>
                  <div class="update-img">
                    <img src="<?php print h('./include/img/' .$records[0]->icon_img); ?>">
                  </div>
                  <div class="img-button">
                    <input id="file" type="file" name="icon_img" value="">
                  </div>
                </td>
              </tr>
            </table>
              <!--submit+hidden-->
              <div class="form-buttonwrap">
                <a href="dashboard.php?module=admin_items&action=edit&item_id=<?php print h($records[0]->item_id); ?>">  
                  <input type="button" value="キャンセル">
                </a>
                <input type="submit" value="変更する">
                <input type="hidden" name="module" value="admin_items">
                <input type="hidden" name="action" value="update_img">
                <input type="hidden" name="item_id" value="<?php print h($records[0]->item_id); ?>">
              </div>
          </form>
        </div>
      </div>
    </div>
    <!--在庫------------------------------------------------------------------------------------------------------------>
    <div id="list">
      <div class="container">
        
        <!--list タイトル-->
        <div class="title">
          <h2>商品情報</h2>
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
                <th class="list-info short">在庫数</th>
                <th class="list-status">ステータス</th>
                <th class="list-delete">削除</th>
                <th class="list-detail"></th>
              </tr>
            </thead>
            <tbody>
              <tr>
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