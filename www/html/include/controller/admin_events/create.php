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
    
    if (preg_match('/^\d+$/', $page_id) !== 1) {
        return View::render404();
    }

    // フォームの値を取得
    $name = Request::get('event_name');
    $description = Request::get('description');
    $event_date = Request::get('event_date');
    $event_tag = Request::get('event_tag');
    $event_svg = Request::getFiles('event_svg'); //初期値NULL
    $event_png = Request::getFiles('event_png'); //初期値NULL
    $imgs = Request::getMultipleFiles('img'); //reArray処理済み
    $status = Request::getStatus('status'); //初期値設定0
    
    //クラス生成（初期化）
    $classEvents = new Events();
    
    //プロパティに値をセット(画像ファイル名はバリデーション後にセット)
    $classEvents -> page_id = $page_id;
    $classEvents -> event_name = $name;
    $classEvents -> description = $description;
    $classEvents -> event_date = $event_date;
    $classEvents -> event_tag = $event_tag;
    $classEvents -> status = $status;
    
    //エラーチェック
    try {
        //エラークラス初期化　$e = null
        CommonError::errorClear();
        
        //バリデーション（エラーがあればCommonErrorにメッセージを入れる）
        $classEvents -> checkEventName();
        $classEvents -> checkEventDate();
        $classEvents -> checkEventTag();
        //生成したファイル名の受け取り
        $svg_name = $classEvents -> checkFileName($event_svg);
        $png_name = $classEvents -> checkFileName($event_png);
        $img_names = $classEvents -> checkMultipleFileName($imgs);
        
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
        
        //プロパティ日時登録+生成したファイル名登録
        $classEvents -> create_datetime = $now_date;
        $classEvents -> event_svg = $svg_name;
        $classEvents -> event_png = $png_name;

        //複数ファイルのプロパティ登録
        $classEvents -> registerMultipleFiles($img_names);

        //eventsテーブルに新規登録　executeBySql()
        $classEvents -> insertEvent();
        
        //画像のファイルアップロード（できなければrollback）
        $classEvents -> uploadFiles($event_svg, $svg_name);
        $classEvents -> uploadFiles($event_png, $png_name);
        $classEvents -> uploadMultipleFiles($imgs, $img_names);

        Database::commit();
      
    } catch (Exception $e) {
        $e = new Exception('データベースに接続できませんでした', 0, $e);
        //トランザクションでのエラーはcontrollerでキャッチしてもらう(error.tpl.phpへ)
        throw $e;
        
        Database::rollback();
    }
    
    //フラッシュメッセージをセット
    Session::setFlash('商品を登録しました');
    
    return View::redirectTo('admin_events', 'index');
}
