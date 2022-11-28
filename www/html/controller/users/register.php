<?php
require_once(MODEL_DIR . '/Tables/Users.php');

function execute_action() {
    if (!Request::isPost()) {
        return View::render404();
    }

    // CSRF対策(POST投稿を行うフォームに対して必ず行う)
    $token = Request::get('token');

    Session::start();
    // postとsessionのトークンを照合（有効か確認）
    if (Session::isValidCsrfToken($token) !== true) {
        // 有効でなければリダイレクト
        Session::setFlash('不正な処理が行われました');

        return View::redirectTo('users', 'signin');
        exit;
    }
    
    //form/registerの値を取得
    $name = Request::get('reg_user_name');
    $email = Request::get('reg_email');
    $password = Request::get('reg_password');
    $cookie_check = Request::get('reg_cookie_check');
    
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
        
        //ログイン画面へ（初期値はそれぞれ空の状態）
        return View::render('login', ['errors' => $errors,]);
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
        
    //['cookie_check']によってクッキーを保存or空保存
    Cookie::setUserCookie($cookie_check, $name);
    
    //フラッシュメッセージをセット
    Session::setFlash('ユーザーを登録しました');
    
    //登録して再度signinにリダイレクト
    return View::redirectTo('users', 'signin');
    
}