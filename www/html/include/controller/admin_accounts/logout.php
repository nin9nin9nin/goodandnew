<?php

require_once(MODEL_DIR . '/Tables/Admin.php');

function execute_action() {
    if (!Request::isPost()) {
        return View::render404();
    }
    
    //セッションを空にする $_SESSION = array();
    Session::getInstance() -> clear();
    
    //$_SESSION['_authenticated']をfalseにする（認証状態を解除する）
    //session_regenerate_idで現在のセッションIDを新しく生成したものと置き換える(session_destory()と動作がかぶる？)
    Session::setAuthenticated(false);

    // セッション名取得 ※デフォルトはPHPSESSID
    $session_name = session_name();
    
    // ユーザのCookieに保存されているセッションIDを削除
    Cookie::deleteCookieSessionId($session_name);
    
    // セッションIDを無効化
    session_destroy();
    
    
    //　クッキーはそのまま(cookie_checkしてるから)
    // Cookie::clearCookieCheck();
    // Cookie::clearCookieName();
    
    //フラッシュメッセージをセット
    // Session::setFlash('ログアウトしました');
    
    //ログイン画面へリダイレクト
    return View::redirectTo('admin_accounts', 'signin');

}