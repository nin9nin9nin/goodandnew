<?php
$title = 'ec site 管理画面';
$description = '説明（イベント編集ページ）';
// $is_home = true; //トップページの判定用の変数
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
            <a href="<?php echo url_for('admin_events', 'index'); ?>">イベント管理</a>
          </span>
          <span>&gt;</span>
          <span>
            <a href="dashboard.php?module=admin_events&action=edit&event_id=<?php print h($record->event_id); ?>">イベント詳細</a>
          </span>
        </nav>
        
        <div class="title">
          <h1>イベント詳細</h1>
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
          <h2>イベント情報変更</h2>
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
                  <label for="event_id">ID：</label>
                </th>
                <td>
                  <span class="raw_data"><?php print h($record -> event_id); ?></span>
                </td>
              </tr>
              <tr class="form-text">
                <th>
                  <label for="event_name">名前：</label>
                </th>
                <td>
                  <input id="event_name" type="text" name="event_name" value="<?php print h($record -> event_name); ?>">
                </td>
              </tr>
              <tr class="form-text">
                <th>
                  <label for="description">イベント説明：</label>
                </th>
                <td>
                  <textarea id="description" name="description" value="" rows="10" cols="60" placeholder="テキストを入力"><?php print h($record->description)?></textarea>
                </td>
              </tr>
              <tr class="form-text">
                <th>
                  <label for="event_date">開催期間：</label>
                </th>
                <td>
                  <input id="event_date" type="text" name="event_date" value="<?php print h($record -> event_date); ?>" placeholder="January 2022">
                </td>
              </tr>
              <tr class="form-select">
                <th>
                  <label for="event_tag">タグ：</label>
                </th>
                <td>
                  <select id="event_tag" name="event_tag">
                    <option value="<?php print h($record -> event_tag); ?>"><?php print h($record -> getEventTag()); ?></option>
                    <option value="">選択してください</option>
                    <option value="0">ポップアップ</option>
                    <option value="1">イベント</option>
                  </select>
                </td>
              </tr>
              <!--svg画像-->
              <tr class="form-file">
                <th>
                  <label for="event_svg">svgタグ：</label>
                </th>
                <td>
                  <div class="update-img">
                    <img src="<?php print h('./include/images/events/visual/' .$record->event_svg); ?>">
                  </div>
                  <div class="img-button">
                    <a href="dashboard.php?module=admin_events&action=img_edit&event_id=<?php print h($record->event_id); ?>">
                      <input type="button" value="画像を変更する">
                    </a>
                    <!--<input id="file" type="file" name="icon_img" value="">-->
                  </div>
                </td>
              </tr>
              <!--png画像-->
              <tr class="form-file">
                <th>
                  <label for="event_png">ビジュアル：</label>
                </th>
                <td>
                  <div class="update-img">
                    <img src="<?php print h('./include/images/events/visual/' .$record->event_png); ?>">
                  </div>
                  <div class="img-button">
                    <a href="dashboard.php?module=admin_events&action=img_edit&event_id=<?php print h($record->event_id); ?>">
                      <input type="button" value="画像を変更する">
                    </a>
                    <!--<input id="file" type="file" name="icon_img" value="">-->
                  </div>
                </td>
              </tr>
              <!--画像-->
              <tr class="form-file">
                <th>
                  <label for="event_img">画像：</label>
                  <span class="multiple-files">※10枚まで可能</span>
                </th>
                <td>
                  <div class="update-img">
                    <img src="<?php print h('./include/images/events/visual/' .$record->img1); ?>">
                  </div>
                  <div class="img-button">
                    <a href="dashboard.php?module=admin_events&action=img_edit&event_id=<?php print h($record->event_id); ?>">
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
                  <input id="status" type="checkbox" name="status" value="1" class="checkbox-input" <?= $record->status ? 'checked' : '' ?>>
                    <label for="status" class="checkbox-label">
                      <span class="checkbox-span"></span>
                    </label>
                </td>
              </tr>
            </table>
              <!--submit+hidden-->
              <div class="form-buttonwrap">
                <a href="<?php echo url_for('admin_events', 'index'); ?>">  
                  <input type="button" value="キャンセル">
                </a>
                <input type="submit" value="変更する">
                <input type="hidden" name="module" value="admin_events">
                <input type="hidden" name="action" value="update">
                <input type="hidden" name="event_id" value="<?php print h($record->event_id); ?>">
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