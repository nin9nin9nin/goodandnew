<?php

require_once(MODEL_DIR . '/Tables/Admin.php');

function execute_action() {
    $admin_id = Request::get('admin_id');
    
    if (preg_match('/^\d+$/', $admin_id) !== 1) {
        return View::render404();
    }
    
    //クラス生成
    $classAdmin = new Admin();
    
    //プロパティに値を入れる
    $classAdmin -> admin_id = $admin_id;
    
    //admin_idからデータを取得(全データ)
    $record = $classAdmin -> selectAdminId();
    
    
    return View::render('edit', ['record' => $record]);

}