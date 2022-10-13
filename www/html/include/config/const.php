<?php
//ユーザー情報　定数定義
define('DB_HOST', 'mysql');
define('DB_USER', 'testuser');
define('DB_PASS', 'password');
define('DB_NAME', 'sample');
define('DB_CHARSET', 'utf8');
//DSN文字列
define('DSN', 'mysql:dbname=' . DB_NAME . ';host=' . DB_HOST . ';charset=' . DB_CHARSET);