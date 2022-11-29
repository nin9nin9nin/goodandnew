<?php
$title = 'goodandnewshop管理画面';
$description = '説明（アイテム管理ページ）';
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
            <a href="<?php echo url_for('admin_items', 'index'); ?>">アイテム管理</a>
          </span>
          <span>&gt;</span>
        </nav>
        
        <div class="title">
          <h1>アイテム管理</h1>
        </div>
        <!--フラッシュメッセージ-->
        <?php if ($flash_message !== '') { ?>
          <div class="message">
            <p class="fade-message"><?php echo $flash_message; ?></p>
          </div>
        <?php } ?>
      </div>
    </div>
    <!---登録----------------------------------------------------------------------------------------------------------->
    <div id="create">
      <div class="container">
        <!--create タイトル-->
        <div class="title">
          <h2>新規アイテム追加</h2>
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
        <!--入力フォーム-->
        <div class="create-form">
          <form action="dashboard.php" method="post" enctype="multipart/form-data">
            <table class="create-form table">
              <tr class="form-text">
                <th>
                  <label for="item_name">アイテム名：</label><span class="hissu">必須</span>
                </th>
                <td>
                  <input id="item_name" type="text" name="item_name" value="">
                </td>
              </tr>
              <tr class="form-select">
                <th>
                  <label for="category_id">カテゴリー：</label><span class="hissu">必須</span>
                </th>
                <td>
                  <select id="category_id" name="category_id">
                    <option value="">選択してください</option>
                    <?php foreach ($records['categorys'] as $record) { ?>
                    <option value="<?php print h($record->category_id); ?>"><?php print h($record->category_name)?></option>
                    <?php } ?>
                  </select>
                </td>
              </tr>
              <tr class="form-select">
                <th>
                  <label for="brand_id">ブランド：</label><span class="hissu">必須</span>
                </th>
                <td>
                  <select id="brand_id" name="brand_id">
                    <option value="">選択してください</option>
                    <?php foreach ($records['brands'] as $record) { ?>
                    <option value="<?php print h($record->brand_id); ?>"><?php print h($record->brand_name)?></option>
                    <?php } ?>
                  </select>
                </td>
              </tr>
              <tr class="form-select">
                <th>
                  <label for="event_id">イベント名：</label><span class="ninni">任意</span>
                </th>
                <td>
                  <select id="event_id" name="event_id">
                    <option value="">選択してください</option>
                    <?php foreach ($records['events'] as $record) { ?>
                    <option value="<?php print h($record->event_id); ?>"><?php print h($record->event_name)?></option>
                    <?php } ?>
                  </select>
                </td>
              </tr>
              <tr class="form-text">
                <th>
                  <label for="price">価格（税込）：</label><span class="hissu">必須</span>
                </th>
                <td>
                  <input id="price" type="text" name="price" value="">
                </td>
              </tr>
              <tr class="form-text">
                <th>
                  <label for="stock">在庫数：</label><span class="hissu">必須</span>
                </th>
                <td>
                  <input id="stock" type="text" name="stock" value="">
                </td>
              </tr>
              <tr class="form-text">
                <th>
                  <label for="description">アイテム説明：</label><span class="ninni">任意</span>
                </th>
                <td>
                  <textarea id="description" name="description" value="" rows="10" cols="60" placeholder="テキストを入力"></textarea>
                </td>
              </tr>
              <!--icon画像-->
              <tr class="form-file">
                <th>
                  <label for="icon_img">アイコン画像：</label><span class="hissu">必須</span>
                  <span class="files-addition">ファイル形式&nbsp;jpeg</span>
                </th>
                <td>
                  <input id="icon_img" type="file" name="icon_img" value="">
                </td>
              </tr>
              <!--画像-->
              <tr class="form-file">
                <th>
                  <label for="item_img">画像：</label><span class="ninni">任意</span>
                  <span class="files-addition">ファイル形式&nbsp;jpeg&nbsp;※8枚まで可能</span>
                </th>
                <td>
                  <input id="item_img" type="file" multiple name="img[]" value="">
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
                <input type="submit" value="アイテム登録">
                <input type="hidden" name="module" value="admin_items">
                <input type="hidden" name="action" value="create">
                <input type="hidden" name="token" value="<?=h($token)?>">
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
          <h2>アイテム情報</h2>
        </div>
        <!-- props -->
        <div class="search-sorting">
          <div class="input-area">
            <div class="keyword">
              <form action="dashboard.php" method="get" role="search" id="searchform">
                <?php if (isset($search['keyword'])) { ?>
                  <?php foreach ($search as $key => $value) { ?>
                  <input type="text" name="search[keyword]" value="<?php print h($value); ?>" id="search-text-in-page" placeholder="アイテム名">
                  <?php } ?>
                <?php } else { ?>
                  <input type="text" name="search[keyword]" value="" id="search-text-in-page" placeholder="アイテム名">
                <?php } ?>
                  <input type="submit" id="searchsubmit" value="search">
                  <input type="hidden" name="module" value="admin_items">
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
                          <label for="filter_categorys">カテゴリ</label>
                        </th>
                        <td class="select-name">
                          <select id="filter_categorys" name="search[filter_categorys]" ONCHANGE="submit(this.form)">
                            <option value="">選択してください</option>
                            <?php foreach ($records['categorys'] as $record) { ?>
                            <option value="<?php print h($record->category_id); ?>"><?php print h($record->category_name)?></option>
                            <?php } ?>
                          </select>
                        </td>
                      </tr>
                  </table>
                  <input type="hidden" name="module" value="admin_items">
                  <input type="hidden" name="action" value="search">
              </form>
              <form action="dashboard.php" method="get">
                  <table>
                      <tr>
                        <th class="select-title">
                          <label for="filter_brands">ブランド</label>
                        </th>
                        <td class="select-name">
                          <select id="filter_brands" name="search[filter_brands]" ONCHANGE="submit(this.form)">
                            <option value="">選択してください</option>
                            <?php foreach ($records['brands'] as $record) { ?>
                            <option value="<?php print h($record->brand_id); ?>"><?php print h($record->brand_name)?></option>
                            <?php } ?>
                          </select>
                        </td>
                      </tr>
                  </table>
                  <input type="hidden" name="module" value="admin_items">
                  <input type="hidden" name="action" value="search">
              </form>
              <form action="dashboard.php" method="get">
                  <table>
                      <tr>
                        <th class="select-title">
                          <label for="filter_events">イベント</label>
                        </th>
                        <td class="select-name">
                          <select id="filter_events" name="search[filter_events]" ONCHANGE="submit(this.form)">
                            <option value="">選択してください</option>
                            <?php foreach ($records['events'] as $record) { ?>
                            <option value="<?php print h($record->event_id); ?>"><?php print h($record->event_name)?></option>
                            <?php } ?>
                          </select>
                        </td>
                      </tr>
                  </table>
                  <input type="hidden" name="module" value="admin_items">
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
                              <option value="3">アイテム名順</option>
                              <option value="4">カテゴリー名順</option>
                              <option value="5">ブランド名順</option>
                              <option value="6">イベント名順</option>
                              <option value="7">昇順</option>
                              <option value="8">降順</option>
                            </select>
                          </td>
                      </tr>
                  </table>
                  <input type="hidden" name="module" value="admin_items">
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
                <th class="list-delete">削除</th>
                <th class="list-detail"></th>
              </tr>
            </thead>
            <?php if(count($records['items']) > 0) { ?>
            <tbody>
              <?php foreach ($records['items'] as $record) { ?>
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
                <!--削除ボタン-->
                <td>
                  <div class="list-delete">
                    <form action="dashboard.php" method="post" id="delete_form">
                      <input type="submit" value="削除" onclick="return confirm('データを削除してもよろしいですか？')">
                      <input type="hidden" name="module" value="admin_items">
                      <input type="hidden" name="action" value="delete">
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
    <?php include INCLUDE_DIR . '/admin/homebutton.php'; ?>
  </main>
  <?php include INCLUDE_DIR . '/admin/footer.php'; ?>
</body>

</html>