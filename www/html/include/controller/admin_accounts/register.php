<?php

require_once(MODEL_DIR . '/Tables/Admin.php');

function execute_action() {
    if (!Request::isPost()) {
        return View::render404();
    }
    
    $name = Request::get('admin_name');
    $email = Request::get('email');
    $password = Request::get('password');
    $cookie_check = Request::get('cookie_check');
    
    
    //クラス生成（初期化）
    $classAdmin = new Admin();
    
    //プロパティに値をセット
    $classAdmin -> admin_name = $name;
    $classAdmin -> email = $email;
    $classAdmin -> password = $password;
    
    //エラーチェック
    try {
        //エラークラス初期化　$e = null
        CommonError::errorClear();
            
        //バリデーション（エラーがあればCommonErrorにメッセージを入れる）
        $classAdmin -> checkAdminName();
        $classAdmin -> checkEmail();
        $classAdmin -> checkPassword();
        
        //データベースと照合
        $classAdmin -> checkUniqueAdminName();
        
        //$e !== null
        CommonError::errorThrow();
        
    } catch (Exception $e) {
        
        $errors = CommonError::errorWhile();

        return View::render('signup', ['errors' => $errors]);
        exit;
    }
    
    //登録処理 ----------------------------------
    
    //パスワードをハッシュ化
    $classAdmin->passwordHash();
    
    //登録日時セット
    $now_date = date('Y-m-d H:i:s');
    
    $classAdmin->create_datetime = $now_date;

    //adminテーブルに登録
    $classAdmin->insertAdmin();
    
    //情報取得------------------------------------------------
    //admin_nameからadmin情報取得(passwprd除く)
    // $record = $classAdmin -> selectAdminName();
    
    //$_SESSION['admin']を作成・値を入れる
    // Session::set('admin_name', $record->admin_name);
    // Session::set('admin_id', $record->admin_id);
    
    //フラッシュメッセージをセット
    Session::getInstance() -> setFlash('登録に成功しました');
        
    //['cookie_check']によってクッキーを保存or削除
    Cookie::setCookie($cookie_check, $name);
    
    
    //登録して登録完了+ログイン画面を読み込む
    return View::redirectTo('admin_accounts', 'signin');
        
    // return View::render('admin_accounts', 'register');
}