<?php
require_once(MODEL_DIR . '/Tables/Shops.php');

function execute_action() {
    if (!Request::isPost()) {
        return View::render404();
    }
    
    $status = Request::get('status');
    $id = Request::get('shop_id');
    
    if (preg_match('/^\d+$/', $id) !== 1) {
        return View::render404();
    }
    
    //クラス生成（初期化）
    $classShops = new Shops();
    
    //プロパティに値をセット
    $classShops -> shop_id = $id;
    $classShops -> status = $status;
    
    //更新処理 -----------------------------------------------------
    
    $now_date = date('Y-m-d H:i:s');
    
    $classShops -> update_datetime = $now_date;
    
    //データベース接続（update）
    $classShops -> updateStatus();
    
    //フラッシュメッセージをセット
    Session::getInstance() -> setFlash('ステータスを更新しました');
    
    return View::redirectTo('admin_shops', 'index');
}
