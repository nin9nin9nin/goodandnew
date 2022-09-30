<?php
require_once(MODEL_DIR . '/Tables/Items.php');

function execute_action() {
    if (!Request::isPost()) {
        return View::render404();
    }
    
    $status = Request::get('status');
    $id = Request::get('item_id');
    
    var_dump($id);
    if (preg_match('/^\d+$/', $id) !== 1) {
        return View::render404();
    }
    
    //クラス生成（初期化）
    $classItems = new Items();
    
    //プロパティに値をセット
    $classItems -> item_id = $id;
    $classItems -> status = $status;
    
    //更新処理 -----------------------------------------------------
    $now_date = date('Y-m-d H:i:s');
    
    $classItems -> update_datetime = $now_date;
    
    //データベース接続（update）
    $classItems -> updateStatus();
    
    //フラッシュメッセージをセット
    Session::getInstance() -> setFlash('ステータスを更新しました');
    
    
    return View::redirectTo('admin_items', 'index');
}
