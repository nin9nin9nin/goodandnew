<?php

require_once(MODEL_DIR . '/Tables/Categorys.php');

function execute_action() {
    $id = Request::get('category_id');

    if (preg_match('/^\d+$/', $id) !== 1) {
        return View::render404();
    }
    
    //クラス生成（初期化）
    $classCategorys = new Categorys();
    
    //プロパティに値をセット
    $classCategorys -> category_id = $id;
    
    //データベース接続（delete）
    $classCategorys -> deleteCategory();
    
    
    return View::redirectTo('admin_categorys', 'index');
}
