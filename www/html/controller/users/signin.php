<?php
require_once(MODEL_DIR . '/Tables/Users.php');

function execute_action() {
    Session::start();
    //認証済みか判定 ($_SESSION['_authenticated'](bool)を受け取る)
    if (Session::isAuthenticated() === true) {
        //すでに認証済みであればアカウントページへリダイレクトを行う
        return View::redirectTo('users', 'account');
        exit;
    }

    //トークン作成　CSRF対策(POST投稿を行うフォームに対して必ず行う)
    Session::setCsrfToken();
        
    //ログイン画面へ（初期値はそれぞれ空の状態）
    return View::render('login');
}