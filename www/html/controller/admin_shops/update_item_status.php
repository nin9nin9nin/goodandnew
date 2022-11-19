<?php

require_once(MODEL_DIR . '/Tables/Items.php');

function execute_action() {
    if (!Request::isPost()) {
        return View::render404();
    }
    
    $status = Request::getStatus('status');
    $id = Request::get('item_id');
    $event_id = Request::get('event_id');
    
    if (preg_match('/^\d+$/', $id) !== 1) {
        return View::render404();
    }
    
    // postされたトークンの取得
    $token = Request::get('token');
    
    Session::start();
    // postとsessionのトークンを照合（有効か確認）
    if (Session::isValidCsrfToken($token) !== true) {
        // 有効でなければリダイレクト
        Session::setFlash('不正な処理が行われました');

        return View::redirectTo('admin_shops', 'exclusive', ['event_id' => $event_id]);
        exit;
    }

    //クラス生成（初期化）
    $classItems = new Items();
    
    //プロパティに値をセット
    $classItems -> item_id = $id;
    $classItems -> status = $status;
    
    //更新処理 -----------------------------------------------------
    $now_date = date('Y-m-d H:i:s');
    
    $classItems -> update_datetime = $now_date;
    
    //指定レコードのステータスを更新
    $classItems -> updateItemStatus();
    
    //フラッシュメッセージをセット
    Session::setFlash('アイテムID' . h($id) .':ステータスを変更しました');    
    
    return View::redirectTo('admin_shops', 'exclusive', ['event_id' => $event_id]);
}
