<header id="header" class="fixed">
        <div class="openbtn1"><span></span><span></span><span></span></div>
        <nav id="g-nav">
            <div id="g-nav-list">
                <div class="g-nav-content">
                    <ul class="g-nav-list-main">
                        <li>
                            <div class="close-btn"></div>
                            <div id="search-wrap">
                                <form role="search" method="get" id="searchform" action="">
                                    <input type="text" value="" name="" id="search-text" placeholder="search">
                                    <input type="submit" id="searchsubmit" value="">
                                </form>
                            </div>
                        </li>
                        <li><a href="<?php echo url_for('top', 'index'); ?>">Top</a></li>
                        <li><a href="<?php echo url_for('concept', 'index'); ?>">CONCEPT</a></li>
                        <li><a href="<?php echo url_for('events', 'index'); ?>">EVENT</a></li>
                        <li><a href="<?php echo url_for('schedule', 'index'); ?>">SCHEDULE</a></li>
                        <li><a href="<?php echo url_for('gallery', 'index'); ?>">GALLERY</a></li>
                        <li><a href="<?php echo url_for('originals', 'index'); ?>">ORIGINALS</a></li>
                    </ul>
                    <div class="g-nav-list-link">
                        <ul class="link-icon-nav">
                            <li class="icon-instagram"><a href="#" target="_blank" rel="noopener noreferrer">instagram</a></li>
                            <li class="icon-twitter"><a href="#" target="_blank" rel="noopener noreferrer">twitter</a></li>
                            <li class="icon-facebook"><a href="#" target="_blank" rel="noopener noreferrer">facebook</a></li>
                            <li class="icon-youtube"><a href="#" target="_blank" rel="noopener noreferrer">youtube</a></li>
                            <li class="icon-line"><a href="#" target="_blank" rel="noopener noreferrer">line</a></li>
                        </ul>
                    </div>
                    <ul class="g-nav-list-sub">
                        <li><a href="<?php echo url_for('users', 'signin'); ?>">ログイン&middot;新規登録</a></li>
                        <li><a href="#">配送に関して</a></li>
                        <li><a href="#">ご利用ガイド</a></li>
                        <li><a href="#">プライバシーポリシー</a></li>
                        <li><a href="#">特定商取引に関する表示</a></li>
                        <li><a href="#">お問い合わせ</a></li>
                    </ul>
                </div><!-- /g-nav-content-->
            </div><!-- /g-nav-list-->
        </nav>
        <div class="logo">
            <a <?php echo isset($is_top) ? '': 'href="index.php"' ?> alt="GOODANDNEW">
                <svg>
                    <use xlink:href="./assets/images/logo/logo.svg#logo"></use>
                </svg>
            </a>
        </div>
        <div id="header-icon">
            <ul class="header-icon-btn">
                <li class="account">
                    <a href="<?php echo url_for('users', 'account'); ?>">
                        <svg>
                            <use xlink:href="./assets/images/icon/account.svg#account"></use>
                        </svg>
                    </a>
                </li>
                <li class="favorite">
                    <a href="<?php echo url_for('favorites', 'index'); ?>">
                        <svg>
                            <use xlink:href="./assets/images/icon/favorite.svg#favorite"></use>
                        </svg>
                    </a>
                </li>
                <li class="shopping-cart">
                    <a href="<?php echo url_for('carts', 'index'); ?>">
                        <span class="cart-count"><?php print h($cart_count); ?></span>
                        <svg>
                            <use xlink:href="./assets/images/icon/shopping-cart.svg#shopping-cart"></use>
                        </svg>
                    </a>
                </li>
            </ul>
        </div>
        <!--フラッシュメッセージ-->
        <?php if ($flash_message !== '') { ?>
            <div class="header-message">
            <p class="flash"><?php echo $flash_message; ?></p>
            </div>
        <?php } ?>
    </header>