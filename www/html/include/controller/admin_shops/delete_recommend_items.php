<?php

require_once(MODEL_DIR . '/Tables/Shops.php');

function execute_action() {
    if (!Request::isPost()) {
        return View::render404();
    }

    // CSRF対策(POST投稿を行うフォームに対して必ず行う)
    $token = Request::get('token');

    Session::start();
    // postとsessionのトークンを照合（有効か確認）
    if (Session::isValidCsrfToken($token) !== true) {
        // 有効でなければリダイレクト
        Session::setFlash('不正な処理が行われました');

        return View::redirectTo('admin_shops', 'index');
        exit;
    }
    
    // フォームの値を取得
    $recommend_id = Request::get('recommend_id');
    $event_id = Request::get('event_id');
    
    //hidden
    if (preg_match('/^\d+$/', $recommend_id) !== 1 && preg_match('/^\d+$/', $event_id) !== 1) {
        return View::render404();
    }
    
    //クラス生成（初期化）
    $classShops = new Shops();
    
    //プロパティに値をセット($event_idを除く)
    $classShops -> recommend_id = $recommend_id;

    //指定レコードの削除　executeBySql()
    $classShops -> deleteRecommendItem();
        
    //フラッシュメッセージをセット
    Session::setFlash('レコメンドアイテムを削除しました');
    
    return View::redirectTo('admin_shops', 'recommend_items', ['event_id' => $event_id]);
}