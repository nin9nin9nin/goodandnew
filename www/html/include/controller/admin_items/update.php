<?php
require_once(MODEL_DIR . '/Tables/Items.php');
require_once(MODEL_DIR . '/Tables/Stocks.php');
require_once(MODEL_DIR . '/Tables/Categorys.php');
require_once(MODEL_DIR . '/Tables/Brands.php');
require_once(MODEL_DIR . '/Tables/Shops.php');

function execute_action() {
    if (!Request::isPost()) {
        return View::render404();
    }
    
    $id = Request::get('item_id');
    $name = Request::get('item_name');
    $category_id = Request::get('category_id');
    $brand_id = Request::get('brand_id');
    $shop_id = Request::get('shop_id');
    $price = Request::get('price');
    $stock = Request::get('stock');
    $description = Request::get('description');
    $status = Request::get('status');
    // $icon_img = '';
    // $icon_img = Request::get('icon_img');
    
    if (preg_match('/^\d+$/', $id) !== 1) {
        return View::render404();
    }
    
    //クラス生成（初期化）
    $classItems = new Items();
    $classStocks = new Stocks();
    
    //プロパティに値をセット
    $classItems -> item_id = $id;
    $classStocks -> item_id = $id;
    $classItems -> item_name = $name;
    $classItems -> category_id = $category_id;
    $classItems -> brand_id = $brand_id;
    $classItems -> shop_id = $shop_id;
    $classItems -> price = $price;
    $classItems -> description = $description;
    $classItems -> status = $status;
    $classStocks -> stock = $stock;
    
    //エラーチェック
    try {
        //エラークラス初期化　$e = null
        CommonError::errorClear();
        
        //バリデーション（エラーがあればCommonErrorにメッセージを入れる）
        $classItems -> checkItemName();
        $classItems -> checkPrice();
        $classStocks -> checkStock();
        //エラーがあればthrow
        CommonError::errorThrow();
        
    } catch (Exception $e) {
        //エラーメッセージ取得
        $errors = CommonError::errorWhile();
        
        //指定レコードの取得
        // $records[0] = $classItems -> editItem();
        //categorysテーブルの取得　select/option用
        // $records['categorys'] = Categorys::selectOption_Genre();
        //brandsテーブルの取得　select/option用
        // $records['brands'] = Brands::selectOption_Brands();
        //shopsテーブルの取得　select/option用
        // $records['shops'] = Shops::selectOption_Shops();
        
        // return View::render('edit', ['records' => $records, 'errors' => $errors]);
        return View::redirectTo('admin_items', 'edit', ['item_id' => $id, 'errors' => $errors]);
        exit;
    }
    
    //更新処理------------------------------------------------------------------
    
    //データベース接続    
    Database::beginTransaction();
    try {
        $now_date = date('Y-m-d H:i:s');
        
        //プロパティ登録日時
        $classItems -> update_datetime = $now_date;
        $classStocks -> update_datetime = $now_date;
        
        //指定レコードの編集（itemsテーブル）executeBySql()
        $classItems -> updateItem();
        
        //指定レコードの編集（stocksテーブル）
        $classStocks -> updateStock();
        
        Database::commit();
        
    } catch (Exception $e) {
        $e = new Exception('データベースに接続できませんでした', 0, $e);
        //トランザクションでのエラーはcontrollerでキャッチしてもらう(error.tpl.phpへ)
        throw $e;
        
        Database::rollback();
    }
    
    //指定レコードの取得
    $records[0] = $classItems -> editItem();
    
    //更新完了ページ
    return View::render('complete', ['records' => $records]);
    // return View::redirectTo('admin', 'items');
}
