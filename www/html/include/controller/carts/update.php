<?php
require_once(MODEL_DIR . '/Tables/Carts.php');
require_once(MODEL_DIR . '/Tables/Stocks.php');

function execute_action() {
    if (!Request::isPost()) {
        return View::render404();
    }
    
    $cart_id = Request::get('cart_id');
    $item_id = Request::get('item_id');
    $new_quantity = Request::get('new_quantity');//更新後の値
    $quantity = Request::get('quantity');//更新前の値
    $subtraction = $new_quantity - $quantity;//差し引きした値(stockの更新時に使用)

    if (preg_match('/^\d+$/', $item_id) !== 1) {
        return View::render404();
    }
    
    //クラス生成（初期化）
    $classCarts = new Carts();
    
    //プロパティに値をセット
    $classCarts -> cart_id = $cart_id;
    $classCarts -> item_id = $item_id;
    $classCarts -> quantity = $new_quantity;
    
    //エラーチェック
    try {
        //エラークラス初期化　$e = null
        CommonError::errorClear();
        
        //バリデーション（エラーがあればCommonErrorにメッセージを入れる）
        $classCarts -> checkQuantity();
        
        //在庫の確認（在庫数を超えた場合エラー）
        Stocks::checkItemStock_update($item_id, $subtraction);
        
        //エラーがあればthrow
        CommonError::errorThrow();
        
    } catch (Exception $e) {
        //エラーメッセージ取得
        $errors = CommonError::errorWhile();
        
        //カート情報の取得(商品詳細含む)
        $records['cart_items'] = $classCarts -> getUserCartItems();
        //数量の計算・取得
        $records['total_quantity'] = $classCarts->getTotalQuantity($records['cart_items']);
        //小計の計算・取得
        $records['total_amount'] = $classCarts->getTotalAmount($records['cart_items']);
        
        return View::render('index', ['records' => $records, 'errors' => $errors]);
    }
    
    //更新処理------------------------------------------------------------------
    
    //データベース接続    
    Database::beginTransaction();
    try {
        $now_date = date('Y-m-d H:i:s');
        
        $classCarts -> update_datetime = $now_date;
        
        //cartsの更新(更新日時のみ)
        $classCarts -> updateUserCart();
        
        //cart_detailの更新 ($new_quantity)
        $classCarts -> updateUserCartDetail();
        
        //在庫の更新($subtraction)
        Stocks::editItemStock_update($item_id, $subtraction);
        
        Database::commit();
        
    } catch (Exception $e) {
        $e = new Exception('変更できませんでした', 0, $e);
        //トランザクションでのエラーはcontrollerでキャッチしてもらう(error.tpl.phpへ)
        throw $e;
        
        Database::rollback();
    }
    
    //セッション情報の更新(カートアイコンに表示)
    $classCarts -> setSessionCartCount();
        
    //カート詳細ページへリダイレクト
    return View::redirectTo('carts', 'index');
    
}