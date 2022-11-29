<?php

require_once(MODEL_DIR . '/Tables/Favorites.php');

function execute_action() {
    if (!Request::isPost()) {
        return View::render404();
    }
    
    // postされたトークンの取得
    $token = Request::get('token');
    //フォームの値を取得
    $favorite_id = Request::get('favorite_id');
    
    
    Session::start();
    // postとsessionのトークンを照合（有効か確認）
    if (Session::isValidCsrfToken($token) !== true) {
        // 有効でなければリダイレクト
        Session::setFlash('不正な処理が行われました');

        return View::redirectTo('favorites', 'index');
        exit;
    }

    if (preg_match('/^\d+$/', $favorite_id) !== 1) {
        return View::render404();
    }
    
    //クラス生成（初期化）
    $classFavorites = new Favorites();
    
    //プロパティに値をセット
    $classFavorites -> favorite_id = $favorite_id;
        
    //指定レコードの削除
    $classFavorites -> deleteFavorite();
    
    //フラッシュメッセージをセット
    Session::setFlash('お気に入りから削除しました');    
    
    return View::redirectTo('favorites', 'index');
}
