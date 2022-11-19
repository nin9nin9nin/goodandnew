<?php
require_once(MODEL_DIR . '/Tables/Carts.php');
require_once(MODEL_DIR . '/Tables/Stocks.php');

function execute_action() {
    $cart_id = Request::get('cart_id');
    $item_id = Request::get('item_id');
    $quantity = Request::get('quantity');

    if (preg_match('/^\d+$/', $item_id) !== 1) {
        return View::render404();
    }
    
    //クラス生成（初期化）
    $classCarts = new Carts();
    
    //プロパティに値をセット
    $classCarts -> cart_id = $cart_id;
    $classCarts -> item_id = $item_id;
    
    //データベース接続    
    Database::beginTransaction();
    try {
        $now_date = date('Y-m-d H:i:s');
        
        $classCarts -> update_datetime = $now_date;
        
        //cartsの更新(更新日時のみ)
        $classCarts -> updateUserCart();
        
        //cart_detailの削除
        $classCarts -> deleteUserCartDetail();
        
        //在庫に戻す
        Stocks::editItemStock_return($item_id, $quantity);
        
        Database::commit();
        
    } catch (Exception $e) {
        $e = new Exception('削除できませんでした', 0, $e);
        //トランザクションでのエラーはcontrollerでキャッチしてもらう(error.tpl.phpへ)
        throw $e;
        
        Database::rollback();
    }
    
    //セッション情報の更新(カートアイコンに表示)
    $classCarts -> setSessionCartCount();
        
    //カート詳細ページへリダイレクト
    return View::redirectTo('carts', 'index');
}