<?php
require_once(MODEL_DIR . '/Tables/Users.php');

function execute_action() {
    if (!Request::isPost()) {
        return View::render404();
    }
        
    $name = Request::get('user_name');
    $password = Request::get('password');
    $cookie_check = Request::get('cookie_check');
    
    //クラス生成（初期化）
    $classUsers = new Users();

    //プロパティに値をセット
    $classUsers -> user_name = $name;
    $classUsers -> password = $password;
    
    //エラーチェック
    try {
        //エラークラス初期化　$e = null
        CommonError::errorClear();
            
        //バリデーション（エラーがあればCommonErrorにメッセージを入れる）
        $classUsers -> checkloginUserName();
        $classUsers -> checkloginPassword();
        
        //$e !== null
        CommonError::errorThrow();
        
    } catch (Exception $e) {
        //エラーメッセージ格納
        $errors = CommonError::errorWhile();
        
        //クッキーの取得（空）
        $cookie_check = Cookie::getUserCookieCheck();
        $cookie_name = Cookie::getUserCookieName();
        
        //ログイン画面へ（初期値はそれぞれ空の状態）
        return View::render('login', ['cookie_check' => $cookie_check, 'cookie_name' => $cookie_name,'errors' => $errors]);
        exit;
    }
                
    //$_SESSION['_authenticated']を認証済みにする
    //session_regenerate_idで現在のセッションIDを新しく生成したものと置き換える
    Session::getInstance() -> setAuthenticated(true);
    
    //情報取得------------------------------------------------
    //user_nameからuser情報取得(passwprd除く)
    $record = $classUsers -> selectUserName();
    
    //管理者画面へリダイレクト
    if ($record->user_name === 'admin') {
        //$_SESSION['']を作成・値を入れる
        Session::set('admin_name', $record->user_name);
        Session::set('admin_id', $record->user_id);
        
        //['cookie_check']によってクッキーを保存or削除
        Cookie::setCookie($cookie_check, $name);
        
        //フラッシュメッセージをセット
        Session::setFlash('管理者としてログインしました');
        
        //ログインした状態でダッシュボードにリダイレクト
        return View::redirectTo('dashboard', 'index');
        
    //ユーザー画面へリダイレクト
    } else {
        //$_SESSION['']を作成・値を入れる
        Session::set('user', $record);
        
        //['cookie_check']によってクッキーを保存or削除
        Cookie::setUserCookie($cookie_check, $name);
        
        //フラッシュメッセージをセット
        Session::setFlash('ユーザーログインに成功しました');
        
        //ログインした状態でitems/index.phpにリダイレクト
        return View::redirectTo('items', 'index');
    }
    
}