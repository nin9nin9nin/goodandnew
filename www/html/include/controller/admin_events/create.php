<?php

require_once(MODEL_DIR . '/Tables/Events.php');

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

        return View::redirectTo('admin_events', 'index');
        exit;
    }

    //ページIDの取得（なければ1が格納される）
    $page_id = Request::getPageId('page_id');

    // フォームの値を取得
    $name = Request::get('event_name');
    $description = Request::get('description');
    $event_date = Request::get('event_date');
    $event_tag = Request::get('event_tag');
    $event_svg = Request::get('event_svg');
    $event_png = Request::get('event_png');
    $status = Request::get('status');
    
    //クラス生成（初期化）
    $classEvents = new Events();
    
    //プロパティに値をセット
    $classEvents -> page_id = $page_id;
    $classEvents -> event_name = $name;
    $classEvents -> description = $description;
    $classEvents -> event_date = $event_date;
    $classEvents -> event_tag = $event_tag;
    $classEvents -> event_svg = $event_svg;
    $classEvents -> event_png = $event_png;
    $classEvents -> status = $status;
    
    //エラーチェック
    try {
        //エラークラス初期化　$e = null
        CommonError::errorClear();
        
        //バリデーション（エラーがあればCommonErrorにメッセージを入れる）
        $classEvents -> checkEventName();
        $classEvents -> checkEventDate();
        $classEvents -> checkEventSvg();
        $classEvents -> checkEventPng();
        
        //エラーがあればthrow
        CommonError::errorThrow();
        
    } catch (Exception $e) {
        //エラーメッセージ取得
        $errors = CommonError::errorWhile();

        //ページネーションに必要な値一式
        $paginations = $classEvents -> getPaginations();

        //recordの取得　（page_idから指定した分だけ/10アイテムのみ）
        $records['events'] = $classEvents -> indexEvents();
        
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
        $classEvents -> create_datetime = $now_date;
        $classStocks -> create_datetime = $now_date;
        
        //itemsテーブルに新規登録　executeBySql()
        $classEvents -> insertEvent();
        
        //item_idの取得
        $item_id = Database::lastInsertId();
        
        //プロパティ　stocksテーブルにitem_idをセット
        $classStocks -> item_id = $item_id;
        
        //stocksテーブルに新規登録　executeBySql()
        $classStocks -> insertStock();
        
        //画像のファイルアップロード（できなければrollback）
        $classEvents -> uploadIconImg();
        $classEvents -> uploadImg();

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
