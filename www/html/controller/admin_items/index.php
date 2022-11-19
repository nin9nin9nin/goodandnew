<?php
require_once(MODEL_DIR . '/Tables/Items.php');
require_once(MODEL_DIR . '/Tables/Stocks.php');
require_once(MODEL_DIR . '/Tables/Categorys.php'); //selectOption呼び出し
require_once(MODEL_DIR . '/Tables/Brands.php'); //selectOption呼び出し
require_once(MODEL_DIR . '/Tables/Events.php'); //selectOption呼び出し


function execute_action() {
    Session::start();
    //認証済みか判定 ($_SESSION['_authenticated'](bool)を受け取る)
    if (Session::isAuthenticated() !== true) {
        //認証済みでなければサインアップにリダイレクト (ログイン画面に移行される)
        return View::redirectTo('admin_accounts', 'signin');
        exit;
    }

    // CSRF対策(POST投稿を行うフォームに対して必ず行う)
    //トークンの作成
    Session::setCsrfToken();

    //ページIDの取得（なければ1が格納される）
    $page_id = Request::getPageId('page_id');

    //GETの値を確認
    if (preg_match('/^\d+$/', $page_id) !== 1) {
        return View::render404();
    }

    //クラスの生成（初期化）
    $classItems = new Items();

    //プロパティに値をセット(ページネーション)
    $classItems -> page_id = $page_id;

    //itemsの取得　（page_idから指定した分だけ/10アイテムのみ）
    $records['items'] = $classItems -> indexItems();
    
    //categorysテーブルの取得　select/option用
    $records['categorys'] = Categorys::selectOption_Categorys();
    
    //brandsテーブルの取得　select/option用
    $records['brands'] = Brands::selectOption_Brands();
    
    //shopsテーブルの取得　select/option用
    $records['events'] = Events::selectOption_Events();

    //ページネーションに必要な値一式
    $paginations = $classItems -> getPaginations();
    
    //render()にて$filename作成・読み込み ・・・〇〇.tpl.php
    //params[]に値の受け渡し
    return View::render('index', ['records' => $records, 'paginations' => $paginations]);
}
