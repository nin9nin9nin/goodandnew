<?php
$title = 'goodandnewshop管理画面';
$description = '説明（レコメンドアイテムページ）';
$is_home = NULL; //トップページの判定(isset)
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
            <a href="<?php echo url_for('admin_shops', 'index'); ?>">ショップ画面</a>
          </span>
          <span>&gt;</span>
          <span>
            <a href="dashboard.php?module=admin_shops&action=exclusive&event_id=<?php print h($records['event']->event_id); ?>">トップページ設定</a>
          </span>
          <span>&gt;</span>
          <span>
            <a href="dashboard.php?module=admin_shops&action=recommend_items&event_id=<?php print h($records['event']->event_id); ?>">レコメンドアイテム</a>
          </span>
        </nav>
        
        <div class="title">
          <h1>レコメンドアイテム</h1>
        </div>
        <!--フラッシュメッセージ-->
        <?php if ($flash_message !== '') { ?>
          <div class="message">
            <p class="fade-message"><?php echo $flash_message; ?></p>
          </div>
        <?php } ?>
      </div>
    </div>
    <!---イベント----------------------------------------------------------------------------------------------------------->
    <div id="list">
      <div class="container">
        
        <!--list タイトル-->
        <div class="title">
          <h2>イベント情報</h2>
        </div>
        <!--list -->
        <div class="list-group">
          <table>
            <thead>
              <tr>
                <th class="list-id">ID</th>
                <th class="list-img">画像</th>
                <th class="list-name">イベント名</th>
                <th class="list-status">ステータス</th>
                <th class="list-exclusive"></th>
              </tr>
            </thead>
            <?php if(!empty($records['event'])) { ?>
            <tbody>
              <tr class="<?= $records['event']->status ? 'true' : 'false' ?>">
                <td class="list_id">
                    <?php print h($records['event']->event_id); ?>
                </td>
                <td class="list-img">
                  <a href="dashboard.php?module=admin_events&action=edit&event_id=<?php print h($records['event']->event_id); ?>">
                    <img src="<?php print h(EVENTS_VISUAL_DIR . $records['event']->event_png); ?>">
                  </a>
                </td>
                <td class="list-name">
                  <a href="dashboard.php?module=admin_events&action=edit&event_id=<?php print h($records['event']->event_id); ?>">
                    <ul>
                      <li><?php print h($records['event']->getEventTag()); ?></li>
                      <li><?php print h($records['event']->event_date); ?></li>
                    </ul>
                    <p><?php print h($records['event']->event_name); ?></p>
                  </a>
                </td>
                <!--ステータス-->
                <td class="list-status">
                  <div class="status-checkbox">
                    <form action="dashboard.php" method="post">
                      <input id="event_status_<?php print h($records['event']->event_id); ?>" type="checkbox" name="status" value="1" ONCHANGE="submit(this.form)" <?= $records['event']->status ? 'checked' : '' ?> >
                      <label for="event_status_<?php print h($records['event']->event_id); ?>">
                        <span></span>
                      </label>
                      <div class="list-switch"></div>
                      <input type="hidden" name="module" value="admin_shops">
                      <input type="hidden" name="action" value="update_event_status">
                      <input type="hidden" name="event_id" value="<?php print h($records['event']->event_id); ?>">
                      <input type="hidden" name="token" value="<?=h($token)?>">
                    </form>
                  </div>
                </td>
                <!--詳細リンク-->
                <td>
                  <div class="list-exclusive">
                    <a href="dashboard.php?module=admin_events&action=edit&event_id=<?php print h($records['event']->event_id); ?>">
                      <span>詳細</span>
                    </a>
                  </div>
                </td>
              </tr>
            </tbody>
              <?php } else { ?>
              <p class="errors">イベント情報がありません。</p>
              <?php } ?>
          </table>
        </div>
      </div>
    </div>
    <!--レコメンドアイテム------------------------------------------------------------------------------------------------------------>
    <div id="list">
      <div class="container">
        
        <!--list タイトル-->
        <div class="title">
          <h2>レコメンドアイテム編集</h2>
        </div>
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
        <!--list 一覧テーブル-->
        <div class="list-group">
          <table>
            <caption>レコメンドアイテム一覧</caption>
            <thead>
              <tr>
                <th class="list-id">ID</th>
                <th class="list-img">アイコン</th>
                <th class="list-name">アイテム名</th>
                <th class="list-info">価格（税込）</th>
                <th class="list-stock">在庫数</th>
                <th class="list-delete">削除</th>
                <th class="list-detail"></th>
              </tr>
            </thead>
            <?php if(count($records['recommend_items']) > 0) { ?>
            <tbody>
              <?php foreach ($records['recommend_items'] as $record) { ?>
              <tr class="<?= $record->status ? 'true' : 'false' ?>">
                <td class="list_id">
                    <?php print h($record->item_id); ?>
                </td>
                <td class="list-img">
                  <a href="dashboard.php?module=admin_items&action=edit&item_id=<?php print h($record->item_id); ?>">
                    <img src="<?php print h(ITEMS_ICON_DIR . $record->icon_img); ?>">
                  </a>
                </td>
                <td class="list-name">
                  <a href="dashboard.php?module=admin_items&action=edit&item_id=<?php print h($record->item_id); ?>">
                    <ul>
                      <li class="category_name"><?php print h($record->category_name); ?></li>
                      <li class="brand_name"><?php print h($record->brand_name); ?></li>
                      <li class="event_name"><?php print h($record->event_name); ?></li>
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
                <!--削除ボタン-->
                <td>
                  <div class="list-delete">
                    <form action="dashboard.php" method="post" id="delete_form">
                      <input type="submit" value="削除" onclick="return confirm('データを削除してもよろしいですか？')">
                      <input type="hidden" name="module" value="admin_shops">
                      <input type="hidden" name="action" value="delete_recommend_items">
                      <input type="hidden" name="recommend_id" value="<?php print h($record->recommend_id); ?>">
                      <input type="hidden" name="event_id" value="<?php print h($record->event_id); ?>">
                      <input type="hidden" name="token" value="<?=h($token)?>">
                    </form>
                  </div>
                </td>
                <!--変更リンク-->
                <td>
                  <div class="list-detail">
                    <a href="dashboard.php?module=admin_shops&action=edit_recommend_items&event_id=<?php print h($record->event_id); ?>&recommend_id=<?php print h($record->recommend_id); ?>">
                      <span>変更</span>
                    </a>
                  </div>
                </td>
              </tr>
              <?php } ?>
            </tbody>
              <?php } else { ?>
              <p class="errors">アイテム情報がありません。</p>
              <?php } ?>
          </table>
          <!--submit+hidden-->
          <div class="form-buttonwrap">
            <a href="dashboard.php?module=admin_shops&action=exclusive&event_id=<?php print h($records['event']->event_id); ?>">  
              <input type="button" value="戻る">
            </a>
            <a href="dashboard.php?module=admin_shops&action=register_recommend_items&event_id=<?php print h($records['event']->event_id); ?>">  
              <input type="button" value="アイテム一覧から追加" class="add-button">
            </a>
          </div>
        </div>
      </div>
    </div>

    <?php include INCLUDE_DIR . '/admin/homebutton.php'; ?>
  </main>
  <?php include INCLUDE_DIR . '/admin/footer.php'; ?>
</body>

</html>