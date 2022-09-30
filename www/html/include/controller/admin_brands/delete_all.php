<?php
//全削除はまだ怖いので
// require_once(MODEL_DIR . '/Tables/Brands.php');

function execute_action() {
    if (!Request::isPost()) {
        return View::render404();
    }
    
    $table = Request::get('table');
    
    //クラス生成（初期化）
    $classBrands = new Brands();
    
    //データベース接続
    $classBrands -> deleteAll($table);
        
    
    return View::redirectTo('admin_brands', 'index');

}

