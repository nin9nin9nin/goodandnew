<?php
require_once(MODEL_DIR . '/Tables/Carts.php');
require_once(MODEL_DIR . '/Tables/Stocks.php');
require_once(MODEL_DIR . '/Tables/Users.php');


function execute_action() {
    //認証済みであれば$_SESSION['user']を取得
    $session = Session::get('user');
    
    //クラス生成（初期化）
    $classCarts = new Carts();
    $classUsers = new Users();
    
    //プロパティに値をセット(セッションからuser_id取得)
    $classCarts -> user_id = $session->user_id;
    $classUsers -> user_id = $session->user_id;
    
    
    //購入情報の取得(本来はordersテーブルから取得)
    $records['history'] = $classCarts -> historyUserOrder();
    
    //数量の計算・取得
    $records['total_quantity'] = $classCarts->getTotalQuantity($records['history']);
    
    //小計の計算・取得
    $records['total_amount'] = $classCarts->getTotalAmount($records['history']);
    
    //ユーザー情報の取得(本来はcustomersテーブルから取得)
    $records['user'] = $classUsers -> selectUserId();
    
    //セッションの値を削除(unset)
    $classCarts -> clearSessionCartCount();
        
    //購入完了ページへ
    return View::render('order_complete', ['records' => $records]);
    
    
    // return View::redirectTo('orders', 'order_complete');
    
}