<?php
require_once(MODEL_DIR . '/Tables/Items.php');

function execute_action() {
    $item_id = Request::get('item_id');

    if (preg_match('/^\d+$/', $item_id) !== 1) {
        return View::render404();
    }
    
    //クラス生成（初期化）
    $classItems = new Items();
    
    //プロパティに値をセット
    $classItems -> item_id = $item_id;
    
    //指定レコードの取得
    $records['item'] = $classItems -> getItemDetail();
    
    return View::render('original_detail', ['records' => $records]);
}