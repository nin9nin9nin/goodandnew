<?php

require_once(MODEL_DIR . '/Tables/Favorites.php');

function execute_action() {
    Session::start();
    //認証済みか判定 ($_SESSION['_authenticated'](bool)を受け取る)
    if (Session::isAuthenticated() !== true) {
        //認証済みでなければサインアップにリダイレクト (ログイン画面に移行される)
        return View::redirectTo('users', 'signin');
        exit;
    }

    //認証済みであれば$_SESSION['user']を取得
    $user = Session::get('user');

    //postの確認
    if (!Request::isPost()) {
        return View::render404();
    }

    // CSRF対策(POST投稿を行うフォームに対して必ず行う)
    $token = Request::get('token');
    //ページIDの取得（なければ1が格納される）
    $page_id = Request::getPageId('page_id');
    //フォームの値を取得
    $item_id = Request::get('item_id');
    
    // postとsessionのトークンを照合（有効か確認）
    if (Session::isValidCsrfToken($token) !== true) {
        // 有効でなければリダイレクト
        Session::setFlash('不正な処理が行われました');

        return View::redirectTo('items', 'detail', ['item_id' => $item_id]);
        exit;
    }

    //フォームの値をチェック
    if (preg_match('/^\d+$/', $item_id) !== 1) {
        return View::render404();
    }

    //クラス生成（初期化）
    $classFavorites = new Favorites();
    
    //プロパティに値をセット
    $classFavorites -> user_id = $user -> user_id;
    $classFavorites -> item_id = $item_id;
    $classFavorites -> page_id = $page_id;
        
    //登録処理 -----------------------------------------------------
    
    $now_date = date('Y-m-d H:i:s');
    
    $classFavorites -> create_datetime = $now_date;
    
    //categorysテーブルに新規登録　executeBySql()
    $classFavorites -> insertFavorite();

    //フラッシュメッセージをセット
    Session::setFlash('お気に入りに登録しました');
    
    return View::redirectTo('items', 'detail', ['item_id' => $item_id]);
}
