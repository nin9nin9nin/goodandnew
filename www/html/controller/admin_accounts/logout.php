<?php

require_once(MODEL_DIR . '/Tables/Admin.php');

function execute_action() {
    if (!Request::isPost()) {
        return View::render404();
    }
    
    Session::start();
    //セッションを空にする $_SESSION = array();
    Session::clear();
    
    //$_SESSION['_authenticated']をfalseにする（認証状態を解除する）
    //session_regenerate_idで現在のセッションIDを新しく生成したものと置き換える
    Session::setAuthenticated(false);

    // セッション名取得 ※デフォルトはPHPSESSID
    $session_name = session_name();
    
    // ユーザのCookieに保存されているセッションIDを削除
    Cookie::deleteCookieSessionId($session_name);
    
    // セッションIDを無効化
    session_destroy();
    
    
    //　クッキーはそのまま
    // Cookie::clearCookieCheck();
    // Cookie::clearCookieName();
    
    //フラッシュメッセージをセット
    Session::setFlash('ログアウトしました');
    
    //ログイン画面へ戻る
    return View::render('signin');

}