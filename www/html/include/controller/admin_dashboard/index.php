<?php
//機能を継承し拡張したクラスの読み込み
require_once(MODEL_DIR . '/Tables/Dashboards.php');

function execute_action() {
    
    Session::start();
    //認証済みか判定 ($_SESSION['_authenticated']を受け取る)
    $session = Session::isAuthenticated();

    if ($session !== true) {
        //認証済みでなければサインインにリダイレクト
        return View::redirectTo('admin_accounts', 'signin');
        exit;
        
    } else { 
        //認証済みであればダッシュボードを読み込み
       
        //Newsとトピックスを受け取り
        
        
        
        
        //ログインしてダッシュボード画面を読み込む
        return View::render('index');
    }
}