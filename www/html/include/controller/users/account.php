<?php
require_once(MODEL_DIR . '/Tables/Users.php');

function execute_action() {
    
    //認証済みか判定 ($_SESSION['_authenticated']を受け取る)
    $session = Session::getInstance() -> isAuthenticated();
    
    if ($session !== true) {
        //認証済みでなければサインアップにリダイレクト (ログイン画面に移行される)
        return View::redirectTo('users', 'signin');
        exit;
        
    }
        
    //認証済みであれば$_SESSION['admin']を取得
    $user = Session::get('user', false);
    
    //クラス生成
    $classUsers = new Users();
    
    //プロパティに値を入れる
    $classUsers -> user_id = $user->user_id;
    
    //指定userレコードを取得
    $record = $classUsers -> selectUserId();
    
    
    return View::render('account', ['record' => $record]);
}