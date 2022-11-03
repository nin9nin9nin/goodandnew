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
    
    $id = Request::get('event_id');

    if (preg_match('/^\d+$/', $id) !== 1) {
        return View::render404();
    }

    //フォームの値を取得
    $name = Request::get('event_name');
    $description = Request::get('description');
    $event_date = Request::get('event_date');
    $event_tag = Request::get('event_tag');
    $event_svg = Request::getFiles('event_svg');
    $event_png = Request::getFiles('event_png');
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
        //生成したファイル名の受け取り
        $svg_name = $classEvents -> checkFileName($event_svg);
        $png_name = $classEvents -> checkFileName($event_png);
        
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
    
    $now_date = date('Y-m-d H:i:s');
    
    //プロパティ登録日時
    $classEvents -> update_datetime = $now_date;
    
    //指定レコードの編集（eventsテーブル）executeBySql()
    $classEvents -> updateEvent();
        
    //フラッシュメッセージ
    Session::setFlash('変更に成功しました');
    
    //indexへリダイレクト
    return View::redirectTo('admin_events', 'index');
}
