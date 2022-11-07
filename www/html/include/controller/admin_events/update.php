<?php

require_once(MODEL_DIR . '/Tables/Events.php');

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

        return View::redirectTo('admin_events', 'index');
        exit;
    }
    
    //hidden
    $id = Request::get('event_id');

    if (preg_match('/^\d+$/', $id) !== 1) {
        return View::render404();
    }

    //フォームの値を取得
    $name = Request::get('event_name');
    $description = Request::get('description');
    $event_date = Request::get('event_date');
    $event_tag = Request::get('event_tag');
    $event_svg = Request::getFiles('event_svg'); //初期値NULL
    $exists_svg = Request::get('exists_svg'); // $_POST['exists_svg']既存のファイル名
    $event_png = Request::getFiles('event_png'); //初期値NULL
    $exists_png = Request::get('exists_png'); // $_POST['exists_svg']既存のファイル名
    $status = Request::getStatus('status');
    
    
    //クラス生成（初期化）
    $classEvents = new Events();
    
    //プロパティに値をセット
    $classEvents -> event_id = $id;
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
        //ファイル名を生成するか既存のファイル名を使用するか判定
        if (isset($event_svg) === true) {
            $svg_name = $classEvents -> checkFileName($event_svg);//拡張子の確認
        } else {
            $svg_name = $exists_svg;
        }
        if (isset($event_png) === true) {
            $png_name = $classEvents -> checkFileName($event_png);//拡張子の確認
        } else {
            $png_name = $exists_png;
        }

        //エラーがあればthrow
        CommonError::errorThrow();
        
    } catch (Exception $e) {
        //エラーメッセージ取得
        $errors = CommonError::errorWhile();

        $record = $classEvents -> editEvent();  
           
        //エラーメッセージを添えて再度render
        return View::render('edit', ['record' => $record, 'errors' => $errors]);
        exit;
    }
    
    //更新処理------------------------------------------------------------------
    //データベース接続と画像のアップロード
    Database::beginTransaction();
    try {
        $now_date = date('Y-m-d H:i:s');
        
        //ここで更新日時とファイル名をプロパティに登録
        $classEvents -> update_datetime = $now_date;
        $classEvents -> event_svg = $svg_name;
        $classEvents -> event_png = $png_name;

        //指定レコードの編集（eventsテーブル）executeBySql()
        $classEvents -> updateEvent();
        
        //画像のファイルアップロード（できなければrollback）
        if (isset($event_svg) === true) {
            $classEvents -> uploadFiles($event_svg, $svg_name);
        }
        if (isset($event_png) === true) { 
            $classEvents -> uploadFiles($event_png, $png_name);
        }

        Database::commit();
      
    } catch (Exception $e) {
        $e = new Exception('データベースに接続できませんでした', 0, $e);
        //トランザクションでのエラーはcontrollerでキャッチしてもらう(error.tpl.phpへ)
        throw $e;
        
        Database::rollback();
    }
        
    //フラッシュメッセージ
    Session::setFlash('変更に成功しました');
    
    //indexへリダイレクト
    return View::redirectTo('admin_events', 'index');
}
