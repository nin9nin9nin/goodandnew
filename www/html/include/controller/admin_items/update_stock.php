<?php
require_once(MODEL_DIR . '/Tables/Items.php');
require_once(MODEL_DIR . '/Tables/Stocks.php');

function execute_action() {
    if (!Request::isPost()) {
        return View::render404();
    }
    
    $id = Request::get('item_id');
    $stock = Request::get('stock');
        
    if (preg_match('/^\d+$/', $id) !== 1) {
        return View::render404();
    }
    
    //クラス生成（初期化）
    $classStocks = new Stocks();
    
    //プロパティに値をセット
    $classStocks -> item_id = $id;
    $classStocks -> stock = $stock;
    
    //エラーチェック
    try {
        //エラークラス初期化　$e = null
        CommonError::errorClear();
        
        //バリデーション（エラーがあればCommonErrorにメッセージを入れる）
        $classStocks -> checkStock();
        
        //エラーがあればthrow
        CommonError::errorThrow();
        
    } catch (Exception $e) {
        //エラーメッセージ取得
        $errors = CommonError::errorWhile();
        
        //クラス生成（初期化）
        $classItems = new Items();
        
        //items,stocks 結合テーブルの取得
        $records['items'] = $classItems -> indexItems();
        
        return View::render('stock_edit', ['records' => $records, 'errors' => $errors]);
        exit;
    }
    
    //更新処理------------------------------------------------------------------
    $now_date = date('Y-m-d H:i:s');
    
    $classStocks -> update_datetime = $now_date;
    
    //指定レコードの在庫編集（stocksテーブル）
    $classStocks -> updateStock();
    
    //再度在庫一覧画面へ
    return View::redirectTo('admin_items', 'stock_edit');
        
}
