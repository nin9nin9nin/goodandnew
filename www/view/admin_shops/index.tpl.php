<?php
$title = 'goodandnew管理画面';
$description = '説明（ショップ画面ページ）';
$is_home = NULL; //トップページの判定(isset)
$flash_message = Session::getFlash(); // フラッシュメッセージの取得
$token = Session::getCsrfToken(); // トークンの取得
$search = Request::get('search'); //検索・絞り込みの値
$sorting = Request::get('sorting'); //並べ替えの値
$url = Request::getUrl(); //ページネーション用url
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
    <!---公開中----------------------------------------------------------------------------------------------------------->
    <div id="list">
      <div class="container">
        
        <!--list タイトル-->
        <div class="title">
          <h2>公開中イベント</h2>
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
            <?php if(count($records['release']) > 0) { ?>
            <tbody>
              <?php foreach ($records['release'] as $record) { ?>
              <tr class="<?= $record->status ? 'true' : 'false' ?>">
                <td class="list_id">
                    <?php print h($record->event_id); ?>
                </td>
                <td class="list-img">
                  <a href="dashboard.php?module=admin_shops&action=exclusive&event_id=<?php print h($record->event_id); ?>">
                    <img src="<?php print h(EVENTS_VISUAL_DIR . $record->event_png); ?>">
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
                      <input type="hidden" name="event_id" value="<?php print h($record->event_id); ?>">
                      <input type="hidden" name="token" value="<?=h($token)?>">
                    </form>
                  </div>
                </td>
                <!--専用リンク-->
                <td>
                  <div class="list-exclusive">
                    <a href="dashboard.php?module=admin_shops&action=exclusive&event_id=<?php print h($record->event_id); ?>">
                      <span>トップページ設定</span>
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
    <!--イベントリスト------------------------------------------------------------------------------------------------------------>
    <div id="list">
      <div class="container">
        
        <!--list タイトル-->
        <div class="title">
          <h2>ショップ画面情報</h2>
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
                  <input type="hidden" name="action" value="search_event">
              </form>
            </div>
          </div>
          <div class="select-area">
            <div class="filter">
              <form action="dashboard.php" method="get">
                  <table>
                      <tr>
                          <th class="select-title">
                            <label for="filter">タグ</label>
                          </th>
                          <td class="select-name">
                            <select id="filter" name="search[filter]" ONCHANGE="submit(this.form)">
                                <?php if (isset($search['filter'])) { ?>
                                  <?php foreach ($search as $key => $value) { ?>
                                    <?php if ($value === '0') { ?>
                                      <option value="0">MONTHLY&nbsp;POP&nbsp;UP</option>
                                      <option value="1">EVENT</option>
                                    <?php } else if ($value === '1') { ?>
                                      <option value="1">EVENT</option>
                                      <option value="0">MONTHLY&nbsp;POP&nbsp;UP</option>
                                    <?php } ?>
                                  <?php } ?>
                                <?php } else { ?>
                                  <option value="">選択してください</option>
                                  <option value="0">MONTHLY&nbsp;POP&nbsp;UP</option>
                                  <option value="1">EVENT</option>
                                <?php } ?>
                            </select>
                          </td>
                      </tr>
                  </table>
                  <input type="hidden" name="module" value="admin_shops">
                  <input type="hidden" name="action" value="search_event">
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
                              <?php if ($sorting !== '') { ?>
                                <?php if ($sorting === '0') { ?>
                                  <option value="0">イベント名順</option>
                                  <option value="1">昇順</option>
                                  <option value="2">降順</option>
                                <?php } else if ($sorting === '1') { ?>
                                  <option value="1">昇順</option>
                                  <option value="2">降順</option>
                                  <option value="0">イベント名順</option>
                                <?php } else if ($sorting === '2') { ?>
                                  <option value="2">降順</option>
                                  <option value="0">イベント名順</option>
                                  <option value="1">昇順</option>
                                <?php } ?>
                              <?php } else { ?>
                                <option value="">選択してください</option>
                                <option value="0">イベント名順</option>
                                <option value="1">昇順</option>
                                <option value="2">降順</option>
                              <?php } ?>
                            </select>
                          </td>
                      </tr>
                  </table>
                  <input type="hidden" name="module" value="admin_shops">
                  <input type="hidden" name="action" value="sorting_event">
              </form>
            </div>
          </div>
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
                <th class="list-exclusive"></th>
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
                  <a href="dashboard.php?module=admin_shops&action=exclusive&event_id=<?php print h($record->event_id); ?>">
                    <img src="<?php print h(EVENTS_VISUAL_DIR . $record->event_png); ?>">
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
                      <input type="hidden" name="event_id" value="<?php print h($record->event_id); ?>">
                      <input type="hidden" name="token" value="<?=h($token)?>">
                    </form>
                  </div>
                </td>
                <!--専用リンク-->
                <td>
                  <div class="list-exclusive">
                    <a href="dashboard.php?module=admin_shops&action=exclusive&event_id=<?php print h($record->event_id); ?>">
                      <span>トップページ設定</span>
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
    <!--ページネーション------------------------------------------------------------------------------------------------------------>
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
    <?php include INCLUDE_DIR . '/admin/homebutton.php'; ?>
  </main>
  <?php include INCLUDE_DIR . '/admin/footer.php'; ?>
</body>

</html>