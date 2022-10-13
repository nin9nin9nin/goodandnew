<?php
require_once(MODEL_DIR . '/Tables/Carts.php');
require_once(MODEL_DIR . '/Tables/Stocks.php');
require_once(MODEL_DIR . '/Tables/Users.php');


function execute_action() {
    $cart_id = Request::get('cart_id');
    $user_id = Request::get('user_id');

    if (preg_match('/^\d+$/', $cart_id) !== 1) {
        return View::render404();
    }
    
    //クラス生成（初期化）
    $classCarts = new Carts();
    $classUsers = new Users();
    
    //プロパティに値をセット
    $classCarts -> cart_id = $cart_id;
    $classUsers -> user_id = $user_id;
    
    $now_date = date('Y-m-d H:i:s');
        
    $classCarts -> update_datetime = $now_date;
    
    //カートの削除（無効化）
    $classCarts -> deleteUserCart();
    
    //購入情報の取得(本来はordersテーブルから取得)
    $records['purchased'] = $classCarts -> purchasedUserOrder();
    
    //数量の計算・取得
    $records['total_quantity'] = $classCarts->getTotalQuantity($records['purchased']);
    
    //小計の計算・取得
    $records['total_amount'] = $classCarts->getTotalAmount($records['purchased']);
    
    //ユーザー情報の取得(本来はcustomersテーブルから取得)
    $records['user'] = $classUsers -> selectUserId();
    
    //セッションの値を削除(unset)
    $classCarts -> clearSessionCartCount();
        
    //購入完了ページへ
    return View::render('order_complete', ['records' => $records]);
    
    
    // return View::redirectTo('orders', 'order_complete');
    
}