<?php
require_once(MODEL_DIR . '/Tables/Orders.php');
require_once(MODEL_DIR . '/Tables/Users.php');


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
    
    //クラス生成（初期化）
    $classOrders = new Orders();
    $classUsers = new Users();
    
    //プロパティに値をセット(セッションからuser_id取得)
    $classOrders -> user_id = $user -> user_id;
    $classUsers -> user_id = $user -> user_id;
    
    //user_idからオーダー履歴一覧の取得
    $records['historys'] = $classOrders -> indexUserOrders();
        
    //ユーザー情報の取得(本来はcustomersテーブルから取得)
    $records['user'] = $classUsers -> getUserInfoFromId();
        
    return View::render('history', ['records' => $records]);
}