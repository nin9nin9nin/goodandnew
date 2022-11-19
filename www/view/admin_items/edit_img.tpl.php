<?php
$title = 'goodandnew管理画面';
$description = '説明（アイテム画像編集ページ）';
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
            <a href="dashboard.php?module=admin_items&action=edit&item_id=<?php print h($record->item_id); ?>">アイテム詳細</a>
          </span>
          <span>&gt;</span>
          <span>
            <a href="dashboard.php?module=admin_items&action=edit_img&item_id=<?php print h($record->item_id); ?>">アイテム画像</a>
          </span>
        </nav>
        
        <div class="title">
          <h1>アイテム画像</h1>
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
          <h2>アイテム画像変更</h2>
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
                  <span class="raw_data"><?php print h($record -> item_id); ?></span>
                </td>
              </tr>
              <tr class="form-text">
                <th>
                  <label for="item_name">名前：</label>
                </th>
                <td>
                  <span class="raw_data"><?php print h($record -> item_name); ?></span>
                </td>
              </tr>
              <!--画像1-->
              <tr class="form-file">
                <th>
                  <label for="img1">画像1：</label>
                </th>
                <td>
                  <div class="update-img">
                    <img src="<?php print h(ITEMS_IMG_DIR . $record->img1); ?>">
                  </div>
                  <div class="img-button">
                    <input id="img1" type="file" name="img1" value="">
                    <input id="exists_img1" type="hidden" name="exists_img1" value="<?php print h($record->img1); ?>">
                  </div>
                </td>
              </tr>
              <!--画像2-->
              <tr class="form-file">
                <th>
                  <label for="img2">画像2：</label>
                </th>
                <td>
                  <div class="update-img">
                    <img src="<?php print h(ITEMS_IMG_DIR . $record->img2); ?>">
                  </div>
                  <div class="img-button">
                    <input id="img2" type="file" name="img2" value="">
                    <input id="exists_img2" type="hidden" name="exists_img2" value="<?php print h($record->img2); ?>">
                  </div>
                </td>
              </tr>
              <!--画像3-->
              <tr class="form-file">
                <th>
                  <label for="img3">画像3：</label>
                </th>
                <td>
                  <div class="update-img">
                    <img src="<?php print h(ITEMS_IMG_DIR . $record->img3); ?>">
                  </div>
                  <div class="img-button">
                    <input id="img3" type="file" name="img3" value="">
                    <input id="exists_img3" type="hidden" name="exists_img3" value="<?php print h($record->img3); ?>">
                  </div>
                </td>
              </tr>
              <!--画像4-->
              <tr class="form-file">
                <th>
                  <label for="img4">画像4：</label>
                </th>
                <td>
                  <div class="update-img">
                    <img src="<?php print h(ITEMS_IMG_DIR . $record->img4); ?>">
                  </div>
                  <div class="img-button">
                    <input id="img4" type="file" name="img4" value="">
                    <input id="exists_img4" type="hidden" name="exists_img4" value="<?php print h($record->img4); ?>">
                  </div>
                </td>
              </tr>
              <!--画像5-->
              <tr class="form-file">
                <th>
                  <label for="img5">画像5：</label>
                </th>
                <td>
                  <div class="update-img">
                    <img src="<?php print h(ITEMS_IMG_DIR . $record->img5); ?>">
                  </div>
                  <div class="img-button">
                    <input id="img5" type="file" name="img5" value="">
                    <input id="exists_img5" type="hidden" name="exists_img5" value="<?php print h($record->img5); ?>">
                  </div>
                </td>
              </tr>
              <!--画像6-->
              <tr class="form-file">
                <th>
                  <label for="img6">画像6：</label>
                </th>
                <td>
                  <div class="update-img">
                    <img src="<?php print h(ITEMS_IMG_DIR . $record->img6); ?>">
                  </div>
                  <div class="img-button">
                    <input id="img6" type="file" name="img6" value="">
                    <input id="exists_img6" type="hidden" name="exists_img6" value="<?php print h($record->img6); ?>">
                  </div>
                </td>
              </tr>
              <!--画像7-->
              <tr class="form-file">
                <th>
                  <label for="img7">画像7：</label>
                </th>
                <td>
                  <div class="update-img">
                    <img src="<?php print h(ITEMS_IMG_DIR . $record->img7); ?>">
                  </div>
                  <div class="img-button">
                    <input id="img7" type="file" name="img7" value="">
                    <input id="exists_img7" type="hidden" name="exists_img7" value="<?php print h($record->img7); ?>">
                  </div>
                </td>
              </tr>
              <!--画像8-->
              <tr class="form-file">
                <th>
                  <label for="img8">画像8：</label>
                </th>
                <td>
                  <div class="update-img">
                    <img src="<?php print h(ITEMS_IMG_DIR . $record->img8); ?>">
                  </div>
                  <div class="img-button">
                    <input id="img8" type="file" name="img8" value="">
                    <input id="exists_img8" type="hidden" name="exists_img8" value="<?php print h($record->img8); ?>">
                  </div>
                </td>
              </tr>
            </table>
              <!--submit+hidden-->
              <div class="form-buttonwrap">
                <a href="<?php echo url_for('admin_items', 'index'); ?>">  
                  <input type="button" value="戻る">
                </a>
                <input type="submit" value="変更する">
                <input type="hidden" name="module" value="admin_items">
                <input type="hidden" name="action" value="update_img">
                <input type="hidden" name="item_id" value="<?php print h($record->item_id); ?>">
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