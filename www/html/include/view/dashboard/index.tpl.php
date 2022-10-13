<?php
$title = 'ec site 管理画面';
$description = '説明（トップページ）';
$is_home = true; //トップページの判定用の変数
$flash_message = Session::getFlash();
$admin_name = Session::get('admin_name',"");
include 'inc/admin/head.php'; // head.php の読み込み
?>
</head>

<body>
  <?php include 'inc/admin/header.php'; ?>
  
  <main>
    <!---コンテンツニュース----------------------------------------------------------------------------------------------------------->
    <div id="dashboard">
      <div class="container">
        <!--フラッシュメッセージ-->
        <?php if ($flash_message !== '') { ?>
          <div class="message">
            <p class="flash"><?php echo $flash_message; ?></p>
          </div>
        <?php } ?>
        <div class="message">
          <div class="completed">
            <h1 class="display-2 text-muted">Login Complete</h1>
            <p class="h4 text-muted">ようこそ<?php print h($admin_name); ?></p>
          </div>
        </div>
        <div class="news">
          
        </div>
        <div class="topics">
          
        </div>
      </div>
    </div>

  </main>
  
  <?php include 'inc/admin/footer.php'; ?>
  
</body>

</html>