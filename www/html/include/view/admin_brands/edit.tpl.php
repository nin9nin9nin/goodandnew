<?php
$title = 'ec site 管理画面';
$description = '説明（ブランド編集ページ）';
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
            <a href="<?php echo url_for('admin_brands', 'index'); ?>">ブランド管理</a>
          </span>
          <span>&gt;</span>
          <span>
            <a href="dashboard.php?module=admin_brands&action=edit&brand_id=<?php print h($records[0]->brand_id); ?>">ブランド詳細</a>
          </span>
        </nav>
        
        <div class="title">
          <h1>ブランド詳細</h1>
        </div>
        
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
          <form action="dashboard.php" method="post">
            <table class="update-form table">
              <tr class="form-text">
                <th>
                  <label for="new_brand_id">ブランドID：</label>
                </th>
                <td>
                  <span class="raw_data"><?php print h($records[0] -> brand_id); ?></span>
                <!--<input id="new_category_id" type="text" name="new_category_id" value="">-->
                </td>
              </tr>
              <tr class="form-text">
                <th>
                  <label for="brand_name">ブランド名：</label>
                </th>
                <td>
                  <input id="brand_name" type="text" name="brand_name" value="<?php print h($records[0] -> brand_name); ?>">
                </td>
              </tr>
              <tr class="form-select">
                <th>
                  <label for="category_id">マンスリー：</label>
                </th>
                <td>
                  <select id="category_id" name="category_id">
                    <option value="<?php print h($records[0] -> category_id); ?>"><?php print h($records[0] -> category_name); ?></option>
                    <!--<option value="">選択してください</option>-->
                    <option value="0">未設定</option>
                    <?php foreach ($records['categorys'] as $record) { ?>
                    <option value="<?php print h($record->category_id); ?>"><?php print h($record->category_name)?></option>
                    <?php } ?>
                  </select>
                </td>
              </tr>
              <tr class="form-text">
                <th>
                  <label for="description">ブランド説明：</label>
                </th>
                <td>
                  <textarea id="description" name="description" value="" placeholder="テキストを入力"><?php print h($records[0] -> description); ?></textarea>
                </td>
              </tr>
              <tr class="form-text">
                <th>
                  <label for="brand_hp">ブランドHP：</label>
                </th>
                <td>
                  <input id="brand_hp" type="url" name="brand_hp" value="<?php print h($records[0] -> brand_hp); ?>" placeholder="http://www.○○○.com">
                </td>
              </tr>
              <tr class="form-text">
                <th>
                  <label for="brand_link1">ブランドLINK：</label>
                </th>
                <td>
                  <input id="brand_link1" type="url" name="brand_link1" value="<?php print h($records[0] -> brand_link1); ?>" placeholder="https://www.instagram.com/...">
                </td>
              </tr>
              <tr class="form-text">
                <th>
                  <label for="brand_link2">ブランドLINK：</label>
                </th>
                <td>
                  <input id="brand_link2" type="url" name="brand_link2" value="<?php print h($records[0] -> brand_link2); ?>" placeholder="https://www.facebook.com/...">
                </td>
              </tr>
              <tr class="form-text">
                <th>
                  <label for="brand_link3">ブランドLINK：</label>
                </th>
                <td>
                  <input id="brand_link3" type="url" name="brand_link3" value="<?php print h($records[0] -> brand_link3); ?>" placeholder="https://www.twitter.com/ ...">
                </td>
              </tr>
              <tr class="form-text">
                <th>
                  <label for="brand_link4">ブランドLINK：</label>
                </th>
                <td>
                  <input id="brand_link4" type="url" name="brand_link4" value="<?php print h($records[0] -> brand_link4); ?>" placeholder="https://www.youtube.com/ ...">
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
              <a href="<?php echo url_for('admin_brands', 'index'); ?>">  
                <input type="button" value="キャンセル">
              </a>
              <input type="submit" value="変更する">
              <input type="hidden" name="module" value="admin_brands">
              <input type="hidden" name="action" value="update">
              <input type="hidden" name="brand_id" value="<?php print h($records[0]->brand_id); ?>">
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