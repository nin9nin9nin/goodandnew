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
    //トークンの作成 (各種ステータス更新用)
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
    // $records['event'] = $classEvents -> getEventDetail(); //ユーザー画面
    
    //レコメンドアイテム一覧の取得
    $records['recommend_items'] = $classShops -> indexRecommendItems(); 
    // $records['recommends'] = $classShops -> getRecommendItems(); //ユーザー画面

    //専用アイテム一覧の取得
    $records['exclusive_items'] = $classItems -> indexExclusiveItems(); //今後Shopsに変更
    // $records['items'] = $classItems -> getExclusiveItems(); //ユーザー画面
    
    //専用ブランド一覧の取得
    $records['exclusive_brands'] = $classItems -> indexExclusiveBrands(); //今後Shopsに変更
    // $records['brands'] = $classItems -> getExclusiveBrands(); //ユーザー画面
    
    return View::render('exclusive', ['records' => $records]);
}