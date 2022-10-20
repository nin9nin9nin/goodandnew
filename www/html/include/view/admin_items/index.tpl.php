<?php
$title = 'ec site 管理画面';
$description = '説明（アイテム管理ページ）';
// $is_home = true; //トップページの判定用の変数
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
            <a href="<?php echo url_for('admin_items', 'index'); ?>">商品管理</a>
          </span>
          <span>&gt;</span>
        </nav>
        
        <div class="title">
          <h1>商品管理</h1>
        </div>
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
      </div>
    </div>
    <!---登録----------------------------------------------------------------------------------------------------------->
    <div id="create">
      <div class="container">
        
        <!--create タイトル-->
        <div class="title">
          <h2>新規商品追加</h2>
        </div>
        
        <!--入力フォーム-->
        <div class="create-form">
          <form action="dashboard.php" method="post" enctype="multipart/form-data">
            <table class="create-form table">
              <tr class="form-text">
                <th>
                  <label for="item_name">名前：</label><span class="hissu">必須</span>
                </th>
                <td>
                  <input id="item_name" type="text" name="item_name" value="">
                </td>
              </tr>
              <tr class="form-select">
                <th>
                  <label for="category_id">ジャンル：</label><span class="ninni">任意</span>
                </th>
                <td>
                  <select id="category_id" name="category_id">
                    <option value="0">未設定</option>
                    <?php foreach ($records['categorys'] as $record) { ?>
                    <option value="<?php print h($record->category_id); ?>"><?php print h($record->category_name)?></option>
                    <?php } ?>
                  </select>
                </td>
              </tr>
              <tr class="form-select">
                <th>
                  <label for="brand_id">ブランド：</label><span class="ninni">任意</span>
                </th>
                <td>
                  <select id="brand_id" name="brand_id">
                    <option value="0">未設定</option>
                    <?php foreach ($records['brands'] as $record) { ?>
                    <option value="<?php print h($record->brand_id); ?>"><?php print h($record->brand_name)?></option>
                    <?php } ?>
                  </select>
                </td>
              </tr>
              <tr class="form-select">
                <th>
                  <label for="shop_id">ショップ：</label><span class="ninni">任意</span>
                </th>
                <td>
                  <select id="shop_id" name="shop_id">
                    <option value="0">未設定</option>
                    <?php foreach ($records['shops'] as $record) { ?>
                    <option value="<?php print h($record->shop_id); ?>"><?php print h($record->shop_name)?></option>
                    <?php } ?>
                  </select>
                </td>
              </tr>
              <tr class="form-text">
                <th>
                  <label for="price">価格（税込）：</label><span class="hissu">必須</span>
                </th>
                <td>
                  <input id="price" type="text" name="price" value="">
                </td>
              </tr>
              <tr class="form-text">
                <th>
                  <label for="stock">在庫数：</label><span class="hissu">必須</span>
                </th>
                <td>
                  <input id="stock" type="text" name="stock" value="">
                </td>
              </tr>
              <tr class="form-text">
                <th>
                  <label for="description">商品説明：</label><span class="ninni">任意</span>
                </th>
                <td>
                  <textarea id="description" name="description" value="" rows="10" cols="60" placeholder="テキストを入力"></textarea>
                </td>
              </tr>
              <!--商品画像-->
              <tr class="form-file">
                <th>
                  <label for="file">画像：</label><span class="hissu">必須</span>
                </th>
                <td>
                  <input id="file" type="file" name="icon_img" value="">
                </td>
              </tr>
              <!--ステータス-->
              <tr class="form-checkbox">
                <th>
                  ステータス：<span class="ninni">任意</span>
                </th>
                <td>
                  <input id="status" type="checkbox" name="status" value="1" class="checkbox-input">
                    <label for="status" class="checkbox-label">
                      <span class="checkbox-span"></span>
                    </label>
                </td>
              </tr>
            </table>
              <!--submit+hidden-->
              <div class="form-buttonwrap">
                <input type="reset" value="リセット">
                <input type="submit" value="商品を追加">
                <input type="hidden" name="module" value="admin_items">
                <input type="hidden" name="action" value="create">
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
            <caption>商品一覧</caption>
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
            <?php if(count($records['items']) > 0) { ?>
            <tbody>
              <?php foreach ($records['items'] as $record) { ?>
              <tr class="<?= $record->status ? 'true' : 'false' ?>">
                <td class="list-img">
                  <a href="dashboard.php?module=admin_items&action=img_edit&item_id=<?php print h($record->item_id); ?>">
                    <img src="<?php print h('./include/img/' .$record->icon_img); ?>">
                  </a>
                </td>
                <td class="list-name">
                  <a href="dashboard.php?module=admin_items&action=edit&item_id=<?php print h($record->item_id); ?>">
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
                  <?php print h($record->getStock()); ?>
                </td>
                <!--ステータス-->
                <td class="list-status">
                  <div class="status-checkbox">
                    <form action="dashboard.php" method="post">
                      <input id="status_<?php print h($record->item_id); ?>" type="checkbox" name="status" value="1" ONCHANGE="submit(this.form)" <?= $record->status ? 'checked' : '' ?> >
                      <label for="status_<?php print h($record->item_id); ?>">
                        <span></span>
                      </label>
                      <div class="list-switch"></div>
                      <input type="hidden" name="module" value="admin_items">
                      <input type="hidden" name="action" value="update_status">
                      <input type="hidden" name="item_id" value="<?php print h($record->item_id); ?>">
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
                      <input type="hidden" name="item_id" value="<?php print h($record->item_id); ?>">
                    </form>
                  </div>
                </td>
                <!--詳細リンク-->
                <td>
                  <div class="list-detail">
                    <a href="dashboard.php?module=admin_items&action=edit&item_id=<?php print h($record->item_id); ?>">
                      <span>詳細</span>
                    </a>
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
              <a href="<?php echo url_for('admin_items', 'stock_edit'); ?>">
                <input type="button" value="在庫一覧に移動">
              </a>
              <input type="submit" value="全てを削除する">
              <input type="hidden" name="module" value="admin_items">
              <input type="hidden" name="action" value="delete_all">
              <input type="hidden" name="table" value="items">
            </form>
          </div>
        </div>
      </div>
    </div>
    
    <!-- <div id="home">
      <div class="container">
        <div class="home">
          <div class="form-buttonwrap">
              <input type="button" value="ホーム画面に戻る" onclick="location.href='dashboard.php'">
          </div>
        </div>
      </div>
    </div> -->
    <?php include 'inc/admin/pagination.php'; ?>
    <?php include 'inc/admin/home.php'; ?>
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