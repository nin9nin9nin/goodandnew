<?php
require_once(MODEL_DIR . '/Tables/Carts.php');
require_once(MODEL_DIR . '/Tables/Stocks.php');

//cart_addの場合は数量が1づつしか加算されない前提+在庫が0の場合は売り切れ表示で追加できない

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
    
    //$_SESSION['user']からuser_id取得
    $user_id = $session->user_id;
    
    //postデータ取得・在庫の確認---------------------------------
    if (!Request::isPost()) {
        return View::render404();
    }
    
    $id = Request::get('item_id');
    
    if (preg_match('/^\d+$/', $id) !== 1) {
        return View::render404();
    }
    
    //クラス生成（初期化）
    $classCarts = new Carts();
    
    //プロパティに値をセット
    $classCarts -> user_id = $user_id;
    $classCarts -> item_id = $id;
    $classCarts -> quantity = 1;
    
    //在庫０の場合非表示となっているので在庫チェックはなし
    
    //データベース接続    
    Database::beginTransaction();
    try {
        //先にカートの在庫を確保(確保できなかった場合エラーを投げる)
        Stocks::editItemStock_add($id);
        
        //カートに登録------------------------------------
        $now_date = date('Y-m-d H:i:s');
        
        $classCarts -> create_datetime = $now_date;
        $classCarts -> update_datetime = $now_date;
        
        //user_idでカートの確認(あればオブジェクト、なければfalse)
        $cart = $classCarts -> checkUserCart();
        
        //カートがなければ新規作成 -------------------------------------------carts----
        if ($cart === false) { 
            //プロパティに値を追加
            $classCarts -> cart_date = $now_date;
            
            //新規カートの作成(cartsテーブル,cart_detailテーブル)
            $classCarts -> setUserCart();
            
        //カートがあれば更新    
        } else {
            //カートIDを取得
            $classCarts -> cart_id = $cart->cart_id;
            
            //カートの更新
            $classCarts -> updateUserCart();
            
            //cart_idから同一アイテムの確認(あればオブジェクト、なければfalse)
            $item = $classCarts -> checkUserCartItem();
            
            //アイテムがなければ新規で追加 --------------------------------------cart_detail---
            if ($item === false) {
                //
                $classCarts -> insertUserCartDetail();;
                
                //アイテムがあれば更新
            } else {
                //
                $classCarts -> addUserCartDetail();
            }
        }
        
        Database::commit();
        
    } catch (Exception $e) {
        $e = new Exception('カートに追加できませんでした', 0, $e);
        //トランザクションでのエラーはcontrollerでキャッチしてもらう(error.tpl.phpへ)
        throw $e;
        
        Database::rollback();
    }
    
    //カートに登録できたらセッションに数量を追加(カートアイコンに表示)
    $classCarts -> setSessionCartCount();
        
    //再度商品ページへリダイレクト
    return View::redirectTo('items', 'detail', ['item_id' => $id]);
}