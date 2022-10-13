<?php

require_once(MODEL_DIR . '/Tables/Shops.php');

function execute_action() {
    $id = Request::get('shop_id');

    if (preg_match('/^\d+$/', $id) !== 1) {
        return View::render404();
    }
    
    //クラス生成（初期化）
    $classShops = new Shops();
    
    //プロパティに値をセット
    $classShops -> shop_id = $id;
    
    //指定レコードの取得
    $records[0] = $classShops -> editShop();
        
    
    return View::render('edit', ['records' => $records]);
}