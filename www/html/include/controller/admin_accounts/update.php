<?php

require_once(MODEL_DIR . '/Tables/Admin.php');

function execute_action() {
    // postの確認
    if (!Request::isPost()) {
        return View::render404();
    }

    Session::start();
    // postされたトークンの取得
    $token = Request::get('token');

    // postとsessionのトークンを照合（有効か確認）
    if (Session::isValidCsrfToken($token) !== true) {
        // 有効でなければindexへ戻る
        Session::setFlash('不正な処理が行われました');

        return View::redirectTo('admin_accounts', 'index');
        exit;
    }
    
    $name = Request::get('admin_name');
    $email = Request::get('email');
    $old_password = Request::get('old_password');
    $password = Request::get('password');
    $check_password = Request::get('check_password');
    
    $admin_id = Request::get('admin_id');
    $old_name = Request::get('old_admin_name');
    
    //クラス生成（初期化）
    $classAdmin = new Admin();
    
    //プロパティに値をセット
    $classAdmin -> admin_name = $name;
    $classAdmin -> email = $email;
    $classAdmin -> old_password = $old_password;
    
    $classAdmin -> admin_id = $admin_id;
    $classAdmin -> old_admin_name = $old_name;
    
    //エラーチェック
    try {
        //エラークラス初期化　$e = null
        CommonError::errorClear();
        
        //バリデーション（エラーがあればCommonErrorにメッセージを入れる）
        $classAdmin -> checkAdminName();
        $classAdmin -> checkEmail();
        
        //データベースと照合（旧パスワード）
        $classAdmin->checkUpdate_PasswordHash();
            
        //パスワード更新がある場合
        if ($password !== "") {
            
            //確認用パスワードの確認
            if ($password !== $check_password) {
                CommonError::errorAdd('新パスワードが確認できません');
            } else {
                //確認できればプロパティに値を入れる(新パスワード)
                $classAdmin -> password = $password;
                //バリデーション
                $classAdmin -> checkPassword();
            }
        } else {
            //旧パスワードを再格納
            $classAdmin -> password = $old_password;
        }
        
        //$e !== null
        CommonError::errorThrow();
        
    } catch (Exception $e) {
        
        //エラーメッセージ取得
        $errors = CommonError::errorWhile();
        
        //admin_idからデータを取得(全データ)
        $record = $classAdmin -> selectAdminId();

        return View::render('edit', ['record' => $record, 'errors' => $errors]);
        exit;
    }
    
    
    //更新処理----------------------------------------------        
    //パスワードをハッシュ化
    $classAdmin->passwordHash();
    
    //登録日時セット
    $now_date = date('Y-m-d H:i:s');
    
    $classAdmin -> update_datetime = $now_date;

    //adminテーブルを更新
    $classAdmin -> updateAdmin();
            
            
    //更新確認用データ取得(passwordを除く)
    $record = $classAdmin -> selectAdminName();
    
    //セッションから値を削除 unset($_SESSION['admin'])
    Session::remove('admin_name');
    //再度登録（念のためデータベースのデータを格納）
    Session::set('admin_name', $record -> admin_name);
    
    //クッキーネームを削除
    Cookie::clearCookieName();
    //削除してからクッキーネームのみ再登録
    $now = time();
    setcookie('cookie_name', $name, $now + 60 * 60 * 24 * 365);
    
    
    //フラッシュメッセージをセット
    Session::setFlash('アカウント情報を変更しました');
    
    //
    return View::redirectTo('admin_accounts', 'index');
}
