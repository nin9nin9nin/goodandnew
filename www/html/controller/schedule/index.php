<?php

require_once(MODEL_DIR . '/Tables/Events.php');

function execute_action() {
    //イベントIDの取得
    $id = Request::getEventId('event_id');
    //ページIDの取得（なければ1が格納される）
    $page_id = Request::getPageId('page_id');


    if (preg_match('/^\d+$/', $id) !== 1 && preg_match('/^\d+$/', $page_id) !== 1) {
        return View::render404();
    }

    //クラス生成（初期化）
    $classEvents = new Events();
    
    //プロパティに値をセット
    $classEvents -> event_id = $id;
    $classEvents -> page_id = $page_id;

    //指定IDのイベント情報の取得 (1レコードのみ retrieveBySql())
    $records['schedule'] = $classEvents -> getEventSchedule(); 

    //ページネーションに必要な値一式
    $paginations = $classEvents -> getPaginations();
    
 
    return View::render('index', ['records' => $records, 'paginations' => $paginations]);
}