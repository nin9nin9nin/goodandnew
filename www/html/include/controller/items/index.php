<?php
require_once(MODEL_DIR . '/Tables/Items.php');

function execute_action() {
    // //認証済みか判定 ($_SESSION['_authenticated']を受け取る)
    // $session = Session::getInstance() -> isAuthenticated();
    
    // if ($session !== true) {
    //     //認証済みでなければサインアップにリダイレクト (ログイン画面に移行される)
    //     return View::redirectTo('users', 'signin');
    //     exit;
    // }
    
    //プロパティ初期化(パラメータ)
    Items::paramClear();
    
    //マンスリーアイテム取得　@param = category_id 4 [2021年1月]
    $records['monthly'] = Items::indexItems_selectMonthly(4);
    
    //ブランド一覧取得　@param = category_id 4 [2021年1月]
    $records['brands'] = Items::indexItems_selectMonthlyBrands(4);
    
    //オリジナルアイテム取得　@param = category_id 41 [オリジナルアイテム]
    $records['original'] = Items::indexItems_selectGenre(41);
    
    
    
    return View::render('index', ['records' => $records]);
}