<?php
$title = 'goodandnew管理画面';
$description = '説明（イベント属性ページ）';
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
            <a href="dashboard.php?module=admin_shops&action=exclusive&event_id=<?php print h($records['event']->event_id); ?>">イベント属性</a>
          </span>
        </nav>
        
        <div class="title">
          <h1>イベント属性</h1>
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
                <th class="list-detail"></th>
              </tr>
            </thead>
            <?php if(isset($records['release'])) { ?>
            <tbody>
              <?php foreach ($records['release'] as $record) { ?>
              <tr class="<?= $record->status ? 'true' : 'false' ?>">
                <td class="list_id">
                    <?php print h($record->event_id); ?>
                </td>
                <td class="list-img">
                  <a href="dashboard.php?module=admin_shops&action=exclusive&event_id=<?php print h($record->event_id); ?>">
                    <img src="<?php print h('./include/images/events/visual/' . $record->event_png); ?>">
                  </a>
                </td>
                <td class="list-name">
                  <a href="dashboard.php?module=admin_shops&action=exclusive&event_id=<?php print h($record->event_id); ?>">
                    <ul>
                      <li><?php print h($record->getEventTag()); ?></li>
                      <li><?php print h($record->event_date); ?></li>
                    </ul>
                    <p><?php print h($record->event_name); ?></p>
                  </a>
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
                      <input type="hidden" name="module" value="admin_shops">
                      <input type="hidden" name="action" value="update_status">
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
              <p class="errors">公開中イベントがありません。</p>
              <?php } ?>
          </table>
        </div>
      </div>
    </div>
    <!--属性ブランド------------------------------------------------------------------------------------------------------------>
    <div id="list">
      <div class="container">
        
        <!--list タイトル-->
        <div class="title">
          <h2>属性ブランド</h2>
        </div>
        <!--list 一覧テーブル-->
        <div class="list-group">
          <table>
            <caption>ブランド一覧</caption>
            <thead>
              <tr>
                <th class="list-id">ID</th>
                <th class="list-img">画像</th>
                <th class="list-name">ブランド名</th>
                <th class="list-count">商品数</th>
                <th class="list-status">ステータス</th>
                <th class="list-detail"></th>
              </tr>
            </thead>
            <?php if(isset($records['exclusive_brands'])) { ?>
            <tbody>
              <?php foreach ($records['exclusive_brands'] as $record) { ?>
              <tr class="<?= $record->status ? 'true' : 'false' ?>"> 
                <td class="list_id">
                    <?php print h($record -> brand_id); ?>
                </td>
                <td class="list-img">
                  <a href="dashboard.php?module=admin_brands&action=edit&brand_id=<?php print h($record->brand_id); ?>">
                    <img src="<?php print h('./include/images/brands/img/' . $record->img1); ?>">
                  </a>
                </td>
                <td class="list_name">
                  <a href="dashboard.php?module=admin_brands&action=edit&brand_id=<?php print h($record->brand_id); ?>">
                    <p><?php print h($record -> brand_name); ?></p>
                  </a>
                </td>
                <td class="list_count">
                  <?php print h($record -> item_count); ?>
                </td>
                <!--ステータス-->
                <td class="list-status">
                  <div class="status-checkbox">
                    <form action="dashboard.php" method="post">
                      <input id="status_<?php print h($record->brand_id); ?>" type="checkbox" name="status" value="1" 
                             ONCHANGE="this.form.submit();" <?= $record->status ? 'checked' : '' ?> >
                      <label for="status_<?php print h($record->brand_id); ?>">
                        <span></span>
                      </label>
                      <div class="list-switch"></div>
                      <input type="hidden" name="module" value="admin_brands">
                      <input type="hidden" name="action" value="update_status">
                      <input type="hidden" name="brand_id" value="<?php print h($record->brand_id); ?>">
                      <input type="hidden" name="token" value="<?=h($token)?>">
                    </form>
                  </div>
                </td>
                <!--詳細リンク-->
                <td>
                  <div class="list-detail">
                    <a href="dashboard.php?module=admin_brands&action=edit&brand_id=<?php print h($record->brand_id); ?>">
                      <span>詳細</span>
                    </a>
                  </div>
                </td>
              </tr>
              <?php } ?>
            </tbody>
              <?php } else { ?>
              <p class="errors">ブランド情報がありません。</p>
              <?php } ?>
          </table>
        </div>
        <div class="exclusive-link">
          <a href ="dashboard.php?module=admin_shops&action=exclusive_brands&event_id=<?php print h($record->event_id); ?>">
            <span>属性ブランドを編集</span>
          </a>
        </div>
      </div>
    </div>
    <!--レコメンドアイテム------------------------------------------------------------------------------------------------------------>
    <div id="list">
      <div class="container">
        
        <!--list タイトル-->
        <div class="title">
          <h2>レコメンドアイテム</h2>
        </div>
        <!--list 一覧テーブル-->
        <div class="list-group">
          <table>
            <caption>アイテム一覧</caption>
            <thead>
              <tr>
                <th class="list-id">ID</th>
                <th class="list-img">アイコン</th>
                <th class="list-name">アイテム名</th>
                <th class="list-info">価格（税込）</th>
                <th class="list-stock">在庫数</th>
                <th class="list-status">ステータス</th>
                <th class="list-detail"></th>
              </tr>
            </thead>
            <?php if(isset($records['recommend_items'])) { ?>
            <tbody>
              <?php foreach ($records['recommend_items'] as $record) { ?>
              <tr class="<?= $record->status ? 'true' : 'false' ?>">
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
                <!--ステータス-->
                <td class="list-status">
                  <div class="status-checkbox">
                    <form action="dashboard.php" method="post">
                      <input id="status_<?php print h($record->item_id); ?>" type="checkbox" name="status" value="1" ONCHANGE="submit(this.form)" <?= $record->status ? 'checked' : '' ?> >
                      <label for="status_<?php print h($record->item_id); ?>">
                        <span></span>
                      </label>
                      <div class="list-switch"></div>
                      <input type="hidden" name="module" value="admin_items">
                      <input type="hidden" name="action" value="update_status">
                      <input type="hidden" name="item_id" value="<?php print h($record->item_id); ?>">
                      <input type="hidden" name="token" value="<?=h($token)?>">
                    </form>
                  </div>
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
        </div>
        <div class="exclusive-link">
          <a href ="dashboard.php?module=admin_shops&action=recommend_items&event_id=<?php print h($record->event_id); ?>">
            <span>レコメンドアイテムを編集</span>
          </a>
        </div>
      </div>
    </div>
    <!--属性アイテム------------------------------------------------------------------------------------------------------------>
    <div id="list">
      <div class="container">
        
        <!--list タイトル-->
        <div class="title">
          <h2>属性アイテム</h2>
        </div>
        <!-- props -->
        <div class="search-sorting">
          <div class="input-area">
            <div class="keyword">
              <form action="dashboard.php" method="get" role="search" id="searchform">
                <?php if (isset($search['keyword'])) { ?>
                  <?php foreach ($search as $key => $value) { ?>
                  <input type="text" name="search[keyword]" value="<?php print h($value); ?>" id="search-text-in-page" placeholder="イベント名">
                  <?php } ?>
                <?php } else { ?>
                  <input type="text" name="search[keyword]" value="" id="search-text-in-page" placeholder="イベント名">
                <?php } ?>
                  <input type="submit" id="searchsubmit" value="search">
                  <input type="hidden" name="module" value="admin_shops">
                  <input type="hidden" name="action" value="search">
              </form>
            </div>
          </div>
          <div class="select-area">
            <div class="filter">
              <form action="dashboard.php" method="get">
                  <table>
                      <tr>
                          <th class="select-title">
                            <label for="filter">カテゴリ</label>
                          </th>
                          <td class="select-name">
                            <select id="filter" name="search[filter]" ONCHANGE="submit(this.form)">
                              <option value="">選択してください</option>
                              <?php foreach ($records['categorys'] as $record) { ?>
                                  <option value="<?php print h($record->category_id); ?>"><?php print h($record->category_name); ?></option>
                              <?php } ?>
                            </select>
                          </td>
                      </tr>
                  </table>
                  <input type="hidden" name="module" value="admin_events">
                  <input type="hidden" name="action" value="search">
              </form>
            </div>
            <div class="sorting">
              <form action="dashboard.php" method="get">
                  <table>
                      <tr>
                          <th class="select-title">
                            <label for="sorting">並べ替え</label>
                          </th>
                          <td class="select-name">
                            <select id="sorting" name="sorting" ONCHANGE="submit(this.form)">
                                <option value="">選択してください</option>
                                <option value="0">新着順</option>
                                <option value="1">価格の安い順</option>
                                <option value="2">価格の高い順</option>
                            </select>
                          </td>
                      </tr>
                  </table>
                  <input type="hidden" name="module" value="admin_events">
                  <input type="hidden" name="action" value="sorting">
              </form>
            </div>
          </div>
        </div> 
        <!--list 一覧テーブル-->
        <div class="list-group">
          <table>
            <caption>アイテム一覧</caption>
            <thead>
              <tr>
                <th class="list-id">ID</th>
                <th class="list-img">アイコン</th>
                <th class="list-name">アイテム名</th>
                <th class="list-info">価格（税込）</th>
                <th class="list-stock">在庫数</th>
                <th class="list-status">ステータス</th>
                <th class="list-detail"></th>
              </tr>
            </thead>
            <?php if(isset($records['exclusive_items'])) { ?>
            <tbody>
              <?php foreach ($records['exclusive_items'] as $record) { ?>
              <tr class="<?= $record->status ? 'true' : 'false' ?>">
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
                <!--ステータス-->
                <td class="list-status">
                  <div class="status-checkbox">
                    <form action="dashboard.php" method="post">
                      <input id="status_<?php print h($record->item_id); ?>" type="checkbox" name="status" value="1" ONCHANGE="submit(this.form)" <?= $record->status ? 'checked' : '' ?> >
                      <label for="status_<?php print h($record->item_id); ?>">
                        <span></span>
                      </label>
                      <div class="list-switch"></div>
                      <input type="hidden" name="module" value="admin_items">
                      <input type="hidden" name="action" value="update_status">
                      <input type="hidden" name="item_id" value="<?php print h($record->item_id); ?>">
                      <input type="hidden" name="token" value="<?=h($token)?>">
                    </form>
                  </div>
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
        </div>
        <div class="exclusive-link">
          <a href ="dashboard.php?module=admin_shops&action=exclusive_items&event_id=<?php print h($record->event_id); ?>">
            <span>属性アイテムを編集</span>
          </a>
        </div>
      </div>
    </div>

    <div id="paginations">
      <div class="container">
        <div class="paginations-text">
            <p class="from_to"><?php print h($paginations['total_record']); ?>件中 <?php print h($paginations['from_record']); ?> - <?php print h($paginations['to_record']);?> 件目を表示</p>
        </div>
        <div class="paginations">
            <!-- 戻る -->
            <?php if ($paginations['page_id'] !== 1 ) { ?>
                <a href="<?php print h($url); ?>&page_id=<?php print h($paginations['prev_page']); ?>" class="page_feed">&laquo;</a>
            <?php } else { ?>
                <span class="first_last_page">&laquo;</span>
            <?php } ?>
            <!-- ページ番号の表示 -->
            <?php foreach ($paginations['page_range'] as $num) { ?>
                <?php if ($num !== $paginations['page_id']) { ?>
                    <a href="<?php print h($url); ?>&page_id=<?php print h($num); ?>" class="page_number"><?php print h($num); ?></a>
                <?php } else { ?>
                    <span class="now_page_number"><?php print h($num); ?></span>
                <?php } ?>
            <?php } ?>
            <!-- 進む -->
            <?php if($paginations['page_id'] < $paginations['page_total']) { ?>
                <a href="<?php print h($url); ?>&page_id=<?php print h($paginations['next_page']); ?>" class="page_feed">&raquo;</a>
            <?php } else { ?>
                <span class="first_last_page">&raquo;</span>
            <?php } ?>
        </div>
      </div>
    </div>
    <?php include './include/view/_inc/admin/homebutton.php'; ?>
  </main>
  <?php include './include/view/_inc/admin/footer.php'; ?>
</body>

</html>