<?php
//設定オプションの値を設定する
ini_set('error_reporting', E_ALL);
ini_set('display_errors', "On");

//セッションに関連する INI 設定をセキュアにする 


//dispatch関数の入ったコントローラー及び基本クラスの読み込み
require_once('./controller/controller.php');

//$urlの定数定義（Viewクラス内render()時に使用）
define('BASE_URL',basename(__FILE__));

//defaultのアクセス
dispatch('admin_dashboard','index');