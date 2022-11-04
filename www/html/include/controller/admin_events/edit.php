<?php
require_once(MODEL_DIR . '/Tables/Events.php');

function execute_action() {
    // idの取得
    $id = Request::get('event_id');

    if (preg_match('/^\d+$/', $id) !== 1) {
        return View::render404();
    }

    Session::start();
    //トークンの作成
    Session::setCsrfToken();
    
    //クラス生成（初期化）
    $classEvents = new Events();
    
    //プロパティに値をセット
    $classEvents -> event_id = $id;
    
    //指定レコードの取得
    $record = $classEvents -> editEvent();    
    
    return View::render('edit', ['record' => $record]);
}