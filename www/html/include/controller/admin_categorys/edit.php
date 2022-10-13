<?php

require_once(MODEL_DIR . '/Tables/Categorys.php');

function execute_action() {
    $category_id = Request::get('category_id');

    if (preg_match('/^\d+$/', $category_id) !== 1) {
        return View::render404();
    }
    
    //クラス生成（初期化）
    $classCategorys = new Categorys();
    
    //プロパティに値をセット
    $classCategorys -> category_id = $category_id;
    
    //指定レコードの取得 retrieveBySql()
    $records[0] = $classCategorys -> editCategory();
    
    //parent_id select用 findBySql()
    $records['parents'] = $classCategorys -> selectOption_Parents();
    

    return View::render('edit', ['records' => $records]);
    
}