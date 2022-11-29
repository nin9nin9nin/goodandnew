<?php

require_once(MODEL_DIR . '/Tables/Brands.php');

function execute_action() {
    $id = Request::get('brand_id');

    if (preg_match('/^\d+$/', $id) !== 1) {
        return View::render404();
    }

    Session::start();
    //トークンの作成
    Session::setCsrfToken();
    
    //クラス生成（初期化）
    $classBrands = new Brands();
    
    //プロパティに値をセット
    $classBrands -> brand_id = $id;
    
    //指定レコードの取得
    $record = $classBrands -> editBrand(); 
    
    return View::render('edit', ['record' => $record]);
}