<?php
require_once(MODEL_DIR . '/Tables/Items.php');

function execute_action() {
    $id = Request::get('item_id');

    if (preg_match('/^\d+$/', $id) !== 1) {
        return View::render404();
    }
    
   
   //クラス生成（初期化）
    $classItems = new Items();
    
    //プロパティに値をセット
    $classItems -> item_id = $id;
    
    //指定レコードの取得
    $records[0] = $classItems -> editItem();
    
    
    return View::render('img_edit', ['records' => $records]);
}