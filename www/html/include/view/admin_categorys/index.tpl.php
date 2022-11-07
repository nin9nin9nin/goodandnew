<?php
$title = 'ec site 管理画面';
$description = '説明（カテゴリー管理ページ）';
$is_home = NULL; //トップページの判定
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
            <a href="<?php echo url_for('admin_categorys', 'index'); ?>">カテゴリー管理</a>
          </span>
          <span>&gt;</span>
        </nav>
        
        <div class="title">
          <h1>カテゴリー管理</h1>
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
          <h2>カテゴリー登録</h2>
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
          <form action="dashboard.php" method="post">
            <table class="create-form table">
              <tr class="form-text">
                <th>
                  <label for="category_name">カテゴリー名：</label><span class="hissu">必須</span>
                </th>
                <td>
                  <input id="category_name" type="text" name="category_name" value="">
                </td>
              </tr>
              <tr class="form-select">
                <th>
                  <label for="parent_id">親カテゴリー：</label><span class="hissu">必須</span>
                </th>
                <td>
                  <select id="parent_id" name="parent_id">
                    <option value="">選択してください</option>
                    <?php foreach ($records['parents'] as $record) { ?>
                    <option value="<?php print h($record->category_id); ?>"><?php print h($record->category_name)?></option>
                    <?php } ?>
                  </select>
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
              <input type="submit" value="カテゴリー登録">
              <input type="hidden" name="module" value="admin_categorys">
              <input type="hidden" name="action" value="create">
              <input type="hidden" name="token" value="<?=h($token)?>">
            </div>
          </form>
        </div>
      </div>
    </div>
    <!--カテゴリー------------------------------------------------------------------------------------------------------------>
    <div id="list">
      <div class="container">
        
        <!--list タイトル-->
        <div class="title">
          <h2>カテゴリー情報</h2>
        </div>
        <!-- props -->
        <div class="search-sorting">
          <div class="input-area">
            <div class="keyword">
              <form action="dashboard.php" method="get" role="search" id="searchform">
                <?php if (isset($search['keyword'])) { ?>
                  <?php foreach ($search as $key => $value) { ?>
                  <input type="text" name="search[keyword]" value="<?php print h($value); ?>" id="search-text-in-page" placeholder="カテゴリー名">
                  <?php } ?>
                <?php } else { ?>
                  <input type="text" name="search[keyword]" value="" id="search-text-in-page" placeholder="カテゴリー名">
                <?php } ?>
                  <input type="submit" id="searchsubmit" value="search">
                  <input type="hidden" name="module" value="admin_categorys">
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
                            <label for="filter">親カテゴリ</label>
                          </th>
                          <td class="select-name">
                            <select id="filter" name="search[filter]" ONCHANGE="submit(this.form)">
                                <option value="">選択してください</option>
                                <?php foreach ($records['parents'] as $record) { ?>
                                <option value="<?php print h($record->category_id); ?>"><?php print h($record->category_id) .':'. h($record->category_name)?></option>
                                <?php } ?>
                            </select>
                          </td>
                      </tr>
                  </table>
                  <input type="hidden" name="module" value="admin_categorys">
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
                              <?php if ($sorting !== '') { ?>
                                <?php if ($sorting === '0') { ?>
                                  <option value="0">カテゴリー名順</option>
                                  <option value="1">昇順</option>
                                  <option value="2">降順</option>
                                <?php } else if ($sorting === '1') { ?>
                                  <option value="1">昇順</option>
                                  <option value="2">降順</option>
                                  <option value="0">カテゴリー名順</option>
                                <?php } else if ($sorting === '2') { ?>
                                  <option value="2">降順</option>
                                  <option value="0">カテゴリー名順</option>
                                  <option value="1">昇順</option>
                                <?php } ?>
                              <?php } else { ?>
                                <option value="">選択してください</option>
                                <option value="0">カテゴリー名順</option>
                                <option value="1">昇順</option>
                                <option value="2">降順</option>
                              <?php } ?>
                            </select>
                          </td>
                      </tr>
                  </table>
                  <input type="hidden" name="module" value="admin_categorys">
                  <input type="hidden" name="action" value="sorting">
              </form>
            </div>
          </div>
        </div>
        <!--list 一覧テーブル-->
        <div class="list-group">
          <table>
            <caption>カテゴリー一覧</caption>
            <thead>
              <tr>
                <th class="list-id">ID</th>
                <th class="list-name">カテゴリー名</th>
                <th class="list-info">親カテゴリー</th>
                <th class="list-status">ステータス</th>
                <th class="list-delete">削除</th>
                <th class="list-detail"></th>
              </tr>
            </thead>
            <?php if(count($records) > 0) { ?>
            <tbody>
              <?php foreach ($records['categorys'] as $record) { ?>
              <tr class="<?= $record->status ? 'true' : 'false' ?>">
                <td class="list_id">
                    <?php print h($record -> category_id); ?>
                </td>
                <td class="list_name">
                  <a href="dashboard.php?module=admin_categorys&action=edit&category_id=<?php print h($record->category_id); ?>">
                    <p><?php print h($record -> category_name); ?></p>
                  </a>
                </td>
                <td class="list_parent">
                  <?php print h($record -> parent_name); ?>
                </td>
                <!--ステータス-->
                <td class="list-status">
                  <div class="status-checkbox">
                    <form action="dashboard.php" method="post">
                      <input id="status_<?php print h($record->category_id); ?>" type="checkbox" name="status" value="1" 
                             ONCHANGE="this.form.submit();" <?= $record->status ? 'checked' : '' ?> >
                      <label for="status_<?php print h($record->category_id); ?>">
                        <span></span>
                      </label>
                      <div class="list-switch"></div>
                      <input type="hidden" name="module" value="admin_categorys">
                      <input type="hidden" name="action" value="update_status">
                      <input type="hidden" name="category_id" value="<?php print h($record->category_id); ?>">
                      <input type="hidden" name="token" value="<?=h($token)?>">
                    </form>
                  </div>
                </td>
                <!--削除ボタン-->
                <td>
                  <div class="list-delete">
                    <form action="dashboard.php" method="post" id="delete_form">
                      <input type="submit" value="削除" onclick="return confirm('データを削除してもよろしいですか？')">
                      <input type="hidden" name="module" value="admin_categorys">
                      <input type="hidden" name="action" value="delete">
                      <input type="hidden" name="category_id" value="<?php print h($record->category_id); ?>">
                      <input type="hidden" name="token" value="<?=h($token)?>">
                    </form>
                  </div>
                </td>
                <!--詳細リンク-->
                <td>
                  <div class="list-detail">
                    <a href="dashboard.php?module=admin_categorys&action=edit&category_id=<?php print h($record->category_id); ?>">
                      <span>詳細</span>
                    </a>
                  </div>
                </td>
              </tr>
              <?php } ?>
            </tbody>
              <?php } else { ?>
              <p class="errors">カテゴリー情報がありません。</p>
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
    <?php include './include/view/_inc/admin/homebutton.php'; ?>
  </main>
  <?php include './include/view/_inc/admin/footer.php'; ?>
</body>

</html>