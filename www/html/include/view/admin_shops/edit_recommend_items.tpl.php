<?php
$title = 'goodandnew管理画面';
$description = '説明（レコメンドアイテム編集ページ）';
$is_home = NULL; //トップページの判定(isset)
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
          <span>&gt;</span>
          <span>
            <a href="dashboard.php?module=admin_shops&action=edit_recommend_items&event_id=<?php print h($records['recommend_items']->recommend_id); ?>">レコメンドアイテム変更</a>
          </span>
        </nav>
        
        <div class="title">
          <h1>レコメンドアイテム変更</h1>
        </div>
        <!--フラッシュメッセージ-->
        <?php if ($flash_message !== '') { ?>
          <div class="message">
            <p class="fade-message"><?php echo $flash_message; ?></p>
          </div>
        <?php } ?>
      </div>
    </div>
    <!---レコメンドアイテム----------------------------------------------------------------------------------------------------------->
    <div id="list">
      <div class="container">
        
        <!--list タイトル-->
        <div class="title">
          <h2>レコメンドアイテム</h2>
        </div>
        <!--list 一覧テーブル-->
        <div class="list-group">
            <table>
              <thead>
                <tr>
                  <th class="list-id">ID</th>
                  <th class="list-img">アイコン</th>
                  <th class="list-name">アイテム名</th>
                  <th class="list-info">価格（税込）</th>
                  <th class="list-stock">在庫数</th>
                  <th class="list-detail"></th>
                </tr>
              </thead>
              <?php if(!empty($records['recommend_items']) > 0) { ?>
              <tbody>
                <tr class="<?= $records['recommend_items']->status ? 'true' : 'false' ?>">
                  <td class="list_id">
                      <?php print h($records['recommend_items']->item_id); ?>
                  </td>
                  <td class="list-img">
                    <a href="dashboard.php?module=admin_items&action=edit&item_id=<?php print h($records['recommend_items']->item_id); ?>">
                      <img src="<?php print h('./include/images/items/icon/' .$records['recommend_items']->icon_img); ?>">
                    </a>
                  </td>
                  <td class="list-name">
                    <a href="dashboard.php?module=admin_items&action=edit&item_id=<?php print h($records['recommend_items']->item_id); ?>">
                      <ul>
                        <li class="category_name"><?php print h($records['recommend_items']->category_name); ?></li>
                        <li class="brand_name"><?php print h($records['recommend_items']->brand_name); ?></li>
                        <li class="event_name"><?php print h($records['recommend_items']->event_name); ?></li>
                      </ul>
                      <p class="item-name"><?php print h($records['recommend_items']->item_name); ?></p>
                    </a>
                  </td>
                  <td class="list-price">
                    <?php print h($records['recommend_items']->getPrice()); ?>
                  </td>
                  <td class="list-stock">
                    <?php print h($records['recommend_items']->getStock()); ?>
                  </td>
                  <!--詳細リンク-->
                  <td>
                    <div class="list-detail">
                      <a href="dashboard.php?module=admin_items&action=edit&item_id=<?php print h($records['recommend_items']->item_id); ?>">
                        <span>詳細</span>
                      </a>
                    </div>
                  </td>
                </tr>
              </tbody>
                <?php } else { ?>
                <p class="errors">アイテム情報がありません。</p>
                <?php } ?>
            </table>
        </div>
      </div>
    </div>
    <!--専用アイテム------------------------------------------------------------------------------------------------------------>
    <div id="list">
      <div class="container">
        
        <!--list タイトル-->
        <div class="title">
          <h2>アイテム選択</h2>
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
          <form action="dashboard.php" method="post" enctype="multipart/form-data">
            <table>
              <caption>専用アイテム一覧</caption>
              <thead>
                <tr>
                  <th class="list-check"></th>
                  <th class="list-id">ID</th>
                  <th class="list-img">アイコン</th>
                  <th class="list-name">アイテム名</th>
                  <th class="list-info">価格（税込）</th>
                  <th class="list-stock">在庫数</th>
                  <th class="list-detail"></th>
                </tr>
              </thead>
              <?php if(count($records['exclusive_items']) > 0) { ?>
              <tbody>
                <?php foreach ($records['exclusive_items'] as $record) { ?>
                <tr class="<?= $record->status ? 'true' : 'false' ?>">
                  <td class="list-check">
                    <input type="radio" id="recommend_items" name="item_id" value="<?php print h($record->item_id); ?>">
                  </td>
                  <td class="list_id">
                      <?php print h($record->item_id); ?>
                  </td>
                  <td class="list-img">
                    <a href="dashboard.php?module=admin_items&action=edit&item_id=<?php print h($record->item_id); ?>">
                      <img src="<?php print h('./include/images/items/icon/' .$record->icon_img); ?>">
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
                  <!--詳細リンク-->
                  <td>
                    <div class="list-detail">
                      <a href="dashboard.php?module=admin_items&action=edit&item_id=<?php print h($record->item_id); ?>">
                        <span>詳細</span>
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
              <input type="reset" value="リセット">
              <input type="submit" value="変更する">
              <input type="hidden" name="module" value="admin_shops">
              <input type="hidden" name="action" value="update_recommend_items">
              <input type="hidden" name="recommend_id" value="<?php print h($records['recommend_items']->recommend_id); ?>">
              <input type="hidden" name="event_id" value="<?php print h($records['event']->event_id); ?>">
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