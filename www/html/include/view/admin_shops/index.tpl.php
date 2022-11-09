<?php
$title = 'goodandnew管理画面';
$description = '説明（ショップ画面管理ページ）';
$is_home = NULL; //トップページの判定(isset)
$flash_message = Session::getFlash(); // フラッシュメッセージの取得
$token = Session::getCsrfToken(); // トークンの取得
$search = Request::get('search'); //検索・絞り込みの値
$sorting = Request::get('sorting'); //並べ替えの値
$url = Request::getUrl(); //ページネーション用url
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
            <a href="<?php echo url_for('admin_shops', 'index'); ?>">ショップ画面</a>
          </span>
          <span>&gt;</span>
        </nav>
        
        <div class="title">
          <h1>ショップ画面</h1>
        </div>
        <!--フラッシュメッセージ-->
        <?php if ($flash_message !== '') { ?>
          <div class="message">
            <p class="fade-message"><?php echo $flash_message; ?></p>
          </div>
        <?php } ?>
      </div>
    </div>
    <!--リスト------------------------------------------------------------------------------------------------------------>
    <div id="list">
      <div class="container">
        
        <!--list タイトル-->
        <div class="title">
          <h2>トップページ情報</h2>
        </div>
        <!--list 一覧テーブル-->
        <div class="list-group">
          <table>
            <caption>掲載中</caption>
            <thead>
              <tr>
                <th class="list-id">ID</th>
                <th class="list-img">画像</th>
                <th class="list-name">イベント名</th>
                <th class="list-count">商品数</th>
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
                  <a href="dashboard.php?module=admin_shops&action=edit&event_id=<?php print h($record->event_id); ?>">
                    <img src="<?php print h('./include/images/events/visual/' . $record->event_png); ?>">
                  </a>
                </td>
                <td class="list-name">
                  <a href="dashboard.php?module=admin_shops&action=edit&event_id=<?php print h($record->event_id); ?>">
                    <ul>
                      <li><?php print h($record->getEventTag()); ?></li>
                      <li><?php print h($record->event_date); ?></li>
                    </ul>
                    <p><?php print h($record->event_name); ?></p>
                  </a>
                </td>
                <td class="list_count">
                  <?php print h($record -> item_count); ?>
                </td>
                <!--詳細リンク-->
                <td>
                  <div class="list-detail">
                    <a href="dashboard.php?module=admin_shops&action=edit&event_id=<?php print h($record->event_id); ?>">
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
        <div class="shop-edit-link">
          <a href="dashboard.php?module=admin_shops&action=edit&event_id=<?php print h($record->event_id); ?>">
            <span>掲載イベントを変更する</span>
          </a>
        </div>
      </div>
    </div>
    
    <?php include './include/view/_inc/admin/homebutton.php'; ?>
  </main>
  <?php include './include/view/_inc/admin/footer.php'; ?>
</body>

</html>