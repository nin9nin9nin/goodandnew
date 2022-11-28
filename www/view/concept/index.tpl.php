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
                        <span>「いいもの(GOOD)」と</span><span>「新しい発見(NEW)」を伝える</span>
                    </div>
                    <div class="concept-text-box">
                        <div class="concept-text">
                            <div><span>好奇心旺盛で、気の向くままに、</span></div>
                            <div><span>それでいて好きな物に出会うと</span><span>異常な執着を見せる</span></div>
                            <div><span>周りから見ると不思議だけど、</span><span>ほっとけないような存在</span></div>
                            <div><span>それがGOOD&NEWという</span><span>オンラインショップだと思っています。</span></div>
                        </div>
                        <div class="concept-text">
                            <div><span>ブランドの魅力、商品へのこだわり、</span><span>作り手の想いを伝えるため。</span></div>
                            <div><span>ただ商品を見比べたり、イメージだけで</span><span>買い物をするオンラインショップではなく</span></div>
                            <div><span>あえて選択肢を限定し、</span><span>伝えることに集中したオンラインショップで</span></div>
                            <div><span>ブランドと人とを繋げたいと考えています。</span></div>
                        </div>
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