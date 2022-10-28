<?php
$title = 'ec site 管理画面';
$description = '説明（イベント管理ページ）';
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
        </nav>
        
        <div class="title">
          <h1>イベント管理</h1>
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
          <h2>新規イベント追加</h2>
        </div>
        
        <!--入力フォーム-->
        <div class="create-form">
          <form action="dashboard.php" method="post" enctype="multipart/form-data">
            <table class="create-form table">
              <tr class="form-text">
                <th>
                  <label for="event_name">イベント名：</label><span class="hissu">必須</span>
                </th>
                <td>
                  <input id="event_name" type="text" name="event_name" value="">
                </td>
              </tr>
              <tr class="form-text">
                <th>
                  <label for="description">イベント説明：</label><span class="ninni">任意</span>
                </th>
                <td>
                  <textarea id="description" name="description" value="" rows="10" cols="60" placeholder="テキストを入力"></textarea>
                </td>
              </tr>
              <tr class="form-text">
                <th>
                  <label for="event_date">開催期間：</label><span class="hissu">必須</span>
                </th>
                <td>
                  <input id="event_date" type="text" name="event_date" value="" placeholder="January 2022">
                </td>
              </tr>
              <tr class="form-select">
                <th>
                  <label for="event_tag">タグ：</label><span class="hissu">必須</span>
                </th>
                <td>
                  <select id="event_tag" name="event_tag">
                    <option value="0">ポップアップ</option>
                    <option value="1">イベント</option>
                  </select>
                </td>
              </tr>
              <!--svg画像-->
              <tr class="form-file">
                <th>
                  <label for="event_svg">svg画像：</label><span class="ninni">任意</span>
                </th>
                <td>
                  <input id="event_svg" type="file" name="event_svg" value="">
                </td>
              </tr>
              <!--png画像-->
              <tr class="form-file">
                <th>
                  <label for="event_png">png画像：</label><span class="ninni">任意</span>
                </th>
                <td>
                  <input id="event_png" type="file" name="event_png" value="">
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
                <input type="submit" value="イベントを追加">
                <input type="hidden" name="module" value="admin_events">
                <input type="hidden" name="action" value="create">
                <input type="hidden" name="token" value="<?=$token?>">
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
          <h2>イベント情報</h2>
        </div>
        
        <!--list 一覧テーブル-->
        <div class="list-group">
          
          <table>
            <caption>イベント一覧</caption>
            <thead>
              <tr>
                <th class="list-id">ID</th>
                <th class="list-img">画像</th>
                <th class="list-name">イベント名</th>
                <th class="list-status">ステータス</th>
                <th class="list-delete">削除</th>
                <th class="list-detail"></th>
              </tr>
            </thead>
            <?php if(count($records['events']) > 0) { ?>
            <tbody>
              <?php foreach ($records['events'] as $record) { ?>
              <tr class="<?= $record->status ? 'true' : 'false' ?>">
                <td class="list_id">
                    <?php print h($record->event_id); ?>
                </td>
                <td class="list-img">
                  <a href="dashboard.php?module=admin_events&action=edit&event_id=<?php print h($record->event_id); ?>">
                    <img src="<?php print h('./assets/imges/event/svg/' . $record->event_svg); ?>">
                  </a>
                </td>
                <td class="list-name">
                  <a href="dashboard.php?module=admin_events&action=edit&event_id=<?php print h($record->event_id); ?>">
                    <ul>
                      <li class="category_name"><?php print h($record->event_tag); ?></li>
                      <li class="brand_name"><?php print h($record->event_date); ?></li>
                    </ul>
                    <p class="event-name"><?php print h($record->event_name); ?></p>
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
                      <input id="status_<?php print h($record->event_id); ?>" type="checkbox" name="status" value="1" ONCHANGE="submit(this.form)" <?= $record->status ? 'checked' : '' ?> >
                      <label for="status_<?php print h($record->event_id); ?>">
                        <span></span>
                      </label>
                      <div class="list-switch"></div>
                      <input type="hidden" name="module" value="admin_events">
                      <input type="hidden" name="action" value="update_status">
                      <input type="hidden" name="event_id" value="<?php print h($record->event_id); ?>">
                    </form>
                  </div>
                </td>
                <!--削除ボタン-->
                <td>
                  <div class="list-delete">
                    <form action="dashboard.php" method="post" id="delete_form">
                      <input type="submit" value="削除">
                      <input type="hidden" name="module" value="admin_events">
                      <input type="hidden" name="action" value="delete">
                      <input type="hidden" name="event_id" value="<?php print h($record->event_id); ?>">
                    </form>
                  </div>
                </td>
                <!--詳細リンク-->
                <td>
                  <div class="list-detail">
                    <a href="dashboard.php?module=admin_events&action=edit&event_id=<?php print h($record->event_id); ?>">
                      <span>詳細</span>
                    </a>
                  </div>
                </td>
              </tr>
              <?php } ?>
            </tbody>
              <?php } else { ?>
              <p class="errors">イベント情報がありません。</p>
              <?php } ?>
          </table>
        </div>
      </div>
    </div>
    <?php include './include/view/_inc/admin/pagination.php'; ?>
    <?php include './include/view/_inc/admin/homebutton.php'; ?>
  </main>
  
  <?php include './include/view/_inc/admin/footer.php'; ?>
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