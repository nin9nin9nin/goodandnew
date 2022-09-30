<?php
//全削除はまだ怖いので
// require_once(MODEL_DIR . '/Tables/Shops.php');

function execute_action() {
    if (!Request::isPost()) {
        return View::render404();
    }
    
    $table = Request::get('table');
    
    //クラス生成（初期化）
    $classShops = new Shops();
    
    //データベース接続
    $classShops -> deleteAll($table);
        
    
    return View::redirectTo('admin_shops', 'index');

}