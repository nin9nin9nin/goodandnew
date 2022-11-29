<?php
$title = 'goodandnewshop管理画面';
$description = '説明（カテゴリー編集ページ）';
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
            <a href="<?php echo url_for('admin_categorys', 'index'); ?>">カテゴリー管理</a>
          </span>
          <span>&gt;</span>
          <span>
            <a href="dashboard.php?module=admin_categorys&action=edit&category_id=<?php print h($records[0]->category_id); ?>">カテゴリー詳細</a>
          </span>
        </nav>
        
        <div class="title">
          <h1>カテゴリー詳細</h1>
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
          <h2>カテゴリー情報変更</h2>
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
                  <label for="new_category_id">カテゴリーID：</label>
                </th>
                <td>
                  <span class="raw_data"><?php print h($records[0] -> category_id); ?></span>
                </td>
              </tr>
              <tr class="form-text">
                <th>
                  <label for="category_name">カテゴリー名：</label>
                </th>
                <td>
                  <input id="category_name" type="text" name="category_name" value="<?php print h($records[0] -> category_name); ?>">
                </td>
              </tr>
              <tr class="form-select">
                <th>
                  <label for="parent_id">親カテゴリー：</label>
                </th>
                <td>
                  <select name="parent_id">
                    <option value="<?php print h($records[0] -> parent_id); ?>"><?php print h($records[0] -> parent_name); ?></option>
                    <option value="">選択してください</option>
                    <?php foreach ($records['parents'] as $record) { ?>
                    <option value="<?php print h($record->category_id); ?>"><?php print h($record->category_name)?></option>
                    <?php } ?>
                  </select>
                </td>
              </tr>
              <!--ステータス-->
              <tr class="form-checkbox">
                <th>ステータス：</th>
                <td>
                  <input id="status" type="checkbox" name="status" value="1" class="checkbox-input" <?= $records[0] -> status ? 'checked' : '' ?>>
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
              <a href="<?php echo url_for('admin_categorys', 'index'); ?>">
                <input type="button" value="キャンセル">
              </a>
              <input type="submit" value="変更する">
              <input type="hidden" name="module" value="admin_categorys">
              <input type="hidden" name="action" value="update">
              <input type="hidden" name="category_id" value="<?php print h($records[0]->category_id); ?>">
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