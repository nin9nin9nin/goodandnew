<?php

require_once(MODEL_DIR . '/Tables/Categorys.php');

function execute_action() {
    if (!Request::isPost()) {
        return View::render404();
    }
    
    $status = Request::get('status');
    $id = Request::get('category_id');
    
    if (preg_match('/^\d+$/', $id) !== 1) {
        return View::render404();
    }
    
    //クラス生成（初期化）
    $classCategorys = new Categorys();
    
    //プロパティに値をセット
    $classCategorys -> category_id = $id;
    $classCategorys -> status = $status;
    
    //更新処理 -----------------------------------------------------
    
    $now_date = date('Y-m-d H:i:s');
    
    $classCategorys -> update_datetime = $now_date;
    
    //データベース接続（update）
    $classCategorys -> updateStatus();
    
    //フラッシュメッセージをセット
    Session::getInstance() -> setFlash('ステータスを更新しました');
    
    return View::redirectTo('admin_categorys', 'index');
}
