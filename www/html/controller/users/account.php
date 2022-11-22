<?php
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
    
    //クラス生成
    $classUsers = new Users();
    
    //プロパティに値を入れる
    $classUsers -> user_id = $user -> user_id;
    
    //指定userレコードを取得
    $record = $classUsers -> selectUserId();
    
    return View::render('account', ['record' => $record]);
}