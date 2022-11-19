<?php

require_once(MODEL_DIR . '/Tables/Events.php');
require_once(MODEL_DIR . '/Tables/Shops.php');
require_once(MODEL_DIR . '/Tables/Items.php');

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
    $classItems = new Items();
    
    //プロパティに値をセット
    $classEvents -> event_id = $event_id;
    $classShops -> event_id = $event_id;
    $classItems -> event_id = $event_id;

    //イベント情報の取得 (1レコードのみ)
    $records['event'] = $classEvents -> editEvent(); 

    //レコメンドアイテム一覧の取得
    $records['recommend_items'] = $classShops -> indexRecommendItems();  
    
    //専用アイテム一覧の取得
    $records['exclusive_items'] = $classItems -> indexExclusiveItems(); //今後Shopsに変更
    
    return View::render('register_recommend_items', ['records' => $records]);
}