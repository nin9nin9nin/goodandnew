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

    $name = Request::get('item_name');
    $category_id = Request::get('category_id');
    $brand_id = Request::get('brand_id');
    $shop_id = Request::get('shop_id');
    $price = Request::get('price');
    $stock = Request::get('stock');
    $description = Request::get('description');
    $status = Request::get('status');
    $icon_img = '';
    
    //クラス生成（初期化）
    $classItems = new Items();
    $classStocks = new Stocks();
    
    //プロパティに値をセット
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
        $classItems -> checkIconImg();
        $classItems -> checkImg();
        
        // //画像の取得とファイル名の作成
        // if (is_uploaded_file($_FILES['icon_img']['tmp_name']) === TRUE) {
        //     $extension = pathinfo($_FILES['icon_img']['name'], PATHINFO_EXTENSION);
        //     $extension = strtolower($extension); // あいうえお.JPG => JPG => jpg
        //     if ($extension === 'jpeg' || $extension === 'jpg' || $extension === 'png') {
        //         $icon_img = sha1(uniqid(mt_rand(), true)). '.' . $extension;
        //         if (is_file(IMG_DIR . $icon_img) !== TRUE) {
        //             //プロパティに登録
        //             $classItems -> icon_img = $icon_img;
        //         } else {
        //             CommonError::errorAdd('ファイルアップロードに失敗しました。再度お試しください');
        //         }
        //     } else {
        //         CommonError::errorAdd('ファイル形式が異なります。画像ファイルはJPEGとPNGが利用可能です');
        //     }
        // } else {
        //     CommonError::errorAdd('ファイルを選択してください');
        // }
        
        //エラーがあればthrow
        CommonError::errorThrow();
        
    } catch (Exception $e) {
        //エラーメッセージ取得
        $errors = CommonError::errorWhile();
            
        //items,stocks 結合テーブルの取得
        $records['items'] = $classItems -> indexItems();
        //categorysテーブルの取得　select/option用
        $records['categorys'] = Categorys::selectOption_Genre();
        //brandsテーブルの取得　select/option用
        $records['brands'] = Brands::selectOption_Brands();
        //shopsテーブルの取得　select/option用
        $records['shops'] = Shops::selectOption_Shops();
        
        
        return View::render('index', ['records' => $records, 'errors' => $errors]);
        exit;
    }
    
    //登録処理------------------------------------------------------------------
    
    //データベース接続
    Database::beginTransaction();
    try {
        $now_date = date('Y-m-d H:i:s');
        
        //プロパティ登録日時
        $classItems -> create_datetime = $now_date;
        $classStocks -> create_datetime = $now_date;
        
        //itemsテーブルに新規登録　executeBySql()
        $classItems -> insertItem();
        
        //item_idの取得
        $item_id = Database::lastInsertId();
        
        //プロパティ　stocksテーブルにitem_idをセット
        $classStocks -> item_id = $item_id;
        
        //stocksテーブルに新規登録　executeBySql()
        $classStocks -> insertStock();
        
        //画像のファイルアップロード（できなければrollback）
        $classItems -> uploadIconImg();
        $classItems -> uploadImg();

        // if (move_uploaded_file($_FILES['icon_img']['tmp_name'], IMG_DIR . $icon_img) !== TRUE) {
        //     $e = new Exception('ファイルアップロードに失敗しました', 0, $e);
        //     throw $e;
            
        //     Database::rollback();
        // } else {
        //     Database::commit();
        // }
        Database::commit();
      
    } catch (Exception $e) {
        $e = new Exception('データベースに接続できませんでした', 0, $e);
        //トランザクションでのエラーはcontrollerでキャッチしてもらう(error.tpl.phpへ)
        throw $e;
        
        Database::rollback();
    }
    
    Session::start();
    //フラッシュメッセージをセット
    Session::setFlash('商品を登録しました');
    
    return View::redirectTo('admin_items', 'index');
}
