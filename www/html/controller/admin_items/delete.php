<?php

require_once(MODEL_DIR . '/Tables/Items.php');

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

        return View::redirectTo('admin_items', 'index');
        exit;
    }

    $id = Request::get('item_id');
    
    if (preg_match('/^\d+$/', $id) !== 1) {
        return View::render404();
    }
    
    //クラス生成（初期化）
    $classItems = new Items();
    
    //プロパティに値をセット
    $classItems -> item_id = $id;
        
    //指定レコードの削除
    $classItems -> deleteItem();
    
    //フラッシュメッセージをセット
    Session::setFlash('アイテムを削除しました');    
    
    return View::redirectTo('admin_items', 'index');
}
