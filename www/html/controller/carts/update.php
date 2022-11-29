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

    //postデータ取得---------------------------------
    if (!Request::isPost()) {
        return View::render404();
    }
    
    //フォームの値を取得
    $cart_id = Request::get('cart_id');
    $item_id = Request::get('item_id');
    $quantity = Request::get('quantity');//更新前の値
    
    //hiddenの値をチェック
    if (preg_match('/^\d+$/', $cart_id) !== 1 && preg_match('/^\d+$/', $item_id) !== 1) {
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
    $classStocks = new Stocks();
    
    Session::start();
    //認証済みであれば$_SESSION['user']を取得
    $user = Session::get('user');

    //プロパティに値をセット
    $classCarts -> user_id = $user -> user_id;
    $classCarts -> cart_id = $cart_id;
    $classCarts -> item_id = $item_id;
    $classStocks -> item_id = $item_id;
    $classCarts -> quantity = $quantity;
    $classStocks -> quantity = $quantity;

    //入力値チェック+在庫の確認
    try {
        //エラークラス初期化　$e = null
        CommonError::errorClear();
        
        //バリデーション（エラーがあればCommonErrorにメッセージを入れる）
        $classCarts -> checkQuantity();

        // 在庫の確認
        $classStocks -> checkUpdateItemStock();
        
        //エラーがあればthrow
        CommonError::errorThrow();
        
    } catch (Exception $e) {
        //エラーメッセージ取得
        $errors = CommonError::errorWhile();
        
        //カート一覧の取得
        $records['carts'] = $classCarts -> indexUserCartDetail();
        
        $records['total_quantity'] = Messages::getTotalQuantity($records['carts']);

        $records['total_amount'] = Messages::getTotalAmount($records['carts']);
        
        return View::render('index', ['records' => $records, 'errors' => $errors]);
        exit;
    }
    
    //更新処理------------------------------------------------------------------
    
    //更新の処理（トランザクション）
    $classCarts -> updateCart();

    //カートの合計数量を取得
    $cart_count = $classCarts -> getUserCartCount();
    
    //セッションに登録($_SESSION['cart_count'])
    Session::set('cart_count', $cart_count);

    //フラッシュメッセージをセット
    Session::setFlash('数量を変更しました');
        
    //カート詳細ページへリダイレクト
    return View::redirectTo('carts', 'index');
}