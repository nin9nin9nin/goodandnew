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

    //ページIDの取得（なければ1が格納される）
    $page_id = Request::getPageId('page_id');
    
    //GETの値を確認
    if (preg_match('/^\d+$/', $page_id) !== 1) {
        return View::render404();
    }
    
    // CSRF対策(POST投稿を行うフォームに対して必ず行う)
    //トークンの作成
    Session::setCsrfToken();

    //クラスの生成（初期化）
    $classFavorites = new Favorites();

    //プロパティに値をセット(ページネーション)
    $classFavorites -> user_id = $user -> user_id;
    $classFavorites -> page_id = $page_id;

    //favoritesの取得　（page_idから指定した分だけ/10アイテムのみ）
    $records['favorites'] = $classFavorites -> indexFavorites();
    
    //ページネーションに必要な値一式
    $paginations = $classFavorites -> getPaginations();
    
    return View::render('index', ['records' => $records, 'paginations' => $paginations]);
}
