<?php

require_once(MODEL_DIR . '/Tables/Brands.php');

function execute_action() {
    if (!Request::isPost()) {
        return View::render404();
    }
    
    $status = Request::get('status');
    $id = Request::get('brand_id');
    
    if (preg_match('/^\d+$/', $id) !== 1) {
        return View::render404();
    }
    
    //クラス生成（初期化）
    $classBrands = new Brands();
    
    //プロパティに値をセット
    $classBrands -> brand_id = $id;
    $classBrands -> status = $status;
    
    //更新処理 -----------------------------------------------------
    
    $now_date = date('Y-m-d H:i:s');
    
    $classBrands -> update_datetime = $now_date;
    
    //データベース接続（update）
    $classBrands -> updateStatus();
    
    //フラッシュメッセージをセット
    Session::getInstance() -> setFlash('ステータスを更新しました');
    
    return View::redirectTo('admin_brands', 'index');
}
