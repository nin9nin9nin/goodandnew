<?php
require_once(MODEL_DIR . '/Tables/Admin.php');

function execute_action() {
    
    // //$_SESSION['admin']を受け取る (なければfalse)
    // $admin = Session::getSession('admin',false);
    
    // //クッキーも受け取る（なければ空）
    // $cookie_check = Cookie::getCookieCheck();
    // $cookie_name = Cookie::getCookieName();
    
    
    //ログイン画面へ（初期値はそれぞれ空の状態）
    return View::render('signin');
}