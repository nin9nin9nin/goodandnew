<?php
require_once(MODEL_DIR . '/Tables/Users.php');

function execute_action() {
    if (!Request::isPost()) {
        return View::render404();
    }
    
    $name = Request::get('user_name');
    $email = Request::get('email');
    $password = Request::get('password');
    $cookie_check = Request::get('cookie_check');
    
    //クラス生成（初期化）
    $classUsers = new Users();
    
    //プロパティに値をセット
    $classUsers -> user_name = $name;
    $classUsers -> email = $email;
    $classUsers -> password = $password;
    
    //エラーチェック
    try {
        //エラークラス初期化　$e = null
        CommonError::errorClear();
            
        //バリデーション（エラーがあればCommonErrorにメッセージを入れる）
        $classUsers -> checkUserName();
        $classUsers -> checkEmail();
        $classUsers -> checkPassword();
        
        //データベースと照合
        $classUsers -> checkUniqueUserName();
        
        //$e !== null
        CommonError::errorThrow();
        
        
    } catch (Exception $e) {
        //エラーメッセージ格納
        $errors = CommonError::errorWhile();
        
        //クッキーの取得（空）
        $cookie_check = Cookie::getUserCookieCheck();
        $cookie_name = Cookie::getUserCookieName();
        
        //ログイン画面へ（初期値はそれぞれ空の状態）
        return View::render('login', ['cookie_check' => $cookie_check, 'cookie_name' => $cookie_name, 'errors' => $errors,]);
        exit;
    }
    
    //登録処理 ----------------------------------
    
    //パスワードをハッシュ化
    $classUsers->passwordHash();
    
    //登録日時セット
    $now_date = date('Y-m-d H:i:s');
    
    $classUsers->create_datetime = $now_date;
    
    //usersテーブルに登録
    $classUsers->insertUser();
    
    //情報取得------------------------------------------------
    //セッションはログイン後に登録
    
    // //user_nameからuser情報取得(passwprd除く)
    // $record = $classUsers -> selectUserName();
    
    // //$_SESSION['']を作成・値を入れる
    // Session::set('user', $record);
    
    // //$_SESSION['admin']を受け取る (なければfalse)
    // $admin = Session::get('user',false);
    
    //['cookie_check']によってクッキーを保存or空保存
    Cookie::setUserCookie($cookie_check, $name);
    
    //フラッシュメッセージをセット
    Session::getInstance()->setFlash('ユーザーを登録しました');
    
    //登録して再度signinにリダイレクト
    return View::redirectTo('users', 'signin');
    
}