<?php
require_once(MODEL_DIR . '/Tables/Carts.php');
require_once(MODEL_DIR . '/Tables/Stocks.php');

function execute_action() {
    //認証済みか判定 ($_SESSION['_authenticated']を受け取る)
    $session = Session::getInstance() -> isAuthenticated();
    
    if ($session !== true) {
        //認証済みでなければサインアップにリダイレクト (ログイン画面に移行される)
        return View::redirectTo('users', 'signin');
        exit;
    }
    
    //認証済みであれば$_SESSION['user']を取得
    $session = Session::get('user');
    
    //クラス生成（初期化）
    $classCarts = new Carts();
    
    //プロパティに値をセット(セッションからuser_id取得)
    $classCarts -> user_id = $session->user_id;
    
    //user_idでカートの確認(あればオブジェクト、なければfalse)
    //(カート情報の用意)
    $cart = $classCarts->checkUserCart();
    
    //カートが存在すれば情報取得
    if ($cart !== false) {
        //カートIDを取得
        $classCarts -> cart_id = $cart->cart_id;
        
        //カート情報の取得(商品詳細含む)
        $records['cart_items'] = $classCarts -> getUserCartItems();
        
        //数量の計算・取得
        $records['total_quantity'] = $classCarts->getTotalQuantity($records['cart_items']);
        
        //小計の計算・取得
        $records['total_amount'] = $classCarts->getTotalAmount($records['cart_items']);
        
    } else {
        //数量表示を変更
        $records['total_quantity'] =  0;
        //小計表示を変更
        $records['total_amount'] =  '-';
    }
    
    
    //顧客情報取得
    // $records['customers'] = getCustomerInfo();
    
    return View::render('index', ['records' => $records]);
}