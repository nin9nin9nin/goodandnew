<?php
require_once(MODEL_DIR . '/Tables/Items.php');
require_once(MODEL_DIR . '/Tables/Stocks.php');
require_once(MODEL_DIR . '/Tables/Categorys.php'); //selectOption呼び出し
require_once(MODEL_DIR . '/Tables/Brands.php'); //selectOption呼び出し
require_once(MODEL_DIR . '/Tables/Events.php'); //selectOption呼び出し

function execute_action() {
    $id = Request::get('item_id');

    if (preg_match('/^\d+$/', $id) !== 1) {
        return View::render404();
    }

    Session::start();
    //トークンの作成
    Session::setCsrfToken();
    
    //クラス生成（初期化）
    $classItems = new Items();
    
    //プロパティに値をセット
    $classItems -> item_id = $id;
    
    //指定レコードの取得
    $records[0] = $classItems -> editItem();
    
    //categorysテーブルの取得　select/option用
    $records['categorys'] = Categorys::selectOption_Categorys();
    
    //brandsテーブルの取得　select/option用
    $records['brands'] = Brands::selectOption_Brands();
    
    //shopsテーブルの取得　select/option用
    $records['events'] = Events::selectOption_Events();
    
    
    return View::render('edit', ['records' => $records]);
}