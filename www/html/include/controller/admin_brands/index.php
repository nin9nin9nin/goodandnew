<?php

require_once(MODEL_DIR . '/Tables/Brands.php');

function execute_action() {
    Session::start();
    //認証済みか判定 ($_SESSION['_authenticated'](bool)を受け取る)
    if (Session::isAuthenticated() !== true) {
        //認証済みでなければサインアップにリダイレクト (ログイン画面に移行される)
        return View::redirectTo('admin_accounts', 'signin');
        exit;
    }

    // CSRF対策(POST投稿を行うフォームに対して必ず行う)
    //トークンの作成
    Session::setCsrfToken();

    //ページIDの取得（なければ1が格納される）
    $page_id = Request::getPageId('page_id');

    //GETの値を確認
    if (preg_match('/^\d+$/', $page_id) !== 1) {
        return View::render404();
    }

    //クラス生成（初期化）
    $classBrands = new Brands();

    //プロパティに値をセット(ページネーション)
    $classBrands -> page_id = $page_id;
    
    //brandsテーブル取得
    $records['brands'] = $classBrands->indexBrands();
        
    //ページネーションに必要な値一式
    $paginations = $classBrands -> getPaginations();

    return View::render('index', ['records' => $records, 'paginations' => $paginations]);
}