<?php
require_once(MODEL_DIR . '/Tables/Users.php');

function execute_action() {
    //すでにitems/index.phpにて認証確認済み(無効状態)
    
    
    //クッキーを受け取る（なければ空）
    //$_COOKIE['cookie_check'], $_COOKIE['user_name']
    $cookie_check = Cookie::getUserCookieCheck();
    $cookie_name = Cookie::getUserCookieName();
    
    
    //ログイン画面へ（初期値はそれぞれ空の状態）
    return View::render('login', ['cookie_check' => $cookie_check, 'cookie_name' => $cookie_name,]);
}