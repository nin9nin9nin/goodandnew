<?php
$title = 'GOOD&NEW オンラインショップ';
$is_top = NULL; //トップページの判定(isset)
Session::start();
$flash_message = Session::getFlash(); // フラッシュメッセージの取得
$cart_count = Session::get('cart_count', ""); //カート内のアイテム数を取得
include INCLUDE_DIR . '/user/head.php'; // head.php の読み込み
?>
</head>
<body>
    <?php include INCLUDE_DIR . '/user/header_fixed.php'; ?>
    <main>
        <section class="area" id="concept">
            <nav class="page-nav wrapper">
                <span>
                    <a href="index.php?module=concept&action=index">CONCEPT</a>
                </span>
                <span>&gt;</span>
            </nav><!-- / .page-nav -->
            <div class="box fadeUpTrigger wrapper">
                <h3 class="section-title">CONCEPT</h3>
                <div class="concept-area">
                    <div class="concept-caption">
                        良いものと、新しい発見に出会う
                    </div>
                    <div class="concept-text-box">
                        <p class="concept-text">
                            ブランドの魅力、作り手の想いを伝えるをコンセプトに
                            <br>
                            わがままに、気の向くままに、毎月変わるポップアップショップを開催
                            <br>
                            わがままに、気の向くままに、毎月変わるポップアップショップを開催
                        </p>
                        <p class="concept-text">
                            ブランドの魅力、作り手の想いを伝えるをコンセプトに
                            <br>
                            わがままに、気の向くままに、毎月変わるポップアップショップを開催
                            <br>
                            わがままに、気の向くままに、毎月変わるポップアップショップを開催
                        </p>
                    </div>
                    <div class="concept-image">
                        <img src="./assets/images/baby/concept.png" alt="イメージ画像">
                    </div>
                </div>
            </div><!-- .box-->
        </section><!-- / #concept -->
        <?php include INCLUDE_DIR . '/user/f-nav.php'; ?>
    </main>
    <?php include INCLUDE_DIR . '/user/footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/stickyfill/2.1.0/stickyfill.min.js"></script>
    <script src="./assets/js/user/common.js"></script>
</body>

</html>