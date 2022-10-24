<?php

require_once(MODEL_DIR . '/Tables/Admin.php');

function execute_action() {
    
    Session::start();
    // //認証済みか判定 ($_SESSION['_authenticated']を受け取る)
    // $session = Session::isAuthenticated();

    // if ($session === true) {
    //     //認証済みであればダッシュボードにリダイレクト
    //     return View::redirectTo('admin_dashboard', 'index');
    //     exit;
        
    // }
    
    //新規登録画面へ（初期値はそれぞれ空の状態）
    return View::render('signup');
        
}