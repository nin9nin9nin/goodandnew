<?php
require_once(MODEL_DIR . '/Tables/Items.php');
require_once(MODEL_DIR . '/Tables/Stocks.php');
require_once(MODEL_DIR . '/Tables/Categorys.php'); //selectOption呼び出し
require_once(MODEL_DIR . '/Tables/Brands.php'); //selectOption呼び出し
require_once(MODEL_DIR . '/Tables/Events.php'); //selectOption呼び出し

function execute_action() {
    if (!Request::isPost()) {
        return View::render404();
    }
    
    // postされたトークンの取得
    $token = Request::get('token');
    
    Session::start();
    // postとsessionのトークンを照合（有効か確認）
    if (Session::isValidCsrfToken($token) !== true) {
        // 有効でなければリダイレクト
        Session::setFlash('不正な処理が行われました');

        return View::redirectTo('admin_items', 'index');
        exit;
    }
    
    //hidden
    $id = Request::get('item_id');

    if (preg_match('/^\d+$/', $id) !== 1) {
        return View::render404();
    }

    //フォームの値を取得
    $name = Request::get('item_name');
    $category_id = Request::get('category_id');
    $brand_id = Request::get('brand_id');
    $event_id = Request::get('event_id');
    $price = Request::get('price');
    $stock = Request::get('stock');
    $description = Request::get('description');
    $icon_img = Request::getFiles('icon_img'); //初期値NULL
    $exists_icon = Request::get('exists_icon'); // $_POST['exists_icon']既存のファイル名
    $status = Request::getStatus('status'); //初期値設定0
    
    //クラス生成（初期化）
    $classItems = new Items();
    $classStocks = new Stocks();
    
    //プロパティに値をセット
    $classItems -> item_id = $id;
    $classStocks -> item_id = $id;
    $classItems -> item_name = $name;
    $classItems -> category_id = $category_id;
    $classItems -> brand_id = $brand_id;
    $classItems -> event_id = $event_id;
    $classItems -> price = $price;
    $classStocks -> stock = $stock;
    $classItems -> description = $description;
    $classItems -> status = $status;
    
    //エラーチェック
    try {
        //エラークラス初期化　$e = null
        CommonError::errorClear();
        
        //バリデーション（エラーがあればCommonErrorにメッセージを入れる）
        $classItems -> checkItemName();
        $classItems -> checkCategoryId();
        $classItems -> checkBrandId();
        $classItems -> checkEventId();
        $classItems -> checkPrice();
        $classStocks -> checkStock();
        //ファイル名を生成するか既存のファイル名を使用するか判定
        if (isset($icon_img) === true) {
            $icon_name = $classItems -> checkFileName($icon_img);//拡張子の確認
        } else {
            $icon_name = $exists_icon;
        }

        //エラーがあればthrow
        CommonError::errorThrow();
        
    } catch (Exception $e) {
        //エラーメッセージ取得
        $errors = CommonError::errorWhile();
        
        $records[0] = $classItems -> editItem();
        $records['categorys'] = Categorys::selectOption_Categorys();
        $records['brands'] = Brands::selectOption_Brands();
        $records['events'] = Events::selectOption_Events();
        
        //エラーメッセージを添えて再度render
        return View::render('edit', ['records' => $records, 'errors' => $errors]);
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
        //ファイルのプロパティ登録
        $classItems -> icon_img = $icon_name;
        
        //指定レコードの編集（itemsテーブル）executeBySql()
        $classItems -> updateItem();
        
        //指定レコードの編集（stocksテーブル）
        $classStocks -> updateStock();

        //画像のファイルアップロード（できなければrollback）
        if (isset($icon_img) === true) {
            $classItems -> uploadFiles($icon_img, $icon_name);
        }
        
        Database::commit();
        
    } catch (Exception $e) {
        $e = new Exception('データベースに接続できませんでした', 0, $e);
        //トランザクションでのエラーはcontrollerでキャッチしてもらう(error.tpl.phpへ)
        throw $e;
        
        Database::rollback();
    }
    
    //フラッシュメッセージ
    Session::setFlash('ID' . h($id) .':アイテム情報を変更しました');
    
    //indexへリダイレクト
    return View::redirectTo('admin_items', 'index');
}
