<?php
var_dump($errors);

$title = 'ec site 管理画面';
$description = '説明（エラーメッセージページ）';
//$is_home = true; //トップページの判定用の変数
include './include/view/_inc/admin/head.php'; // head.php の読み込み
?>
</head>

<body>
  <?php include './include/view/_inc/admin/header.php'; ?>

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
      <?php include './include/view/_inc/admin/homebutton.php'; ?>
    </main>
  <?php include './include/view/_inc/admin/footer.php'; ?>
</body>
</html>
