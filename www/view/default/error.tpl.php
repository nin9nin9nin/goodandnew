<?php
$title = 'goodandnew管理画面';
$description = '説明（エラーメッセージページ）';
$is_home = NULL; //トップページの判定用の変数
include INCLUDE_DIR . '/admin/head.php'; // head.php の読み込み
?>
</head>

<body>
  <?php include INCLUDE_DIR . '/admin/header.php'; ?>

    <main>
      <!--エラーメッセージ----------------------------------------------->
      <div id="errors">
        <div class="container">
          <div class="title">
            <h1>エラーメッセージ</h1>
          </div>
          <div class="message">
            <div class="errors">
            <?php if (count($errors) > 0): ?>
              <ul class="alert alert-danger mb-5">
              <?php foreach ($errors as $error): ?>
                <li><?php echo h($error); ?></li>
              <?php endforeach; ?>
              </ul>
            <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
      <?php include INCLUDE_DIR . '/admin/homebutton.php'; ?>
    </main>
  <?php include INCLUDE_DIR . '/admin/footer.php'; ?>
</body>
</html>
