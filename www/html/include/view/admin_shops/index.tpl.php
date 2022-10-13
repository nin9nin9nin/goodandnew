<?php
$title = 'ec site 管理画面';
$description = '説明（ショップ管理ページ）';
// $is_home = true; //トップページの判定用の変数
$flash_message = Session::getFlash();
include 'inc/admin/head.php'; // head.php の読み込み
?>
</head>

<body>
  <?php include 'inc/admin/header.php'; ?>
  
  <main>
    <!--タイトルナビ---------------------------------------------------------------------------------------------------->
    <div id="title">
      <div class="container">  
      
        <nav class="title-nav">
          <span>
            <a href="<?php echo url_for('admin_shops', 'index'); ?>">ショップ管理</a>
          </span>
          <span>&gt;</span>
        </nav>
        
        <div class="title">
          <h1>ショップ管理</h1>
        </div>
        <!--フラッシュメッセージ-->
        <?php if ($flash_message !== '') { ?>
          <div class="message">
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
          <h2>ショップ登録</h2>
        </div>
        
        <!--入力フォーム-->
        <div class="create-form">
          <form action="dashboard.php" method="post">
            <table class="create-form table">
              <tr class="form-text">
                <th>
                  <label for="shop_name">ショップ名：</label><span class="hissu">必須</span>
                </th>
                <td>
                  <input id="shop_name" type="text" name="shop_name" value="">
                </td>
              </tr>
              <tr class="form-text">
                <th>
                  <label for="description">ショップ説明：</label><span class="ninni">任意</span>
                </th>
                <td>
                  <textarea id="description" name="description" value="" rows="10" cols="60" placeholder="テキストを入力"></textarea>
                </td>
              </tr>
              <tr class="form-text">
                <th>
                  <label for="shop_hp">ショップHP：</label><span class="ninni">任意</span>
                </th>
                <td>
                  <input id="shop_hp" type="url" name="shop_hp" value="" placeholder="http://www.○○○.com">
                </td>
              </tr>
              <tr class="form-text">
                <th>
                  <label for="shop_link1">ショップLINK：</label>
                </th>
                <td>
                  <input id="shop_link1" type="url" name="shop_link1" value="" placeholder="https://www.instagram.com/...">
                </td>
              </tr>
              <tr class="form-text">
                <th>
                  <label for="shop_link2">ショップLINK：</label>
                </th>
                <td>
                  <input id="shop_link2" type="url" name="shop_link2" value="" placeholder="https://www.facebook.com/...">
                </td>
              </tr>
              <tr class="form-text">
                <th>
                  <label for="shop_link3">ショップLINK：</label>
                </th>
                <td>
                  <input id="shop_link3" type="url" name="shop_link3" value="" placeholder="https://www.twitter.com/ ...">
                </td>
              </tr>
              <tr class="form-text">
                <th>
                  <label for="shop_link4">ショップLINK：</label>
                </th>
                <td>
                  <input id="shop_link4" type="url" name="shop_link4" value="" placeholder="https://www.youtube.com/ ...">
                </td>
              </tr>
              <tr class="form-text">
                <th>
                  <label for="phone_number">電話番号：</label><span class="ninni">任意</span>
                </th>
                <td>
                  <input id="phone_number" type="tel" name="phone_number" value="" placeholder="※ハイフンなし">
                </td>
              </tr>
              <tr class="form-text">
                <th>
                  <label for="email">メールアドレス：</label><span class="ninni">任意</span>
                </th>
                <td>
                  <input id="email" type="email" name="email" value="" placeholder="">
                </td>
              </tr>
              <tr class="form-text">
                <th>
                  <label for="address">住所：</label><span class="ninni">任意</span>
                </th>
                <td>
                  <input id="address" type="text" name="address" value="" placeholder="">
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
              <input type="submit" value="ショップ登録">
              <input type="hidden" name="module" value="admin_shops">
              <input type="hidden" name="action" value="create">
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
          <h2>ショップ情報</h2>
        </div>
        
        <!--list 一覧テーブル-->
        <div class="list-group">
          
          <table>
            <caption>ショップ一覧</caption>
            <thead>
              <tr>
                <th class="list-id">ID</th>
                <th class="list-name">ショップ名</th>
                <th class="list-count">アイテム数</th>
                <th class="list-status">ステータス</th>
                <th class="list-delete">削除</th>
                <th class="list-detail"></th>
              </tr>
            </thead>
            <?php if(count($records['shops']) > 0) { ?>
            <tbody>
              <?php foreach ($records['shops'] as $record) { ?>
              <tr class="<?= $record->status ? 'true' : 'false' ?>">
                <td class="list_id">
                    <?php print h($record -> shop_id); ?>
                </td>
                <td class="list_name">
                  <a href="dashboard.php?module=admin_shops&action=edit&shop_id=<?php print h($record->shop_id); ?>">
                    <p><?php print h($record -> shop_name); ?></p>
                  </a>
                </td>
                <td class="list_count">
                  <?php print h($record -> item_count); ?>
                </td>
                <!--ステータス-->
                <td class="list-status">
                  <div class="status-checkbox">
                    <form action="dashboard.php" method="post">
                      <input id="status_<?php print h($record->shop_id); ?>" type="checkbox" name="status" value="1" ONCHANGE="this.form.submit();" <?= $record->status ? 'checked' : '' ?> >
                      <label for="status_<?php print h($record->shop_id); ?>">
                        <span></span>
                      </label>
                      <div class="list-switch"></div>
                      <input type="hidden" name="module" value="admin_shops">
                      <input type="hidden" name="action" value="update_status">
                      <input type="hidden" name="shop_id" value="<?php print h($record->shop_id); ?>">
                    </form>
                  </div>
                </td>
                <!--削除ボタン-->
                <td>
                  <div class="list-delete">
                    <form action="dashboard.php" method="post" id="delete_form">
                      <input type="submit" value="削除">
                      <input type="hidden" name="module" value="admin_shops">
                      <input type="hidden" name="action" value="delete">
                      <input type="hidden" name="shop_id" value="<?php print h($record->shop_id); ?>">
                    </form>
                  </div>
                </td>
                <!--詳細リンク-->
                <td>
                  <div class="list-detail">
                    <a href="dashboard.php?module=admin_shops&action=edit&shop_id=<?php print h($record->shop_id); ?>">
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
        
        <!--<div class="alldelete">-->
        <!--  <div class="form-buttonwrap">-->
        <!--    <form action="dashboard.php" method="post">-->
        <!--      <input type="submit" value="全てを削除する">-->
        <!--      <input type="hidden" name="module" value="admin_shops">-->
        <!--      <input type="hidden" name="action" value="delete_all">-->
        <!--      <input type="hidden" name="table" value="shops">-->
        <!--    </form>-->
        <!--  </div>-->
        <!--</div>-->
        
    </div>
    </div>
    
    <div id="home">
      <div class="container">
        <div class="home">
          <div class="form-buttonwrap">
              <input type="button" value="ホーム画面に戻る" onclick="location.href='dashboard.php'">
          </div>
        </div>
      </div>
    </div>
    
  </main>
  
<?php include 'inc/admin/footer.php'; ?>
  
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