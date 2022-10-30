<?php

require_once(MODEL_DIR . '/Tables/Admin.php');

function execute_action() {
    //POSTの確認
    if (!Request::isPost()) {
        return View::render404();
    }
        
    $name = Request::get('admin_name');
    $password = Request::get('password');
    $cookie_check = Request::get('cookie_check');
    
    //クラス生成（初期化）
    $classAdmin = new Admin();

    //プロパティに値をセット
    $classAdmin -> admin_name = $name;
    $classAdmin -> password = $password;
    
    //エラーチェック
    try {
        //エラークラス初期化　$e = null
        CommonError::errorClear();
            
        //バリデーション（エラーがあればCommonErrorにメッセージを入れる）
        $classAdmin -> checkloginAdminName();
        $classAdmin -> checkloginPassword();
        
        //$e !== null
        CommonError::errorThrow();
        
    } catch (Exception $e) {
        
        //エラーメッセージ取得
        $errors = CommonError::errorWhile();
        
        //フラッシュメッセージ
        Session::setFlash('ログインに失敗しました');

        return View::render('signin', ['errors' => $errors]);
        exit;
    }
    
    Session::start();
    //$_SESSION['_authenticated']を認証済みにする(true)
    //session_regenerate_idで現在のセッションIDを新しく生成したものと置き換える
    Session::setAuthenticated(true);
    
    //情報登録------------------------------------------------
    //admin_nameからadmin情報取得(passwprd除く)
    $record = $classAdmin -> selectAdminName();
    
    //$_SESSION['admin']を作成・値を入れる
    Session::set('admin_name', $record->admin_name);
    //アカウント管理の際に使用
    Session::set('admin_id', $record->admin_id);
    
    //フラッシュメッセージをセット
    Session::setFlash('ログインに成功しました');
    
    //['cookie_check']によってクッキーを保存or削除
    Cookie::setCookie($cookie_check, $name);
    
    //ログインした状態でダッシュボードにリダイレクト
    return View::redirectTo('admin_dashboard', 'index');
    
}