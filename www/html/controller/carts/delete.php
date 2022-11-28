<?php
require_once(MODEL_DIR . '/Tables/Carts.php');

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

    //postの値を取得
    $cart_id = Request::get('cart_id');
    $item_id = Request::get('item_id');
    
    //hiddenの値の確認
    if (preg_match('/^\d+$/', $cart_id) !== 1 && preg_match('/^\d+$/', $item_id) !== 1) {
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
    
    //プロパティに値をセット
    $classCarts -> cart_id = $cart_id;
    $classCarts -> item_id = $item_id;
    
    //指定item_idをcart_detailから削除
    $classCarts -> deleteUserCartDetail();
    
    //カートの合計数量を取得
    $cart_count = $classCarts -> getUserCartCount();

    //セッションに登録($_SESSION['cart_count'])
    Session::set('cart_count', $cart_count);

    //フラッシュメッセージをセット
    Session::setFlash('アイテムを削除しました');
        
    //カート詳細ページへリダイレクト
    return View::redirectTo('carts', 'index');
}