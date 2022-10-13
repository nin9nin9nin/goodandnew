<?php
$title = 'ec site 管理画面';
$description = '説明（ブランド管理ページ）';
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
            <a href="<?php echo url_for('admin_brands', 'index'); ?>">ブランド管理</a>
          </span>
          <span>&gt;</span>
        </nav>
        
        <div class="title">
          <h1>ブランド管理</h1>
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
          <h2>ブランド登録</h2>
        </div>
        
        <!--入力フォーム-->
        <div class="create-form">
          <form action="dashboard.php" method="post">
            <table class="create-form table">
              <tr class="form-text">
                <th>
                  <label for="brand_name">ブランド名：</label><span class="hissu">必須</span>
                </th>
                <td>
                  <input id="brand_name" type="text" name="brand_name" value="">
                </td>
              </tr>
              <tr class="form-select">
                <th>
                  <label for="category_id">マンスリー：</label><span class="ninni">任意</span>
                </th>
                <td>
                  <select id="category_id" name="category_id">
                    <!--<option value="">選択してください</option>-->
                    <option value="0">未設定</option>
                    <?php foreach ($records['categorys'] as $record) { ?>
                    <option value="<?php print h($record->category_id); ?>"><?php print h($record->category_name)?></option>
                    <?php } ?>
                  </select>
                </td>
              </tr>
              <tr class="form-text">
                <th>
                  <label for="description">ブランド説明：</label><span class="ninni">任意</span>
                </th>
                <td>
                  <textarea id="description" name="description" value="" rows="10" cols="60" placeholder="テキストを入力"></textarea>
                </td>
              </tr>
              <tr class="form-text">
                <th>
                  <label for="brand_hp">ブランドHP：</label><span class="ninni">任意</span>
                </th>
                <td>
                  <input id="brand_hp" type="url" name="brand_hp" value="" placeholder="http://www.○○○.com">
                </td>
              </tr>
              <tr class="form-text">
                <th>
                  <label for="brand_link1">ブランドLINK：</label>
                </th>
                <td>
                  <input id="brand_link1" type="url" name="brand_link1" value="" placeholder="https://www.instagram.com/...">
                </td>
              </tr>
              <tr class="form-text">
                <th>
                  <label for="brand_link2">ブランドLINK：</label>
                </th>
                <td>
                  <input id="brand_link2" type="url" name="brand_link2" value="" placeholder="https://www.facebook.com/...">
                </td>
              </tr>
              <tr class="form-text">
                <th>
                  <label for="brand_link3">ブランドLINK：</label>
                </th>
                <td>
                  <input id="brand_link3" type="url" name="brand_link3" value="" placeholder="https://www.twitter.com/ ...">
                </td>
              </tr>
              <tr class="form-text">
                <th>
                  <label for="brand_link4">ブランドLINK：</label>
                </th>
                <td>
                  <input id="brand_link4" type="url" name="brand_link4" value="" placeholder="https://www.youtube.com/ ...">
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
              <input type="submit" value="ブランド登録">
              <input type="hidden" name="module" value="admin_brands">
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
          <h2>ブランド情報</h2>
        </div>
        
        <!--list 一覧テーブル-->
        <div class="list-group">
          
          <table>
            <caption>ブランド一覧</caption>
            <thead>
              <tr>
                <th class="list-id">ID</th>
                <th class="list-name">ブランド名</th>
                <th class="list-info">マンスリー</th>
                <th class="list-count">アイテム数</th>
                <th class="list-status">ステータス</th>
                <th class="list-delete">削除</th>
                <th class="list-detail"></th>
              </tr>
            </thead>
            <?php if(count($records['brands']) > 0) { ?>
            <tbody>
              <?php foreach ($records['brands'] as $record) { ?>
              <tr class="<?= $record->status ? 'true' : 'false' ?>"> 
                <td class="list_id">
                    <?php print h($record -> brand_id); ?>
                </td>
                <td class="list_name">
                  <a href="dashboard.php?module=admin_brands&action=edit&brand_id=<?php print h($record->brand_id); ?>">
                    <p><?php print h($record -> brand_name); ?></p>
                  </a>
                </td>
                <td class="list_category">
                  <?php print h($record -> category_name); ?>
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
                      <input type="hidden" name="table" value="brands">
                      <input type="hidden" name="brand_id" value="<?php print h($record->brand_id); ?>">
                    </form>
                  </div>
                </td>
                <!--削除ボタン-->
                <td>
                  <div class="list-delete">
                    <form action="dashboard.php" method="post" id="delete_form">
                      <input type="submit" value="削除">
                      <input type="hidden" name="module" value="admin_brands">
                      <input type="hidden" name="action" value="delete">
                      <input type="hidden" name="brand_id" value="<?php print h($record->brand_id); ?>">
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
        
        <!--<div class="alldelete">-->
        <!--  <div class="form-buttonwrap">-->
        <!--    <form action="dashboard.php" method="post">-->
        <!--      <input type="submit" value="全てを削除する">-->
        <!--      <input type="hidden" name="module" value="admin_brands">-->
        <!--      <input type="hidden" name="action" value="delete_all">-->
        <!--      <input type="hidden" name="table" value="brands">-->
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