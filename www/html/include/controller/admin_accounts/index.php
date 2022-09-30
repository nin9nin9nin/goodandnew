<?php
//機能を継承し拡張したクラスの読み込み
require_once(MODEL_DIR . '/Tables/Admin.php');

function execute_action() {
    
    //認証済みか判定 ($_SESSION['_authenticated']を受け取る)
    $session = Session::getInstance() -> isAuthenticated();
    
    if ($session !== true) {
        //認証済みでなければサインアップにリダイレクト (ログイン画面に移行される)
        return View::redirectTo('admin_accounts', 'signin');
        exit;
        
    }
    
    //認証済みであれば$_SESSION['admin_id']を取得
    $admin_id = Session::get('admin_id', false);
    
    //クラス生成
    $classAdmin = new Admin();
    
    //プロパティに値を入れる
    $classAdmin -> admin_id = $admin_id;
    
    //adminレコードを取得(全データ)
    $record = $classAdmin -> selectAdminId();
    
    
    return View::render('index', ['record' => $record]);
}