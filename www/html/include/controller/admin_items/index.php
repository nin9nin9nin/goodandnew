<?php
require_once(MODEL_DIR . '/Tables/Items.php');
require_once(MODEL_DIR . '/Tables/Stocks.php');
require_once(MODEL_DIR . '/Tables/Categorys.php');
require_once(MODEL_DIR . '/Tables/Brands.php');
require_once(MODEL_DIR . '/Tables/Shops.php');


function execute_action() {
    //認証済みか判定 ($_SESSION['_authenticated']を受け取る)
    $session = Session::getInstance() -> isAuthenticated();
    
    if ($session !== true) {
        //認証済みでなければサインアップにリダイレクト (ログイン画面に移行される)
        return View::redirectTo('admin_accounts', 'signin');
        exit;
        
    }
    
    //クラスの生成（初期化）
    $classItems = new Items();
    
    //items,stocks 結合テーブルの取得
    $records['items'] = $classItems -> indexItems();
    
    //categorysテーブルの取得　select/option用
    $records['categorys'] = Categorys::selectOption_Genre();
    
    //brandsテーブルの取得　select/option用
    $records['brands'] = Brands::selectOption_Brands();
    
    //shopsテーブルの取得　select/option用
    $records['shops'] = Shops::selectOption_Shops();
    
    
    //render()にて$filename作成・読み込み ・・・〇〇.tpl.php
    return View::render('index', ['records' => $records]);
}
