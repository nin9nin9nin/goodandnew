<?php

require_once(MODEL_DIR . '/Tables/Brands.php');

function execute_action() {
    $id = Request::get('brand_id');

    if (preg_match('/^\d+$/', $id) !== 1) {
        return View::render404();
    }
    
    //クラス生成（初期化）
    $classBrands = new Brands();
    
    //プロパティに値をセット
    $classBrands -> brand_id = $id;
    
    //データベース接続（指定レコードのみ削除）
    $classBrands -> deleteBrand();
    
    
    return View::redirectTo('admin_brands', 'index');
}
