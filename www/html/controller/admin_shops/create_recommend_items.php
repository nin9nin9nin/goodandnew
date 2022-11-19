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
    $event_id = Request::get('event_id');
    $item_ids = Request::get('item_id');
    
    //hidden
    if (preg_match('/^\d+$/', $event_id) !== 1) {
        return View::render404();
    }
    
    //クラス生成（初期化）
    $classShops = new Shops();
    
    //プロパティに値をセット
    $classShops -> event_id = $event_id;
    $classShops -> item_ids = $item_ids; //array()
    
    //エラーチェック
    try {
        //エラークラス初期化　$e = null
        CommonError::errorClear();
        
        //バリデーション（エラーがあればCommonErrorにメッセージを入れる）
        $classShops -> checkItemIds(); //array()
        
        //エラーがあればthrow
        CommonError::errorThrow();
        
    } catch (Exception $e) {

        //フラッシュメッセージをセット
        Session::setFlash('レコメンド登録に失敗しました');    
    
        return View::redirectTo('admin_shops', 'register_recommend_items', ['event_id' => $event_id]);
        exit;
    }
    
    //登録処理------------------------------------------------------------------
    $now_date = date('Y-m-d H:i:s');
    
    //プロパティ日時登録+生成したファイル名登録
    $classShops -> create_datetime = $now_date;

    //eventsテーブルに新規登録　executeBySql()
    $classShops -> insertRecommendItems();
        
    //フラッシュメッセージをセット
    Session::setFlash('レコメンドアイテムを登録しました');
    
    return View::redirectTo('admin_shops', 'recommend_items', ['event_id' => $event_id]);
}
