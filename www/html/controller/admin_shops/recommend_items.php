<?php

require_once(MODEL_DIR . '/Tables/Events.php');
require_once(MODEL_DIR . '/Tables/Shops.php');

function execute_action() {
    // idの取得
    $event_id = Request::get('event_id');

    //GETの値を確認
    if (preg_match('/^\d+$/', $event_id) !== 1) {
        return View::render404();
    }

    Session::start();
    //トークンの作成
    Session::setCsrfToken();
    
    //クラス生成（初期化）
    $classEvents = new Events();
    $classShops = new Shops();
    
    //プロパティに値をセット
    $classEvents -> event_id = $event_id;
    $classShops -> event_id = $event_id;
    
    //イベント情報の取得
    $records['event'] = $classEvents -> editEvent(); 

    //レコメンドアイテム一覧の取得
    $records['recommend_items'] = $classShops -> indexRecommendItems();  
    
    //レコメンドアイテム詳細画面へ
    return View::render('recommend_items', ['records' => $records]);
}