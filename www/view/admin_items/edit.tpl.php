<?php
$title = 'goodandnewshop管理画面';
$description = '説明（アイテム編集ページ）';
$is_home = NULL; //トップページの判定用の変数
$flash_message = Session::getFlash(); // フラッシュメッセージの取得
$token = Session::getCsrfToken(); // トークンの取得
include INCLUDE_DIR . '/admin/head.php'; // head.php の読み込み
?>
</head>

<body>
  <?php include INCLUDE_DIR . '/admin/header.php'; ?>
  
  <main>
    <!--タイトルナビ---------------------------------------------------------------------------------------------------->
    <div id="title">
      <div class="container">  
      
        <nav class="title-nav">
          <span>
            <a href="<?php echo url_for('admin_items', 'index'); ?>">アイテム管理</a>
          </span>
          <span>&gt;</span>
          <span>
            <a href="dashboard.php?module=admin_items&action=edit&item_id=<?php print h($records[0]->item_id); ?>">アイテム詳細</a>
          </span>
        </nav>
        
        <div class="title">
          <h1>アイテム詳細</h1>
        </div>
        <!--フラッシュメッセージ-->
        <?php if ($flash_message !== '') { ?>
          <div class="message">
            <p class="fade-message"><?php echo $flash_message; ?></p>
          </div>
        <?php } ?>
      </div>
    </div>
    <!---更新----------------------------------------------------------------------------------------------------------->
    <div id="update">
      <div class="container">
        <!--update タイトル-->
        <div class="title">
          <h2>アイテム情報変更</h2>
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
                  <label for="item_id">ID：</label>
                </th>
                <td>
                  <span class="raw_data"><?php print h($records[0] -> item_id); ?></span>
                </td>
              </tr>
              <tr class="form-text">
                <th>
                  <label for="item_name">アイテム名：</label>
                </th>
                <td>
                  <input id="item_name" type="text" name="item_name" value="<?php print h($records[0] -> item_name); ?>">
                </td>
              </tr>
              <tr class="form-select">
                <th>
                  <label for="category_id">カテゴリ：</label>
                </th>
                <td>
                  <select id="category_id" name="category_id">
                    <option value="<?php print h($records[0] -> category_id); ?>"><?php print h($records[0] -> category_name); ?></option>
                    <option value="">選択してください</option>
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
                    <option value="">選択してください</option>
                    <?php foreach ($records['brands'] as $record) { ?>
                    <option value="<?php print h($record->brand_id); ?>"><?php print h($record->brand_name)?></option>
                    <?php } ?>
                  </select>
                </td>
              </tr>
              <tr class="form-select">
                <th>
                  <label for="event_id">イベント：</label>
                </th>
                <td>
                  <select id="event_id" name="event_id">
                    <option value="<?php print h($records[0] -> event_id); ?>"><?php print h($records[0] -> event_name); ?></option>
                    <option value="">選択してください</option>
                    <?php foreach ($records['events'] as $record) { ?>
                    <option value="<?php print h($record->event_id); ?>"><?php print h($record->event_name)?></option>
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
                  <label for="description">アイテム説明：</label>
                </th>
                <td>
                  <textarea id="description" name="description" value="" placeholder="テキストを入力"><?php print h($records[0]->description)?></textarea>
                </td>
              </tr>
              <!--アイコン画像-->
              <tr class="form-file">
                <th>
                  <label for="icon_img">アイコン画像：</label>
                  <span class="files-addition">ファイル形式&nbsp;png</span>
                </th>
                <td>
                  <div class="update-img">
                    <img src="<?php print h(ITEMS_ICON_DIR . $records[0]->icon_img); ?>">
                  </div>
                  <div class="img-button">
                    <input id="icon_img" type="file" name="icon_img" value="">
                    <input id="exists_icon" type="hidden" name="exists_icon" value="<?php print h($records[0]->icon_img); ?>">
                  </div>
                </td>
              </tr>
              <!--画像-->
              <tr class="form-file">
                <th>
                  <label for="item_img">画像：</label>
                  <span class="files-addition">ファイル形式&nbsp;jpeg&nbsp;※8枚まで可能</span>
                </th>
                <td>
                  <div class="update-img">
                    <img src="<?php print h(ITEMS_IMG_DIR . $records[0]->img1); ?>">
                  </div>
                  <div class="img-button">
                    <a href="dashboard.php?module=admin_items&action=edit_img&item_id=<?php print h($records[0]->item_id); ?>">
                      <input type="button" value="全ての画像を確認する">
                    </a>
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
              <tr class="form-text">
                <th>
                  登録日時:
                </th>
                <td>
                  <?php print h($records[0] -> getCreateDateTime()); ?>
                </td>
              </tr>
              <?php if(isset($records[0]->update_datetime)) { ?>
              <tr class="form-text">
                <th>
                  最終更新日時:
                </th>
                <td>
                  <?php print h($records[0] -> getUpdateDateTime()); ?>
                </td>
              </tr>
              <?php } ?>
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
                <input type="hidden" name="token" value="<?=h($token)?>">
              </div>
          </form>
        </div>
      </div>
    </div>
    <?php include INCLUDE_DIR . '/admin/homebutton.php'; ?>
  </main>
  
 <?php include INCLUDE_DIR . '/admin/footer.php'; ?>
</body>

</html>