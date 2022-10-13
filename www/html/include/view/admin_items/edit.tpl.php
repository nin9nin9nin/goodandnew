<?php
$title = 'ec site 管理画面';
$description = '説明（アイテム編集ページ）';
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
        </nav>
        
        <div class="title">
          <h1>商品詳細</h1>
        </div>
        
      </div>
    </div>
    <!---更新----------------------------------------------------------------------------------------------------------->
    <div id="update">
      <div class="container">
        
        <!--create タイトル-->
        <div class="title">
          <h2>新規情報変更</h2>
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
                  <input id="item_name" type="text" name="item_name" value="<?php print h($records[0] -> item_name); ?>">
                </td>
              </tr>
              <tr class="form-select">
                <th>
                  <label for="category_id">ジャンル：</label>
                </th>
                <td>
                  <select id="category_id" name="category_id">
                    <option value="<?php print h($records[0] -> category_id); ?>"><?php print h($records[0] -> category_name); ?></option>
                    <option value="0">未設定</option>
                    <?php foreach ($records['categorys'] as $record) { ?>
                    <option value="<?php print h($record->category_id); ?>"><?php print h($record->category_name)?></option>
                    <?php } ?>
                  </select>
                </td>
              </tr>
              <tr class="form-select">
                <th>
                  <label for="brand_id">ブランド：</label>
                </th>
                <td>
                  <select id="brand_id" name="brand_id">
                    <option value="<?php print h($records[0] -> brand_id); ?>"><?php print h($records[0] -> brand_name); ?></option>
                    <option value="0">未設定</option>
                    <?php foreach ($records['brands'] as $record) { ?>
                    <option value="<?php print h($record->brand_id); ?>"><?php print h($record->brand_name)?></option>
                    <?php } ?>
                  </select>
                </td>
              </tr>
              <tr class="form-select">
                <th>
                  <label for="shop_id">ショップ：</label>
                </th>
                <td>
                  <select id="shop_id" name="shop_id">
                    <option value="<?php print h($records[0] -> shop_id); ?>"><?php print h($records[0] -> shop_name); ?></option>
                    <option value="0">未設定</option>
                    <?php foreach ($records['shops'] as $record) { ?>
                    <option value="<?php print h($record->shop_id); ?>"><?php print h($record->shop_name)?></option>
                    <?php } ?>
                  </select>
                </td>
              </tr>
              <tr class="form-text">
                <th>
                  <label for="price">価格（税込）：</label>
                </th>
                <td>
                  <input id="price" type="text" name="price" value="<?php print h($records[0]->price)?>">
                </td>
              </tr>
              <tr class="form-text">
                <th>
                  <label for="stock">在庫数：</label>
                </th>
                <td>
                  <input id="stock" type="text" name="stock" value="<?php print h($records[0]->stock)?>">
                </td>
              </tr>
              <tr class="form-text">
                <th>
                  <label for="description">商品説明：</label>
                </th>
                <td>
                  <textarea id="description" name="description" value="" placeholder="テキストを入力"><?php print h($records[0]->description)?></textarea>
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
                    <a href="dashboard.php?module=admin_items&action=img_edit&item_id=<?php print h($records[0]->item_id); ?>">
                      <input type="button" value="画像を変更する">
                    </a>
                    <!--<input id="file" type="file" name="icon_img" value="">-->
                  </div>
                </td>
              </tr>
              <!--ステータス-->
              <tr class="form-checkbox">
                <th>
                  ステータス：
                </th>
                <td>
                  <input id="status" type="checkbox" name="status" value="1" class="checkbox-input" <?= $records[0]->status ? 'checked' : '' ?>>
                    <label for="status" class="checkbox-label">
                      <span class="checkbox-span"></span>
                    </label>
                </td>
              </tr>
            </table>
              <!--submit+hidden-->
              <div class="form-buttonwrap">
                <a href="<?php echo url_for('admin_items', 'index'); ?>">  
                  <input type="button" value="キャンセル">
                </a>
                <input type="submit" value="変更する">
                <input type="hidden" name="module" value="admin_items">
                <input type="hidden" name="action" value="update">
                <input type="hidden" name="item_id" value="<?php print h($records[0]->item_id); ?>">
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