<?php
//ユーザー情報　定数定義
define('DB_HOST', 'mysql');
define('DB_USER', 'testuser');
define('DB_PASS', 'password');
define('DB_NAME', 'sample');
define('DB_CHARSET', 'utf8');
//DSN文字列
define('DSN', 'mysql:dbname=' . DB_NAME . ';host=' . DB_HOST . ';charset=' . DB_CHARSET);

//各ディレクトリを定数定義
define('CONFIG_DIR', '../config');
define('LIB_DIR', '../lib');
define('MODEL_DIR', '../model');
define('VIEW_DIR', '../view');

// html内
define('CONTROLLER_DIR', './controller');
define('ASSETS_DIR', './assets');
// assets内
define('IMG_DIR', ASSETS_DIR . '/images');
// 画像アップロードディレクトリ
define('ITEMS_ICON_DIR', IMG_DIR . '/items/icon/');
define('ITEMS_IMG_DIR', IMG_DIR . '/items/img/');
define('BRANDS_LOGO_DIR', IMG_DIR . '/brands/logo/');
define('BRANDS_IMG_DIR', IMG_DIR . '/brands/img/');
define('EVENTS_VISUAL_DIR', IMG_DIR . '/events/visual/');
define('EVENTS_IMG_DIR', IMG_DIR . '/events/img/');

//html  パーツinclude用
define('INCLUDE_DIR', VIEW_DIR . '/_inc');