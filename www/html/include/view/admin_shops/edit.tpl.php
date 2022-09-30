<?php
$title = 'ec site 管理画面';
$description = '説明（ショプ編集ページ）';
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
            <a href="<?php echo url_for('admin_shops', 'index'); ?>">ショップ管理</a>
          </span>
          <span>&gt;</span>
          <span>
            <a href="dashboard.php?module=admin_shops&action=edit&shop_id=<?php print h($records[0]->shop_id); ?>">ショップ詳細</a>
          </span>
        </nav>
        
        <div class="title">
          <h1>ショップ詳細</h1>
        </div>
        
      </div>
    </div>
    <!---更新----------------------------------------------------------------------------------------------------------->
    <div id="update">
      <div class="container">
        
        <!--create タイトル-->
        <div class="title">
          <h2>ショップ情報変更</h2>
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
          <form action="dashboard.php" method="post">
            <table class="update-form table">
              <tr class="form-text">
                <th>
                  <label for="new_shop_id">ショップID：</label>
                </th>
                <td>
                  <span class="raw_data"><?php print h($records[0] -> shop_id); ?></span>
                <!--<input id="new_category_id" type="text" name="new_category_id" value="">-->
                </td>
              </tr>
              <tr class="form-text">
                <th>
                  <label for="shop_name">ショップ名：</label>
                </th>
                <td>
                  <input id="shop_name" type="text" name="shop_name" value="<?php print h($records[0] -> shop_name); ?>">
                </td>
              </tr>
              <tr class="form-text">
                <th>
                  <label for="description">ショップ説明：</label>
                </th>
                <td>
                  <textarea id="description" name="description" value="" placeholder="テキストを入力"><?php print h($records[0] -> description); ?></textarea>
                </td>
              </tr>
              <tr class="form-text">
                <th>
                  <label for="shop_hp">ショップHP：</label>
                </th>
                <td>
                  <input id="shop_hp" type="url" name="shop_hp" value="<?php print h($records[0] -> shop_hp); ?>" placeholder="http://www.○○○.com">
                </td>
              </tr>
              <tr class="form-text">
                <th>
                  <label for="shop_link1">ショップLINK：</label>
                </th>
                <td>
                  <input id="shop_link1" type="url" name="shop_link1" value="<?php print h($records[0] -> shop_link1); ?>" placeholder="https://www.instagram.com/...">
                </td>
              </tr>
              <tr class="form-text">
                <th>
                  <label for="shop_link2">ショップLINK：</label>
                </th>
                <td>
                  <input id="shop_link2" type="url" name="shop_link2" value="<?php print h($records[0] -> shop_link2); ?>" placeholder="https://www.facebook.com/...">
                </td>
              </tr>
              <tr class="form-text">
                <th>
                  <label for="shop_link3">ショップLINK：</label>
                </th>
                <td>
                  <input id="shop_link3" type="url" name="shop_link3" value="<?php print h($records[0] -> shop_link3); ?>" placeholder="https://www.twitter.com/ ...">
                </td>
              </tr>
              <tr class="form-text">
                <th>
                  <label for="shop_link4">ショップLINK：</label>
                </th>
                <td>
                  <input id="shop_link4" type="url" name="shop_link4" value="<?php print h($records[0] -> shop_link4); ?>" placeholder="https://www.youtube.com/ ...">
                </td>
              </tr>
              <tr class="form-text">
                <th>
                  <label for="phone_number">電話番号：</label>
                </th>
                <td>
                  <input id="phone_number" type="tel" name="phone_number" value="<?php print h($records[0] -> phone_number); ?>" placeholder="※ハイフンなし">
                </td>
              </tr>
              <tr class="form-text">
                <th>
                  <label for="email">メールアドレス：</label>
                </th>
                <td>
                  <input id="email" type="email" name="email" value="<?php print h($records[0] -> email); ?>" placeholder="">
                </td>
              </tr>
              <tr class="form-text">
                <th>
                  <label for="address">住所：</label>
                </th>
                <td>
                  <input id="address" type="text" name="address" value="<?php print h($records[0] -> address); ?>" placeholder="">
                </td>
              </tr>
              <!--ステータス-->
              <tr class="form-checkbox">
                <th>
                  ステータス：
                </th>
                <td>
                  <input id="status" type="checkbox" name="status" value="1" class="checkbox-input" <?= $records[0] -> status ? 'checked' : '' ?>>
                    <label for="status" class="checkbox-label">
                      <span class="checkbox-span"></span>
                    </label>
                </td>
              </tr>
            </table>
            <!--submit+hidden-->
            <div class="form-buttonwrap">
              <a href="<?php echo url_for('admin_shops', 'index'); ?>">
                <input type="button" value="キャンセル">
              </a>
              <input type="submit" value="変更する">
              <input type="hidden" name="module" value="admin_shops">
              <input type="hidden" name="action" value="update">
              <input type="hidden" name="shop_id" value="<?php print h($records[0]->shop_id); ?>">
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
</body>

</html>