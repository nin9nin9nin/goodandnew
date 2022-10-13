<?php
//機能を継承し拡張したクラスの読み込み
require_once(MODEL_DIR . '/Tables/Users.php');

function execute_action() {
    //認証済みか判定 ($_SESSION['_authenticated']を受け取る)
    $session = Session::getInstance() -> isAuthenticated();

    if ($session !== true) {
        //認証済みでなければサインアップにリダイレクト
        return View::redirectTo('admin_accounts', 'signin');
        exit;
    }
    
    //クラス生成（初期化）
    $classUsers = new Users();
    
    //brandsテーブル取得
    $records['users'] = $classUsers->indexUsers();
    
    return View::render('index', ['records' => $records]);
}
