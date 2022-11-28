<?php
require_once(MODEL_DIR . '/Tables/Carts.php');
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

    //postデータ取得・在庫の確認---------------------------------
    if (!Request::isPost()) {
        return View::render404();
    }
    
    //フォームの値を取得
    $cart_id = Request::get('cart_id');

    //フォームの値をチェック
    if (preg_match('/^\d+$/', $cart_id) !== 1) {
        return View::render404();
    }

    // CSRF対策(POST投稿を行うフォームに対して必ず行う)
    $token = Request::get('token');
    
    // postとsessionのトークンを照合（有効か確認）
    if (Session::isValidCsrfToken($token) !== true) {
        // 有効でなければリダイレクト
        Session::setFlash('不正な処理が行われました');

        return View::redirectTo('carts', 'index');
        exit;
    }
    
    //クラス生成（初期化）
    $classCarts = new Carts();
    $classUsers = new Users();
    
    //プロパティに値をセット
    $classCarts -> cart_id = $cart_id;
    $classCarts -> user_id = $user -> user_id;
    $classUsers -> user_id = $user -> user_id;

    //カート一覧の取得
    $records['carts'] = $classCarts -> indexUserCartDetail();

    //合計数量の取得
    $records['total_quantity'] = Messages::getTotalQuantity($records['carts']);

    //合計金額の取得
    $records['total_amount'] = Messages::getTotalAmount($records['carts']);

    //カートのエラーチェック
    try {
        //エラークラス初期化　$e = null
        CommonError::errorClear();
        
        //バリデーション（エラーがあればCommonErrorにメッセージを入れる）
        $classCarts -> checkCarts($records['carts']);
        
        //エラーがあればthrow
        CommonError::errorThrow();
        
    } catch (Exception $e) {
        //エラーメッセージ取得
        $errors = CommonError::errorWhile();
        
        //cartsページでエラー表示
        return View::render('index', ['records' => $records, 'errors' => $errors]);
        exit;
    }

    //ユーザー情報の取得(本来はcustomersテーブルから取得)
    $records['user'] = $classUsers -> getUserInfoFromId();

    //オーダー確認画面へ進む    
    return View::render('confirm', ['records' => $records]);
}