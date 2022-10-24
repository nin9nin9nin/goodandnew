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

    //ページIDの取得（なければ1が格納される）
    $page_id = Request::getPageId('page_id');

    //クラスの生成（初期化）
    $classItems = new Items();

    //プロパティに値をセット(ページネーション)
    $classItems -> page_id = $page_id;

    //ページネーションに必要な値一式
    $paginations = $classItems -> getPaginations();

    //itemsの取得　（page_idから指定した分だけ/10アイテムのみ）
    $records['items'] = $classItems -> indexItems();
    
    //categorysテーブルの取得　select/option用
    $records['categorys'] = Categorys::selectOption_Genre();
    
    //brandsテーブルの取得　select/option用
    $records['brands'] = Brands::selectOption_Brands();
    
    //shopsテーブルの取得　select/option用
    $records['shops'] = Shops::selectOption_Shops();
    
    //render()にて$filename作成・読み込み ・・・〇〇.tpl.php
    //params[]に値の受け渡し
    return View::render('index', ['records' => $records, 'page_id' => $page_id, 'paginations' => $paginations]);
}
