<?php
require_once(MODEL_DIR . '/Tables/Carts.php');
require_once(MODEL_DIR . '/Tables/Stocks.php');
require_once(MODEL_DIR . '/Tables/Orders.php');
require_once(MODEL_DIR . '/Tables/Users.php');


function execute_action() {
    Session::start();
    //認証済みか判定 ($_SESSION['_authenticated'](bool)を受け取る)
    if (Session::isAuthenticated() !== true) {
        //認証済みでなければサインアップにリダイレクト (ログイン画面に移行される)
        return View::redirectTo('users', 'signin');
        exit;
    }

    //postデータ取得・在庫の確認---------------------------------
    if (!Request::isPost()) {
        return View::render404();
    }
    
    //フォームの値を取得
    $cart_id = Request::get('cart_id');
    $user_id = Request::get('user_id');

    //フォームの値をチェック
    if (preg_match('/^\d+$/', $cart_id) !== 1 && preg_match('/^\d+$/', $user_id) !== 1) {
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
    $classOrders = new Orders();
    $classUsers = new Users();
    
    //プロパティに値をセット
    $classCarts -> cart_id = $cart_id;
    $classCarts -> user_id = $user_id;
    $classOrders -> user_id = $user_id;
    $classUsers -> user_id = $user_id;

    //カート一覧の取得
    $records['carts'] = $classCarts -> indexUserCartDetail();

    //再度カートと在庫の確認


    //オーダー処理------------------------------------------------------------------
    //トランザクション開始  
    Database::beginTransaction();
    try {
        //在庫の変更(rollback)
        $classStocks -> orderStocks($records['carts']);

        //オーダーテーブルの作成(rollback)
        $classOrders -> insertOrder($records['carts']);

        //カートの削除(rollback)
        $classCarts -> deleteCart();
                    
        Database::commit();
        
    } catch (Exception $e) {

        $e = new Exception('購入できませんでした', 0, $e);
        //トランザクションでのエラーはcontrollerでキャッチしてもらう(error.tpl.phpへ)
        throw $e;
        
        Database::rollback();
    }

    //オーダー情報の取得(登録時のorder_idで取得)
    $records['orders'] = $classOrders -> indexUserOrderDetail();

    //合計数量の取得
    $records['total_quantity'] = Messages::getTotalQuantity($records['orders']);
    
    //合計金額の取得
    $records['total_amount'] = Messages::getTotalAmount($records['orders']);
    
    //セッションの削除（cart_count）
    Session::remove('cart_count');
        
    //ユーザー情報の取得(本来はcustomersテーブルから取得)
    $records['user'] = $classUsers -> getUserInfoFromId();

    //購入完了ページへ
    return View::render('complete', ['records' => $records]);
}