<?php
//全削除はまだ怖いので
// require_once(MODEL_DIR . '/Tables/Items.php');

function execute_action() {
    if (!Request::isPost()) {
        return View::render404();
    }
    
    $table = Request::get('table');
    
    //クラス生成（初期化）
    $classItems = new Items();
    
    //データベース接続
    $classItems -> deleteAllItem($table);
    
    return View::redirectTo('admin_items', 'index');    
}
