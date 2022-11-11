<?php

require_once(MODEL_DIR . '/Tables/Events.php');
require_once(MODEL_DIR . '/Tables/Shops.php');


function execute_action() {
    // idの取得
    $id = Request::get('event_id');

    if (preg_match('/^\d+$/', $id) !== 1) {
        return View::render404();
    }

    //ページIDの取得（なければ1が格納される）
    $page_id = Request::getPageId('page_id');

    //GETの値を確認
    if (preg_match('/^\d+$/', $page_id) !== 1) {
        return View::render404();
    }

    Session::start();
    //トークンの作成
    Session::setCsrfToken();
    
    //クラス生成（初期化）
    $classShops = new Shops();
    $classEvents = new Events();
    
    //プロパティに値をセット
    $classShops -> page_id = $page_id;
    $classShops -> event_id = $id;
    $classEvents -> event_id = $id;
    
    //指定レコードの取得
    $records['event'] = $classEvents -> editEvent(); 
    
    //指定レコードの取得
    // $records['exclusive_brands'] = $classShops -> indexExclusiveBrands(); 

    //指定レコードの取得
    // $records['recommend_items'] = $classShops -> Event(); 

    //指定レコードの取得
    // $records['exclusive_items'] = $classShops -> Event(); 

    //ページネーションに必要な値一式
    // $paginations = $classShops -> getPaginations();
    
    return View::render('exclusive', ['record' => $record, 'paginations' => $paginations]);
}