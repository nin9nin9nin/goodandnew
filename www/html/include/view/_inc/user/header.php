<header class="header wrapper">
                <h1 class="logo">
                    <a <?php echo isset($is_home) ? '': 'href="index.php"' ?>>
                        <!--<img class="logo" src="" alt="">LOGO-->
                        logo
                    </a>
                </h1>
                <nav>
                    <ul class="main-nav">
                        <li class="account">
                            <a href="<?php echo url_for('users', 'account'); ?>">
                                <img class="nav" src="./images/iconmonstr-user-male-thin.svg" alt="アカウント">
                            </a>
                            <ul class="child">
                                <li>
                                    <div class="child-logout">
                                        <form action="index.php" method="post">
                                            <input type="submit" value="ログアウト">
                                            <input type="hidden" name="module" value="users">
                                            <input type="hidden" name="action" value="logout">
                                        </form>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <li class="favorite">
                            <!--<a href="<?php echo url_for('favorites', 'index'); ?>">-->
                                <img class="nav" src="./images/iconmonstr-heart-thin.svg" alt="お気に入り">
                            <!--</a>-->
                        </li>
                        <li class="shopping-cart">
                            <a href="<?php echo url_for('carts', 'index'); ?>">
                                <span class="cart-count"><?php print h($cart_count); ?></span>
                                <img class="nav" src="./images/iconmonstr-shopping-cart-thin.svg" alt="カート">
                            </a>
                        </li>
                    </ul>
                    <!--フラッシュメッセージ-->
                    <?php if ($flash_message !== '') { ?>
                      <div class="fade-message">
                        <p class="flash"><?php echo $flash_message; ?></p>
                      </div>
                    <?php } ?>
                </nav>
            </header>