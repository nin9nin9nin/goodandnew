<?php
$title = 'goodandnew管理画面';
$description = '説明（イベント編集ページ）';
$is_home = NULL; //トップページの判定用の変数
$flash_message = Session::getFlash(); // フラッシュメッセージの取得
$token = Session::getCsrfToken(); // トークンの取得
include './include/view/_inc/admin/head.php'; // head.php の読み込み
?>
</head>

<body>
  <?php include './include/view/_inc/admin/header.php'; ?>
  
  <main>
    <!--タイトルナビ---------------------------------------------------------------------------------------------------->
    <div id="title">
      <div class="container">  
      
        <nav class="title-nav">
          <span>
            <a href="<?php echo url_for('admin_brands', 'index'); ?>">ブランド管理</a>
          </span>
          <span>&gt;</span>
          <span>
            <a href="dashboard.php?module=admin_brands&action=edit&brand_id=<?php print h($record->brand_id); ?>">ブランド詳細</a>
          </span>
        </nav>
        
        <div class="title">
          <h1>ブランド詳細</h1>
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
        
        <!--create タイトル-->
        <div class="title">
          <h2>ブランド情報変更</h2>
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
                  <label for="new_brand_id">ブランドID：</label>
                </th>
                <td>
                  <span class="raw_data"><?php print h($record -> brand_id); ?></span>
                </td>
              </tr>
              <tr class="form-text">
                <th>
                  <label for="brand_name">ブランド名：</label>
                </th>
                <td>
                  <input id="brand_name" type="text" name="brand_name" value="<?php print h($record -> brand_name); ?>">
                </td>
              </tr>
              <tr class="form-text">
                <th>
                  <label for="description">ブランド説明：</label>
                </th>
                <td>
                  <textarea id="description" name="description" value="" placeholder="テキストを入力"><?php print h($record -> description); ?></textarea>
                </td>
              </tr>
              <!--ブランドロゴ-->
              <tr class="form-file">
                <th>
                  <label for="brand_logo">ブランドロゴ：</label><span class="ninni">任意</span>
                  <span class="files-addition">ファイル形式&nbsp;png</span>
                </th>
                <td>
                  <div class="update-img">
                    <img src="<?php print h('./include/images/brands/logo/' .$record->brand_logo); ?>">
                  </div>
                  <div class="img-button">
                    <input id="brand_logo" type="file" name="brand_logo" value="">
                    <input id="exists_logo" type="hidden" name="exists_logo" value="<?php print h($record->brand_logo); ?>">
                  </div>
                </td>
              </tr>
              <!--画像-->
              <tr class="form-file">
                <th>
                  <label for="brand_img">画像：</label>
                  <span class="files-addition">ファイル形式&nbsp;jpeg&nbsp;※8枚まで可能</span>
                </th>
                <td>
                  <div class="update-img">
                    <img src="<?php print h('./include/images/brands/img/' .$record->img1); ?>">
                  </div>
                  <div class="img-button">
                    <a href="dashboard.php?module=admin_brands&action=edit_img&brand_id=<?php print h($record->brand_id); ?>">
                      <input type="button" value="全ての画像を確認する">
                    </a>
                  </div>
                </td>
              </tr>
              <tr class="form-text">
                <th>
                  <label for="brand_hp">ブランドHP：</label>
                </th>
                <td>
                  <input id="brand_hp" type="url" name="brand_hp" value="<?php print h($record -> brand_hp); ?>" placeholder="https://www.○○○.com">
                </td>
              </tr>
              <tr class="form-text">
                <th>
                  <label for="brand_instagram">Instagram：</label>
                </th>
                <td>
                  <input id="brand_instagram" type="url" name="brand_instagram" value="<?php print h($record -> brand_instagram); ?>" placeholder="https://www.instagram.com/...">
                </td>
              </tr>
              <tr class="form-text">
                <th>
                  <label for="brand_twitter">Twitter：</label>
                </th>
                <td>
                  <input id="brand_twitter" type="url" name="brand_twitter" value="<?php print h($record -> brand_twitter); ?>" placeholder="https://www.twitter.com/...">
                </td>
              </tr>
              <tr class="form-text">
                <th>
                  <label for="brand_facebook">Facebook：</label>
                </th>
                <td>
                  <input id="brand_facebook" type="url" name="brand_facebook" value="<?php print h($record -> brand_facebook); ?>" placeholder="https://www.facebook.com/ ...">
                </td>
              </tr>
              <tr class="form-text">
                <th>
                  <label for="brand_youtube">Youtube：</label>
                </th>
                <td>
                  <input id="brand_youtube" type="url" name="brand_youtube" value="<?php print h($record -> brand_youtube); ?>" placeholder="https://www.youtube.com/ ...">
                </td>
              </tr>
              <tr class="form-text">
                <th>
                  <label for="brand_line">LINE：</label>
                </th>
                <td>
                  <input id="brand_line" type="url" name="brand_line" value="<?php print h($record -> brand_line); ?>" placeholder="https://line.me/ ...">
                </td>
              </tr>
              <tr class="form-text">
                <th>
                  <label for="phone_number">電話番号：</label>
                </th>
                <td>
                  <input id="phone_number" type="tel" name="phone_number" value="<?php print h($record -> phone_number); ?>" placeholder="※ハイフンなし">
                </td>
              </tr>
              <tr class="form-text">
                <th>
                  <label for="email">メールアドレス：</label>
                </th>
                <td>
                  <input id="email" type="email" name="email" value="<?php print h($record -> email); ?>" placeholder="">
                </td>
              </tr>
              <tr class="form-text">
                <th>
                  <label for="address">住所：</label>
                </th>
                <td>
                  <input id="address" type="text" name="address" value="<?php print h($record -> address); ?>" placeholder="">
                </td>
              </tr>
              <tr class="form-text">
                <th>
                  商品数:
                </th>
                <td>
                  <?php print h($record -> item_count); ?>
                </td>
              </tr>
              <!--ステータス-->
              <tr class="form-checkbox">
                <th>
                  ステータス：
                </th>
                <td>
                  <input id="status" type="checkbox" name="status" value="1" class="checkbox-input" <?= $record -> status ? 'checked' : '' ?>>
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
                  <?php print h($record -> getCreateDateTime()); ?>
                </td>
              </tr>
              <?php if(isset($record->update_datetime)) { ?>
              <tr class="form-text">
                <th>
                  最終更新日時:
                </th>
                <td>
                  <?php print h($record -> getUpdateDateTime()); ?>
                </td>
              </tr>
              <?php } ?>
            </table>
            <!--submit+hidden-->
            <div class="form-buttonwrap">
              <a href="<?php echo url_for('admin_brands', 'index'); ?>">  
                <input type="button" value="キャンセル">
              </a>
              <input type="submit" value="変更する">
              <input type="hidden" name="module" value="admin_brands">
              <input type="hidden" name="action" value="update">
              <input type="hidden" name="brand_id" value="<?php print h($record->brand_id); ?>">
              <input type="hidden" name="token" value="<?=h($token)?>">
            </div>
          </form>
        </div>
      </div>
    </div>
    <?php include './include/view/_inc/admin/homebutton.php'; ?>
  </main>
  
 <?php include './include/view/_inc/admin/footer.php'; ?>
</body>

</html>