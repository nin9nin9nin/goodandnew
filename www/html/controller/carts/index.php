<?php
require_once(MODEL_DIR . '/Tables/Carts.php');
require_once(MODEL_DIR . '/Tables/Stocks.php');

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
    $classCarts = new Carts();
    
    //プロパティに値をセット(セッションからuser_id取得)
    $classCarts -> user_id = $user -> user_id;
    
    //カート一覧の取得
    $records['carts'] = $classCarts -> indexUserCartDetail();
    
    //合計数量の取得
    $records['total_quantity'] = Messages::getTotalQuantity($records['carts']);

    //合計金額の取得
    $records['total_amount'] = Messages::getTotalAmount($records['carts']);
        
    return View::render('index', ['records' => $records]);
}