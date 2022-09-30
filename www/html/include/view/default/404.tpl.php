<?php
$title = 'ec site 管理画面';
$description = '説明（ページエラー）';
// $is_home = true; //トップページの判定用の変数
include 'inc/admin/head.php'; // head.php の読み込み
?>
</head>

<body>
  <?php include 'inc/admin/header.php'; ?>

    <main>
      <div class="container">
        <div class="message">
          <h1 class="display-2 text-muted">404 Not Found</h1>
          <p class="h4 text-muted">ページが見つかりませんでした</p>
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
  </body>
</html>
