<?php
//全削除はまだ怖いので
// require_once(MODEL_DIR . '/Tables/Categorys.php');

function execute_action() {
    if (!Request::isPost()) {
        return View::render404();
    }
    
    $table = Request::get('table');
    
    //クラス生成（初期化）
    $classCategorys = new Categorys();
    
    //データベース接続
    $classCategorys -> deleteAll($table);
        
    
    return View::redirectTo('admin_categorys', 'index');
        
}

