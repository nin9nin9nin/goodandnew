<?php

require_once(MODEL_DIR . '/Tables/Brands.php');
require_once(MODEL_DIR . '/Tables/Categorys.php');

function execute_action() {
    $id = Request::get('brand_id');

    if (preg_match('/^\d+$/', $id) !== 1) {
        return View::render404();
    }
    
    //クラス生成（初期化）
    $classBrands = new Brands();
    
    //プロパティに値をセット
    $classBrands -> brand_id = $id;
    
    //指定レコードの取得
    $records[0] = $classBrands -> editBrand();
    
    //マンスリー選択用にcategorysテーブル取得(parent_id = 2のみ)
    $records['categorys'] = Categorys::selectOption_Monthly();
    
    
    return View::render('edit', ['records' => $records]);
}