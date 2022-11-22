<?php

require_once(MODEL_DIR . '/Tables/Events.php');
require_once(MODEL_DIR . '/Tables/Items.php');

function execute_action() {
    //イベントIDの取得
    $id = Request::getEventId('event_id');

    if (preg_match('/^\d+$/', $id) !== 1) {
        return View::render404();
    }

    //クラス生成（初期化）
    $classEvents = new Events();
    $classItems = new Items();
    
    //プロパティに値をセット
    $classEvents -> event_id = $id;
    $classItems -> event_id = $id;

    //指定IDのイベント情報の取得 (1レコードのみ retrieveBySql())
    $records['event'] = $classEvents -> getEventDetail(); 
    
    //専用アイテム一覧取得
    $records['items'] = $classItems -> getExclusiveItems();
    
    //専用ブランド一覧の取得
    $records['brands'] = $classItems -> getExclusiveBrands();

    //専用カテゴリー一覧の取得
    $records['categorys'] = $classItems -> getExclusiveCategorys();

    //オリジナルアイテム(一部)の取得
    $records['originals'] = $classItems -> getOriginalItemsPart();
 
    return View::render('index', ['records' => $records]);
}