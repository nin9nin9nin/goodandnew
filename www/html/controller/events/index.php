<?php

require_once(MODEL_DIR . '/Tables/Events.php');
require_once(MODEL_DIR . '/Tables/Items.php');

function execute_action() {
    //イベントIDの取得
    $id = Request::getEventId('event_id');
    //ページIDの取得（なければ1が格納される）
    $page_id = Request::getPageId('page_id');


    if (preg_match('/^\d+$/', $id) !== 1 && preg_match('/^\d+$/', $page_id) !== 1) {
        return View::render404();
    }

    Session::start();
    //トークンの作成
    Session::setCsrfToken();

    //クラス生成（初期化）
    $classEvents = new Events();
    $classItems = new Items();
    
    //プロパティに値をセット
    $classEvents -> event_id = $id;
    $classItems -> event_id = $id;

    $classItems -> page_id = $page_id;

    //指定IDのイベント情報の取得 (1レコードのみ retrieveBySql())
    $records['event'] = $classEvents -> getEventDetail(); 
    
    //専用アイテム一覧取得
    $records['items'] = $classItems -> getExclusiveItems();
    
    //専用ブランド一覧の取得
    $records['brands'] = $classItems -> getExclusiveBrands();

    //専用ブランド一覧の取得
    $records['categorys'] = $classItems -> getExclusiveCategorys();

    //オリジナルアイテム一覧の取得
    $records['originals'] = $classItems -> getOriginalItemsPart();
 
    // var_dump($records);
    return View::render('index', ['records' => $records]);
}