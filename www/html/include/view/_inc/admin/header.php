  <header class="header wrapper">
      
      <div class="header-logo">
        <a <?php echo isset($is_home) ? '': 'href="dashboard.php"' ?>> 
        <h1>管理システム</h1>
        </a>
      </div>
      
      <nav class="header-nav">
        <ul>
          <li><a href="<?php echo url_for('admin_events', 'index'); ?>"><span>イベント管理</span></a></li>
          <li><a href="<?php echo url_for('admin_categorys', 'index'); ?>"><span>カテゴリー管理</span></a></li>
          <li><a href="<?php echo url_for('admin_brands', 'index'); ?>"><span>ブランド管理</span></a></li>
          <li><a href="<?php echo url_for('admin_items', 'index'); ?>"><span>商品管理</span></a></li>
          <li><a href="<?php echo url_for('admin_users', 'index'); ?>"><span>ユーザー管理</span></a></li>
          <li><a href="<?php echo url_for('admin_orders', 'index'); ?>"><span>オーダー管理</span></a></li>
          <!--<li><a href=""><span>購入管理</span></a></li>-->
          <!--<li><a href=""><span>顧客管理</span></a></li>-->
          <!--<li><a href=""><span>データ管理</span></a></li>-->
          <li class="account">
            <a href="<?php echo url_for('admin_accounts', 'index'); ?>"><span>アカウント</span></a>
            <ul class="child">
              <li>
                  <div class="child-logout">
                      <form action="index.php" method="post">
                          <input type="submit" value="ログアウト">
                          <input type="hidden" name="module" value="admin_accounts">
                          <input type="hidden" name="action" value="logout">
                      </form>
                  </div>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
  </header>
