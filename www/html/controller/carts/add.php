<?php
require_once(MODEL_DIR . '/Tables/Carts.php');
require_once(MODEL_DIR . '/Tables/Stocks.php');

//cart_addの場合は数量が1づつしか加算されない前提+在庫が0の場合は売り切れ表示で追加できない

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
    
    //postデータ取得---------------------------------
    if (!Request::isPost()) {
        return View::render404();
    }
    
    //hiddenの値を取得
    $item_id = Request::get('item_id');

    //hiddenの値をチェック
    if (preg_match('/^\d+$/', $item_id) !== 1) {
        return View::render404();
    }
    
    // CSRF対策(POST投稿を行うフォームに対して必ず行う)
    $token = Request::get('token');
    
    // postとsessionのトークンを照合（有効か確認）
    if (Session::isValidCsrfToken($token) !== true) {
        // 有効でなければリダイレクト
        Session::setFlash('不正な処理が行われました');

        return View::redirectTo('items', 'detail', ['item_id' => $item_id]);
        exit;
    }

    //クラス生成（初期化）
    $classCarts = new Carts();
    $classStocks = new Stocks();
    
    //プロパティに値をセット
    $classCarts -> user_id = $user -> user_id;
    $classCarts -> item_id = $item_id;
    $classStocks -> item_id = $item_id;
    $classCarts -> quantity = 1; //ADD TO CART
    $classStocks -> quantity = 1; //ADD TO CART
    
    // 在庫の確認
    if ($classStocks -> checkAddItemStock() === false) {
        // 1以上でなければfalseとなる
        Session::setFlash('売り切れ中です。カートに追加出来ませんでした。');

        return View::redirectTo('items', 'detail', ['item_id' => $item_id]);
        exit;
    } 
    
    //登録処理------------------------------------------------------------------
    
    //登録または更新の処理（トランザクション）
    $classCarts -> addToCart();
    
    //カートの合計数量を取得
    $cart_count = $classCarts -> getUserCartCount();

    //セッションに登録($_SESSION['cart_count'])
    Session::set('cart_count', $cart_count);

    //フラッシュメッセージをセット
    Session::setFlash('カートに追加しました');

    //再度商品ページへリダイレクト
    return View::redirectTo('items', 'detail', ['item_id' => $item_id]);
}