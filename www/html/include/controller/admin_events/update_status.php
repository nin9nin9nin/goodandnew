<?php

require_once(MODEL_DIR . '/Tables/Events.php');

function execute_action() {
    if (!Request::isPost()) {
        return View::render404();
    }
    
    // postされたトークンの取得
    $token = Request::get('token');
    
    Session::start();
    // postとsessionのトークンを照合（有効か確認）
    if (Session::isValidCsrfToken($token) !== true) {
        // 有効でなければリダイレクト
        Session::setFlash('不正な処理が行われました');

        return View::redirectTo('admin_events', 'index');
        exit;
    }

    $status = Request::getStatus('status');
    $id = Request::get('event_id');
    
    if (preg_match('/^\d+$/', $id) !== 1) {
        return View::render404();
    }
    
    //クラス生成（初期化）
    $classEvents = new Events();
    
    //プロパティに値をセット
    $classEvents -> event_id = $id;
    $classEvents -> status = $status;
    
    //更新処理 -----------------------------------------------------
    $now_date = date('Y-m-d H:i:s');
    
    $classEvents -> update_datetime = $now_date;
    
    //指定レコードのステータスを更新
    $classEvents -> updateEventStatus();
    
    //フラッシュメッセージをセット
    Session::setFlash('ID' . h($id) .'のステータスを更新しました');    
    
    return View::redirectTo('admin_events', 'index');
}
