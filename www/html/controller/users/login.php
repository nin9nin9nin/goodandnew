<?php
require_once(MODEL_DIR . '/Tables/Users.php');

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

        return View::redirectTo('users', 'signin');
        exit;
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
        
        //ログイン画面へ（初期値はそれぞれ空の状態）
        return View::render('login', ['errors' => $errors]);
        exit;
    }
                
    //$_SESSION['_authenticated']を認証済みにする
    //session_regenerate_idで現在のセッションIDを新しく生成したものと置き換える
    Session::setAuthenticated(true);
    
    //情報取得------------------------------------------------
    //user_nameからuser情報取得(passwprd除く)
    $record = $classUsers -> selectUserName();
    
    //情報登録------------------------------------------------
    //$_SESSION['user']を作成・値を入れる
    Session::set('user', $record); 
    
    //['cookie_check']によってクッキーを保存or削除
    Cookie::setUserCookie($cookie_check, $name);
    
    //フラッシュメッセージをセット
    Session::setFlash('ログインに成功しました');
    
    //ログインした状態でevents/index.phpにリダイレクト
    return View::redirectTo('events', 'index');    
}