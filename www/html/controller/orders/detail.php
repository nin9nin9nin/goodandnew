<?php
require_once(MODEL_DIR . '/Tables/Orders.php');

function execute_action() {
    Session::start();
    //認証済みか判定 ($_SESSION['_authenticated'](bool)を受け取る)
    if (Session::isAuthenticated() !== true) {
        //認証済みでなければサインアップにリダイレクト (ログイン画面に移行される)
        return View::redirectTo('users', 'signin');
        exit;
    }

    $order_id = Request::get('order_id');

    if (preg_match('/^\d+$/', $order_id) !== 1) {
        return View::render404();
    }
    
    //クラス生成（初期化）
    $classOrders = new Orders();
    
    //プロパティに値をセット
    $classOrders -> order_id = $order_id;
    
    //order_idから明細の取得
    $records['order'] = $classOrders -> indexUserOrderDetail();

    //合計数量の取得
    $records['total_quantity'] = Messages::getTotalQuantity($records['order']);

    //合計金額の取得
    $records['total_amount'] = Messages::getTotalAmount($records['order']);
        
    return View::render('detail', ['records' => $records]);
}