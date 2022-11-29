<?php
$title = 'goodandnew管理画面';
$description = '説明（ページエラー）';
$is_home = NULL; //トップページの判定用の変数
include INCLUDE_DIR . '/admin//head.php'; // head.php の読み込み
?>
</head>

<body>
  <?php include INCLUDE_DIR . '/admin//header.php'; ?>

    <main>
      <div class="container">
        <div class="message">
          <h1 class="display-2 text-muted">404 Not Found</h1>
          <p class="h4 text-muted">ページが見つかりませんでした</p>
        </div>
      </div>
      <?php include INCLUDE_DIR . '/admin/homebutton.php'; ?>
    </main>
  <?php include INCLUDE_DIR . '/admin//footer.php'; ?>
  </body>
</html>
