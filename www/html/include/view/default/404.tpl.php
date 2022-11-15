<?php
$title = 'goodandnew管理画面';
$description = '説明（ページエラー）';
$is_home = NULL; //トップページの判定用の変数
include './include/view/_inc/admin//head.php'; // head.php の読み込み
?>
</head>

<body>
  <?php include './include/view/_inc/admin//header.php'; ?>

    <main>
      <div class="container">
        <div class="message">
          <h1 class="display-2 text-muted">404 Not Found</h1>
          <p class="h4 text-muted">ページが見つかりませんでした</p>
        </div>
      </div>
      <?php include './include/view/_inc/admin/homebutton.php'; ?>
    </main>
  <?php include './include/view/_inc/admin//footer.php'; ?>
  </body>
</html>
