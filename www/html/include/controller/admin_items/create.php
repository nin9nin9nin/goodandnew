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

    // CSRF対策(POST投稿を行うフォームに対して必ず行う)
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

    //ページIDの取得（なければ1が格納される）
    $page_id = Request::getPageId('page_id');
    
    if (preg_match('/^\d+$/', $page_id) !== 1) {
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
    $imgs = Request::getMultipleFiles('img'); //reArray処理済み
    $status = Request::getStatus('status'); //初期値設定0

    
    //クラス生成（初期化）
    $classItems = new Items();
    $classStocks = new Stocks();
    
    //プロパティに値をセット
    $classItems -> page_id = $page_id;
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
        //生成したファイル名の受け取り
        $icon_name = $classItems -> checkFileName($icon_img);
        $img_names = $classItems -> checkMultipleFileName($imgs);
        
        //エラーがあればthrow
        CommonError::errorThrow();
        
    } catch (Exception $e) {
        //エラーメッセージ取得
        $errors = CommonError::errorWhile();
            
        $records['items'] = $classItems -> indexItems();
        $records['categorys'] = Categorys::selectOption_Categorys();
        $records['brands'] = Brands::selectOption_Brands();
        $records['events'] = Events::selectOption_Events();
        $paginations = $classItems -> getPaginations();
        
        //renderでエラーメッセージを表示
        return View::render('index', ['records' => $records, 'paginations' => $paginations, 'errors' => $errors]);
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
        //ファイルのプロパティ登録
        $classItems -> icon_img = $icon_name;
        $classItems -> registerMultipleFiles($img_names);

        //itemsテーブルに新規登録　executeBySql()
        $classItems -> insertItem();
        
        //stock登録　item_idの取得
        $item_id = Database::lastInsertId();
        
        //プロパティ　stocksテーブルにitem_idをセット
        $classStocks -> item_id = $item_id;
        
        //stocksテーブルに新規登録　executeBySql()
        $classStocks -> insertStock();

        //画像のファイルアップロード（できなければrollback）
        $classItems -> uploadFiles($icon_img, $icon_name);
        $classItems -> uploadMultipleFiles($imgs, $img_names);
        
        Database::commit();
      
    } catch (Exception $e) {
        $e = new Exception('データベースに接続できませんでした', 0, $e);
        //トランザクションでのエラーはcontrollerでキャッチしてもらう(error.tpl.phpへ)
        throw $e;
        
        Database::rollback();
    }
    
    //フラッシュメッセージをセット
    Session::setFlash('アイテムを登録しました');
    
    return View::redirectTo('admin_items', 'index');
}
