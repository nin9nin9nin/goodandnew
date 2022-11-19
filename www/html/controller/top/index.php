<?php

require_once(MODEL_DIR . '/Tables/Events.php');
require_once(MODEL_DIR . '/Tables/Shops.php');
require_once(MODEL_DIR . '/Tables/Items.php');

function execute_action() {
    //クラス生成（初期化）
    $classEvents = new Events();
    $classShops = new Shops();
    $classItems = new Items();
    
    //公開中イベント情報の取得 (1レコードのみ retrieveBySql())
    $records['release_event'] = $classEvents -> getReleaseEvent(); //ユーザー画面

    //イベントIDのセット
    $event_id = $records['release_event'] -> event_id;
    
    //プロパティに値をセット
    $classShops -> event_id = $event_id;
    $classItems -> event_id = $event_id;
    
    //レコメンドアイテム一覧の取得
    $records['recommend_items'] = $classShops -> getRecommendItems(); //ユーザー画面
    
    //専用ブランド一覧の取得
    $records['brands'] = $classItems -> getExclusiveBrands(); //ユーザー画面

    //公開中イベント情報の取得 (1レコードのみ)
    $records['schedule'] = $classEvents -> getEventSchedulePart(); //ユーザー画面

    //オリジナルアイテム一覧の取得
    $records['originals'] = $classItems -> getOriginalItemsPart(); //ユーザー画面
    
    // var_dump($records);
    return View::render('index', ['records' => $records]);
}