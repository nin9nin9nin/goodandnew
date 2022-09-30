<?php
$title = 'ec site 管理画面';
$description = '説明（カテゴリー管理ページ）';
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
          <h2>カテゴリー登録</h2>
        </div>
        
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
                    <!--<option value="">選択してください</option>-->
                    <option value="0">未設定</option>
                    <?php foreach ($records['categorys'] as $record) { ?>
                    <option value="<?php print h($record->category_id); ?>"><?php print h($record->category_name)?></option>
                    <?php } ?>
                  </select>
                  <small>例：書籍&raquo;1_ジャンル, 2021年12月&raquo;2_マンスリー&ensp;&hellip;</small>
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
                    </form>
                  </div>
                </td>
                <!--削除ボタン-->
                <td>
                  <div class="list-delete">
                    <form action="dashboard.php" method="post" id="delete_form">
                      <input type="submit" value="削除">
                      <input type="hidden" name="module" value="admin_categorys">
                      <input type="hidden" name="action" value="delete">
                      <input type="hidden" name="category_id" value="<?php print h($record->category_id); ?>">
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
        
        <!--<div class="alldelete">-->
        <!--  <div class="form-buttonwrap">-->
        <!--    <form action="dashboard.php" method="post">-->
        <!--      <input type="submit" value="全てを削除する">-->
        <!--      <input type="hidden" name="module" value="admin_categorys">-->
        <!--      <input type="hidden" name="action" value="delete_all">-->
        <!--      <input type="hidden" name="table" value="categorys">-->
              <!--今は使用しない-->
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