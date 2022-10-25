<?php

require_once(MODEL_DIR . '/Tables/Brands.php');

function execute_action() {
    //認証済みか判定 ($_SESSION['_authenticated']を受け取る)
    $session = Session::getInstance() -> isAuthenticated();
    
    if ($session !== true) {
        //認証済みでなければサインアップにリダイレクト (ログイン画面に移行される)
        return View::redirectTo('admin_accounts', 'signin');
        exit;
        
    } 
    //クラス生成（初期化）
    $classBrands = new Brands();
    
    //brandsテーブル取得
    $records['brands'] = $classBrands->indexBrands();
    
    //マンスリー選択用にcategorysテーブル取得(parent_id = 2のみ)
    $records['categorys'] = Categorys::selectOption_Monthly();
    
    
    return View::render('index', ['records' => $records]);
}